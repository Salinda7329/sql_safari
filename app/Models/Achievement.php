<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'achievements';

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'player_achievements')
            ->withPivot('earned_at')
            ->withTimestamps(); // optional
    }
}
