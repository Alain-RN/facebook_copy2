<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display the home page with the user's feed.
     */
    public function index()
    {        
        $posts = Post::with('user')->latest()->get();
        $user = User::find(Auth::id());

        foreach ($posts as $post) {
            $post->liked = $post->likes->contains('user_id', Auth::id());
        }

        foreach ($posts as $post) {
            $post->user = $post->user;
        }
        
        return view('home', compact('posts', 'user'));
    }
}