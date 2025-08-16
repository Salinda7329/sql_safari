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
        $taskId = $request->input('task_id');
        $userQuery = $request->input('query');

        $task = DB::table('level_tasks')->where('id', $taskId)->first();
        if (!$task) return response()->json(['success' => false, 'message' => 'Task not found']);

        try {
            $userResult = DB::select($userQuery);
            $expectedResult = DB::select($task->expected_query);

            if ($userResult == $expectedResult) {
                // Mark task as completed (future: track player_task_progress)
                $remaining = DB::table('level_tasks')
                    ->where('level_id', $level)
                    ->whereNotIn('id', [$taskId]) // crude; ideally check completed status
                    ->count();

                return response()->json([
                    'success' => true,
                    'message' => "Correct for this task!",
                    'result' => $userResult,
                    'next_level' => $remaining === 0 ? $level + 1 : null
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Incorrect. Try again!",
                    'result' => $userResult,
                    'clue' => $task->clue
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
