<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'profile_photo',
        'bio',
        'location',
        'cover_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    /**
     * Relationship: A user has many posts.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relationship: A user has many comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relationship: A user has many likes.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Relationship: A user has many messages sent.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Relationship: A user has many messages received.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Accessor: Get full profile photo path.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        } else {
            return asset('images/default_profile.png'); // fallback if no photo
        }
    }
    
    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    /**
     * Les demandes d'amis reçues par l'utilisateur.
     */
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id')->where('status', 'pending');
    }

    /**
     * Les amis acceptés.
     */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accepted')
                    ->withTimestamps();
    }


    public function allFriends()
    {
        $friendsOfMine = $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                ->wherePivot('status', 'accepted')
                ->withTimestamps();

        $friendsOf = $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
                ->wherePivot('status', 'accepted')
                ->withTimestamps();

        return $friendsOfMine->get()->merge($friendsOf->get());
    }

    public function search(Request $request)
    {
        $query = $request->input('query'); // Récupère le terme de recherche

        // Recherche des utilisateurs par nom ou email
        $users = User::where('name', 'LIKE', "%{$query}%")
                     ->orWhere('email', 'LIKE', "%{$query}%")
                     ->take(10) // Limite à 10 résultats
                     ->get();

        return response()->json($users); // Retourne les résultats en JSON
    }
}
