<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlGameController extends Controller
{
    public function showLevel($level)
    {
        // demo: assume player_id = 1
        $progress = DB::table('player_progress')->where('player_id', 1)->first();
        if (!$progress) {
            abort(403, 'Player progress not found');
        }

        // prevent skipping
        if ($level > $progress->highest_level) {
            abort(403, "You haven't unlocked this level yet. Finish the previous one first!");
        }

        $levelData = DB::table('levels')->where('id', $level)->first();
        if (!$levelData) abort(404);

        return view('sql-game', ['level' => $levelData, 'progress' => $progress]);
    }

    public function runQuery(Request $request, $level)
    {
        $userQuery = $request->input('query');
        $levelData = DB::table('levels')->where('id', $level)->first();
        if (!$levelData) {
            return response()->json(['success' => false, 'message' => 'Level not found']);
        }

        try {
            $userResult = DB::select($userQuery);
            $expectedResult = DB::select($levelData->expected_query);

            if ($userResult == $expectedResult) {
                // Update progress
                $progress = DB::table('player_progress')->where('player_id', 1)->first();
                if ($progress && $level == $progress->highest_level) {
                    DB::table('player_progress')
                        ->where('player_id', 1)
                        ->update(['highest_level' => $progress->highest_level + 1]);
                }

                return response()->json([
                    'success' => true,
                    'message' => "Correct! You’ve cleared {$levelData->province} Province!",
                    'result' => $userResult,
                    'next_level' => $level + 1
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Incorrect. Try again!",
                    'result' => $userResult
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Error: " . $e->getMessage()
            ]);
        }
    }
}
