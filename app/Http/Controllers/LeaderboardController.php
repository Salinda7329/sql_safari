<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        // TEMP: force user id = 1 for all reads
        $userId = 1;

        // Left join to mark which achievements this user has earned
        $achievements = Achievement::query()
            ->leftJoin('player_achievements as pa', function ($join) use ($userId) {
                $join->on('pa.achievement_id', '=', 'achievements.id')
                    ->where('pa.user_id', '=', $userId);
            })
            ->select('achievements.*', DB::raw('pa.earned_at as earned_at'))
            ->orderBy('achievements.id')
            ->get();

        // Optional: show a friendly name even if users table has no id=1
        $displayName = optional(DB::table('users')->where('id', $userId)->first())->name ?? 'Guest';

        return view('achievements', [
            'userName'     => $displayName,
            'userId'       => $userId,
            'achievements' => $achievements,
        ]);
    }
}
