<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlGameController extends Controller
{
    public function showLevel($level)
    {
        $progress = DB::table('player_progress')->where('player_id', 1)->first();
        if (!$progress) abort(403, 'Player progress not found');

        if ($level > $progress->highest_level) {
            abort(403, "You haven't unlocked this level yet. Finish the previous one first!");
        }

        $levelData = DB::table('levels')->where('id', $level)->first();
        $tasks = DB::table('level_tasks')->where('level_id', $level)->get();

        if (!$levelData) abort(404);

        return view("level{$level}", [
            'level' => $levelData,
            'tasks' => $tasks,
            'progress' => $progress
        ]);
    }


    public function runQuery(Request $request, $level)
    {
        $playerId = 1; // demo: single player
        $taskId = $request->input('task_id');
        $userQuery = $request->input('query');

        $task = DB::table('level_tasks')->where('id', $taskId)->first();
        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found']);
        }

        $progress = DB::table('player_progress')->where('player_id', $playerId)->first();

        try {
            $userResult = DB::select($userQuery);
            $expectedResult = DB::select($task->expected_query);

            if ($userResult == $expectedResult) {
                // ✅ Reset attempts since the player solved it
                DB::table('player_progress')
                    ->where('player_id', $playerId)
                    ->update([
                        'attempts_left' => 3,
                        'current_task' => $progress->current_task + 1
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => "✅ Correct! Task completed.",
                    'result' => $userResult,
                    'attempts_left' => 3
                ]);
            } else {
                // ❌ Wrong answer → decrease attempts
                $remainingAttempts = max(0, $progress->attempts_left - 1);

                DB::table('player_progress')
                    ->where('player_id', $playerId)
                    ->update(['attempts_left' => $remainingAttempts]);

                return response()->json([
                    'success' => false,
                    'message' => "❌ Incorrect. You have {$remainingAttempts} attempts left.",
                    'clue' => $task->clue,
                    'attempts_left' => $remainingAttempts
                ]);
            }
        } catch (\Exception $e) {
            // ❌ Syntax or runtime error → still decrease attempts
            $remainingAttempts = max(0, $progress->attempts_left - 1);

            DB::table('player_progress')
                ->where('player_id', $playerId)
                ->update(['attempts_left' => $remainingAttempts]);

            return response()->json([
                'success' => false,
                'message' => "⚠ Error: " . $e->getMessage(),
                'attempts_left' => $remainingAttempts,
                'clue' => $task->clue
            ]);
        }
    }
}
