<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlGameController extends Controller
{
    public function showLevel($level)
    {
        $playerId = 1; // demo

        $progress = DB::table('player_progress')->where('player_id', $playerId)->first();
        if (!$progress) abort(403, 'Player progress not found');

        if ($level > $progress->highest_level) {
            abort(403, "You haven't unlocked this level yet!");
        }

        $levelData = DB::table('levels')->where('id', $level)->first();
        if (!$levelData) abort(404);

        // Get current task by task_id OR first task in level
        if ($progress->current_task_id) {
            $currentTask = DB::table('level_tasks')->where('id', $progress->current_task_id)->first();
        } else {
            $currentTask = DB::table('level_tasks')->where('level_id', $level)->orderBy('id')->first();
            DB::table('player_progress')->where('player_id', $playerId)->update(['current_task_id' => $currentTask->id]);
        }

        return view("level{$level}", [
            'level' => $levelData,
            'task' => $currentTask,
            'progress' => $progress
        ]);
    }




    public function runQuery(Request $request, $level)
    {
        $playerId = 1; // demo
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
                // Find the next task globally
                $nextTask = DB::table('level_tasks')
                    ->where('id', '>', $task->id)
                    ->orderBy('id')
                    ->first();

                if ($nextTask) {
                    // ✅ Move to next task (even if it's in a new level)
                    DB::table('player_progress')
                        ->where('player_id', $playerId)
                        ->update([
                            'attempts_left' => 3,
                            'current_task_id' => $nextTask->id,
                            'current_level' => $nextTask->level_id, // <-- sync level automatically
                            'highest_level' => max($progress->highest_level, $nextTask->level_id)
                        ]);

                    return response()->json([
                        'success' => true,
                        'message' => "✅ Correct! Moving to next task.",
                        'result' => $userResult,
                        'attempts_left' => 3,
                        'next_level' => $nextTask->level_id
                    ]);
                } else {
                    // 🎉 No more tasks = Game complete
                    DB::table('player_progress')
                        ->where('player_id', $playerId)
                        ->update([
                            'attempts_left' => 3,
                            'current_task_id' => null
                        ]);

                    return response()->json([
                        'success' => true,
                        'message' => "🏆 Congratulations! You finished all levels.",
                        'result' => $userResult,
                        'attempts_left' => 3
                    ]);
                }
            }
        } catch (\Exception $e) {
            // ❌ Syntax/runtime error
            $remainingAttempts = max(0, $progress->attempts_left - 1);
            DB::table('player_progress')->where('player_id', $playerId)->update(['attempts_left' => $remainingAttempts]);

            return response()->json([
                'success' => false,
                'message' => "⚠ Error: " . $e->getMessage(),
                'attempts_left' => $remainingAttempts,
                'clue' => $task->clue
            ]);
        }
    }
}
