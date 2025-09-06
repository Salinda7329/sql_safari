<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerAchievement extends Model
{
    protected $table = 'player_achievements';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'achievement_id',
        'earned_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
