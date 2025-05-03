<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Show all pages of the logged-in user.
     */
    public function index()
    {
        $pages = Page::where('user_id', Auth::id())->get();
        return view('pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created page.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $page = new Page();
        $page->user_id = Auth::id();
        $page->name = $request->name;
        $page->description = $request->description;

        if ($request->hasFile('profile_photo')) {
            $page->profile_photo = $request->file('profile_photo')->store('page_photos', 'public');
        }

        $page->save();

        return redirect()->route('pages.index')->with('success', 'Page created successfully!');
    }

    /**
     * Show a specific page.
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.show', compact('page'));
    }

    /**
     * Show the form for editing a page.
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.edit', compact('page'));
    }

    /**
     * Update the specified page.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $page = Page::findOrFail($id);
        $page->name = $request->name;
        $page->description = $request->description;

        if ($request->hasFile('profile_photo')) {
            $page->profile_photo = $request->file('profile_photo')->store('page_photos', 'public');
        }

        $page->save();

        return redirect()->route('pages.index')->with('success', 'Page updated successfully!');
    }

    /**
     * Delete a page.
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted successfully!');
    }
}
