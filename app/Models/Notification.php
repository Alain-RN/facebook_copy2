<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'data',
        'is_read',
    ];

    /**
     * Relationship: A notification belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(userser::class);
    }
}
