<?php
namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    /**
     * Envoyer une demande d'ami.
     */
    public function index()
    {
        $friends = Auth::User()->allFriends();
        $friendRequests = Auth::User()->receivedFriendRequests;
        $friendRequests->load('user');

        return view('friends.friends', compact('friends', 'friendRequests'));
    }

    public function sendRequest(User $user)
    {
        Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $user->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Demande d\'ami envoyée.');
    }

    public function cancelRequest($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            abort(404, 'Utilisateur non trouvé.');
        }
    
        if ($user->id === Auth::id()) {
            abort(403, 'Action non autorisée.');
        }
    
        $friendship = Friendship::where(function ($query) use ($userId) {
                $query->where('user_id', Auth::id())
                      ->where('friend_id', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('friend_id', Auth::id());
            })
            ->first();
    
        if (!$friendship) {
            abort(403, 'Aucune relation trouvée.');
        }
    
        $friendship->delete();
    
        return redirect()->back()->with('success', 'Relation annulée.');
    }

    /**
     * Accepter une demande d'ami.
     */
    public function acceptRequest($id)
    {
        $friendship = Friendship::find($id);

        if (!$friendship || $friendship->friend_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $friendship->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Demande d\'ami acceptée.');
    }

    /**
     * Rejeter une demande d'ami.
     */
    public function rejectRequest($id)
    {
        $friendship = Friendship::where('id', $id)
            ->where('friend_id', Auth::id())
            ->firstOrFail();

        $friendship->delete();

        return redirect()->back()->with('success', 'Demande d\'ami rejetée.');
    }

    /**
     * Liste des amis.
     */
}