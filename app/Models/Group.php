<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'privacy',
    ];

    /**
     * Relationship: A group belongs to an owner (user).
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Relationship: A group has many members (users).
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Relationship: A group has many posts.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
