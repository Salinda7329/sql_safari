<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['name', 'description', 'badge_image'];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'player_achievements',
            'achievement_id',
            'user_id'
        )->withTimestamps();
    }
}
