<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlGameController extends Controller
{
    public function showLevel($level)
    {
        $playerId = 1;
        $progress = DB::table('player_progress')->where('player_id', $playerId)->first();
        if (!$progress) abort(403, 'Player progress not found');

        // ✅ Redirect to current_level if URL mismatch
        if ($level != $progress->current_level) {
            return redirect("/sql-game/{$progress->current_level}");
        }

        $levelData = DB::table('levels')->where('id', $level)->first();
        if (!$levelData) abort(404);

        // load current task
        $currentTask = DB::table('level_tasks')->where('id', $progress->current_task_id)->first();

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
                        'message' => "🎉 Level {$level} cleared! Moving to Level " . ($level + 1),
                        'result' => $userResult,
                        'attempts_left' => 3,
                        'next_level' => $level + 1  // ✅ Send next level
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

    public function schema($level)
    {
        // For now, pick table(s) based on level
        $tableName = 'hotels'; // Example: Level 1 uses hotels table
        if ($level == 2) {
            $tableName = 'tourists';
        } elseif ($level == 3) {
            $tableName = 'bookings';
        }

        // Get column metadata
        $columns = DB::select("SHOW COLUMNS FROM {$tableName}");

        // Get first 5 rows as preview
        $rows = DB::table($tableName)->limit(5)->get();

        return response()->json([
            'table'   => $tableName,
            'columns' => $columns,
            'rows'    => $rows
        ]);
    }
}
