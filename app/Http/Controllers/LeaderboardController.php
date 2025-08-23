<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = \DB::table('users')
            ->select(
                'users.id',
                'users.name',
                \DB::raw('COUNT(player_achievements.id) as achievements_count'),
                'player_progress.highest_level'
            )
            ->leftJoin('player_progress', 'users.id', '=', 'player_progress.player_id')
            ->leftJoin('player_achievements', 'users.id', '=', 'player_achievements.user_id')
            ->groupBy('users.id', 'users.name', 'player_progress.highest_level')
            ->orderByDesc('achievements_count')
            ->orderByDesc('player_progress.highest_level')
            ->take(10)
            ->get();

        $player = auth()->user();

        return view('leaderboard', compact('leaderboard', 'player'));
    }
}
