<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller

{
    use AuthorizesRequests;
    /**
     * Display a listing of posts (the feed).
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048', // optional image
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();
        return redirect()->back()->with('success', 'Post created successfully.');
    }

    /**
     * Display a single post.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the post.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post); // ensure user can edit own post

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        return redirect()->back()->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the post from storage.
     */
    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette publication.');
        }
    
        $post->delete();
    
        return redirect()->back()->with('success', 'Publication supprimée avec succès.');
    }
}
