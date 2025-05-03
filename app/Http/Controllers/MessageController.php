<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Send a new message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        // Create a new message
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
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
}
