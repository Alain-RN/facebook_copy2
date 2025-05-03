<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a list of all groups.
     */
    public function index()
    {
        // $groups = Group::all();
        // return view('groups.index', compact('groups'));
        return view('groups.groupes');
    }

    /**
     * Show the form to create a new group.
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a new group in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'privacy' => 'required|in:public,private',
        ]);

        $group = Group::create([
            'owner_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'privacy' => $request->privacy,
        ]);

        // Automatically add the owner as a member of the group
        $group->members()->attach(Auth::id());

        return redirect()->route('groups.index');
    }

    /**
     * Show a specific group and its posts.
     */
    public function show($id)
    {
        $group = Group::findOrFail($id);
        return view('groups.show', compact('group'));
    }

    /**
     * Join a group.
     */
    public function join($id)
    {
        $group = Group::findOrFail($id);
        $group->members()->attach(Auth::id());

        return redirect()->route('groups.show', $id);
    }

    /**
     * Leave a group.
     */
    public function leave($id)
    {
        $group = Group::findOrFail($id);
        $group->members()->detach(Auth::id());

        return redirect()->route('groups.index');
    }
}
