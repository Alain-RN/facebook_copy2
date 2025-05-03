<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Affiche la page du profil de l'utilisateur connecté.
     */
    public function show($userId = null) {

        $user = Auth::User(); // Récupère l'utilisateur connecté
        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                abort(404, 'Utilisateur non trouvé.');
            }
        }

        $friends = $user->allFriends();

        $posts = $user->posts()->latest()->get();

        $friendshipStatus = Auth::check() && $user->id !== Auth::id()
        ? \App\Models\Friendship::where(function ($query) use ($user) {
            $query->where('user_id', Auth::id())
                  ->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', Auth::id());
        })->value('status') ?? 'none'
        : null;

        return view('profile.profile', compact('user', 'posts', 'friendshipStatus', 'friends'));
    }

    /**
     * Affiche le formulaire pour modifier le profil.
     */
    public function edit($userId = null)
    {
        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                abort(404, 'Utilisateur non trouvé.');
            }
        }
        $user = Auth::User(); // Récupère l'utilisateur connecté
        return view('profile.edit', compact('user'));
    }
    /**
     * Met à jour les informations du profil de l'utilisateur.
     */

    public function update(Request $request)
    {
        $user = Auth::User();

        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'date_of_birth' => 'nullable|date',
            'profile_photo' => 'nullable|image|max:2048',
            'cover_photo' => 'nullable|image|max:2048',
            'bio' => 'nullable|image|max:2048',
            'location' => 'nullable|string|max:255',
        ]);

    // Gestion de la photo de profil
        if ($request->hasFile('profile_photo')) {
            // Supprime l'ancienne photo si elle existe
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Enregistre la nouvelle photo
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        if ($request->hasFile('cover_photo')) {

            if ($user->cover_photo) {
                Storage::disk('public')->delete($user->cover_photo);
            }

            $coverPath = $request->file('cover_photo')->store('cover_photos', 'public');
            $user->cover_photo = $coverPath;
        }
    // Mise à jour des autres informations
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'bio' => $request->bio,
            'location' => $request->location,
        ]);

    return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Upload la photo de profil.
     */
    public function uploadProfilePhoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_photo' => 'required|image|max:2048',
        ]);

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('profile_photo')->store('profile_photos', 'public');
        $user->profile_photo = $path;
        $user->save();

        return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès.');
    }

    /**
     * Upload la photo de couverture.
     */
    public function uploadCoverPhoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'cover_photo' => 'required|image|max:2048',
        ]);

        if ($user->cover_photo) {
            Storage::disk('public')->delete($user->cover_photo);
        }

        $path = $request->file('cover_photo')->store('cover_photos', 'public');
        $user->update(['cover_photo' => $path]);

        return redirect()->back()->with('success', 'Photo de couverture mise à jour avec succès.');
    }
}