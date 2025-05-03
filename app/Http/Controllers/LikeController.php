<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Store a newly created like in storage.
     */
    public function store(Post $post)
    {
        // Check if the user has already liked this post
        if (Like::where('user_id', Auth::id())->where('post_id', $post->id)->exists()) {
            return back()->with('error', 'You already liked this post.');
        }

        $like = new Like();
        $like->user_id = Auth::id();
        $like->post_id = $post->id;
        $like->save();

        return back()->with('success', 'Post liked successfully.');
    }

    /**
     * Remove the specified like from storage.
     */
    public function destroy(Post $post)
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $post->id)->first();
        
        if ($like) {
            $like->delete();
            return back()->with('success', 'Post unliked successfully.');
        }

        return back()->with('error', 'You haven\'t liked this post yet.');
    }
}
