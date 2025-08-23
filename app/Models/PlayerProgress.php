<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerProgress extends Model
{
    protected $table = 'player_progress';

    protected $fillable = [
        'player_id', 'highest_level', 'current_level', 'current_task_id', 'attempts_left'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
