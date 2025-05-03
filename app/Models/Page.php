
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'profile_photo',
        'is_active',
    ];

    /**
     * Relationship: A page belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A page can have many posts.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
