<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\BadgeMail;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AchievementController extends Controller
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

    public function awardBadge(Request $request, $achievementId)
    {
        $userId = 1; // temp

        $alreadyEarned = DB::table('player_achievements')
            ->where('user_id', $userId)
            ->where('achievement_id', $achievementId)
            ->exists();

        if (!$alreadyEarned) {
            DB::table('player_achievements')->insert([
                'user_id'         => $userId,
                'achievement_id'  => $achievementId,
                'earned_at'       => now(),
            ]);
        }

        // send mail (best-effort)
        $user = DB::table('users')->where('id', $userId)->first();
        $achievement = DB::table('achievements')->where('id', $achievementId)->first();

        $mailStatus = 'skipped';
        if ($user && !empty($user->email) && $achievement) {
            try {
                Mail::to($user->email)->send(new BadgeMail($user, $achievement));
                $mailStatus = 'sent';
            } catch (\Throwable $e) {
                $mailStatus = 'failed';
                Log::error('BadgeMail failed: ' . $e->getMessage());
            }
        }

        // if AJAX/XHR → JSON; else normal redirect (works for non-JS flows)
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success'        => true,
                'message'        => '🎉 Badge earned successfully!',
                'achievement_id' => (int) $achievementId,
                'mail'           => $mailStatus,
                'redirect'       => url('/achievements'),
            ], 200);
        }

        return redirect('/achievements')->with('success', '🎉 Badge earned successfully!');
    }




    public function emailBadge($id)
    {
        $user = Auth::user();
        $achievement = DB::table('achievements')->where('id', $id)->first();

        Mail::to($user->email)->send(new BadgeMail($user, $achievement));

        return back()->with('success', 'Badge emailed successfully!');
    }
}
