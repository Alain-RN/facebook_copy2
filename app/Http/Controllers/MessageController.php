<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MessageController extends Controller
{
    /**
     * Send a new message.
     */
    public function sendMessage(Request $request)
    {
        // Validation
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:255',
        ]);

        // Création du message
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        return response()->json($message);
    }

    public function getChatUsers()
    {
        $userId = auth()->id();
    
        $senderIds = Message::where('receiver_id', $userId)->pluck('sender_id');
        $receiverIds = Message::where('sender_id', $userId)->pluck('receiver_id');
        $allUserIds = $senderIds->merge($receiverIds)->unique()->filter(fn($id) => $id != $userId);
        
        $users = User::whereIn('id', $allUserIds)->get()->map(function ($user) use ($userId) {
            // Récupérer le dernier message envoyé à cet utilisateur ou par cet utilisateur
            $lastMessage = Message::where(function($query) use ($user, $userId) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function($query) use ($user, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $user->id);
            })
            ->latest()
            ->first();
            
            // Ajouter le dernier message à l'utilisateur
            $user->last_message = $lastMessage;
            
            return $user;
        });
    
        return response()->json($users);
    }

    /**
     * Show the conversation between the logged-in user and another user.
     */
    public function show($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $userId);
        })
        ->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark all unread messages as read
        Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show', compact('messages', 'userId'));
    }

    /**
     * Mark a message as read.
     */
    public function markAsRead($messageId)
    {
        $message = Message::findOrFail($messageId);
        
        if ($message->receiver_id === Auth::id()) {
            $message->update(['is_read' => true]);
        }

        return redirect()->back();
    }

    public function getMessages($receiver_id)
    {
        $messages = Message::where(function ($query) use ($receiver_id) {
            $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $receiver_id);
        })->orWhere(function ($query) use ($receiver_id) {
            $query->where('sender_id', $receiver_id)
                    ->where('receiver_id', auth()->id());
        })->get();
        return response()->json($messages);
    }
}
