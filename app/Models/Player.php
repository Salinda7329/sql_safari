<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Player extends Model {
    protected $fillable = ['name','email','score'];

    public function achievements() {
        return $this->belongsToMany(Achievement::class, 'player_achievements')
            ->withTimestamps();
    }
}
