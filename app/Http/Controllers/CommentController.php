<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function index(Post $post)
    {
        return response()->json(
            $post->comments()->with('user')->latest()->get()->map(function ($comment) {
                return [
                    'user' => $comment->user->name,
                    'photo' => asset('storage/'. $comment->user->profile_photo), // Assure-toi que 'photo' est bien une URL
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            })
        );
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->content = $request->content;
        $comment->save();

        return response()->json([
            'user' => $comment->user->name,
            'content' => $comment->content,
            'photo' => asset('storage/'. $comment->user->profile_photo),
            'created_at' => $comment->created_at->diffForHumans(),
        ]);
    }

    /**
     * Destroy the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment); // Ensure user can delete their comment

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
