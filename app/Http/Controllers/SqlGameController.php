<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SqlGameController extends Controller
{
    public function showIntroduction($section)
    {
        $validSections = [1, 2, 3]; // Define valid sections
        if (!in_array($section, $validSections)) {
            abort(404);
        }

        return view("introductions.section_{$section}", ['section' => $section]);
    }

    public function showLevel($level)
    {
        $playerId = 1;
        $progress = DB::table('player_progress')
            ->where('player_id', $playerId)
            ->first();

        if (!$progress) {
            abort(403, 'Player progress not found');
        }

        //Redirect to current_level if URL mismatch
        if ($level != $progress->current_level) {
            return redirect("/sql-game/{$progress->current_level}");
        }

        $levelData = DB::table('levels')->where('id', $level)->first();
        if (!$levelData) {
            abort(404);
        }

        // Load current task (with all columns including new ones)
        $currentTask = DB::table('level_tasks')
            ->where('id', $progress->current_task_id)
            ->first();

        if (!$currentTask) {
            abort(404, 'Task not found');
        }

        return view("level{$level}", [
            'level'    => $levelData,
            'task'     => $currentTask,
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
                // ✅ Correct answer
                $nextTask = DB::table('level_tasks')
                    ->where('id', '>', $task->id)
                    ->orderBy('id')
                    ->first();

                if ($nextTask) {
                    DB::table('player_progress')
                        ->where('player_id', $playerId)
                        ->update([
                            'attempts_left'   => 3,
                            'current_task_id' => $nextTask->id,
                            'current_level'   => $nextTask->level_id,
                            'highest_level'   => max($progress->highest_level, $nextTask->level_id)
                        ]);

                    return response()->json([
                        'success'      => true,
                        'message'      => "🎉 Task complete! Moving to Level " . $nextTask->level_id,
                        'result'       => $userResult,
                        'attempts_left' => 3,
                        'next_level'   => $nextTask->level_id
                    ]);
                } else {
                    // 🎉 Game complete
                    DB::table('player_progress')
                        ->where('player_id', $playerId)
                        ->update([
                            'attempts_left'   => 3,
                            'current_task_id' => null
                        ]);

                    return response()->json([
                        'success'      => true,
                        'message'      => "🏆 Congratulations! You finished all levels.",
                        'result'       => $userResult,
                        'attempts_left' => 3
                    ]);
                }
            } else {
                // ❌ Wrong query but valid SQL
                $remainingAttempts = max(0, $progress->attempts_left - 1);

                DB::table('player_progress')->where('player_id', $playerId)
                    ->update(['attempts_left' => $remainingAttempts]);

                return response()->json([
                    'success'       => false,
                    'message'       => "❌ Wrong answer.",
                    'attempts_left' => $remainingAttempts,
                    'clue'          => $remainingAttempts > 0 ? $task->clue : null,
                    'help'          => $remainingAttempts == 0 ? $task->help : null
                ]);
            }
        } catch (\Exception $e) {
            // ⚠ SQL or runtime error
            $remainingAttempts = max(0, $progress->attempts_left - 1);

            DB::table('player_progress')->where('player_id', $playerId)
                ->update(['attempts_left' => $remainingAttempts]);

            return response()->json([
                'success'       => false,
                'message'       => "⚠ Error: " . $e->getMessage(),
                'attempts_left' => $remainingAttempts,
                'clue'          => $remainingAttempts > 0 ? $task->clue : null,
                'help'          => $remainingAttempts == 0 ? $task->help : null
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

    public function getReferenceTables($taskId)
    {
        $task = DB::table('level_tasks')->where('id', $taskId)->first();

        if (!$task || !$task->reference_table) {
            return response()->json(['error' => 'No reference tables found'], 404);
        }

        // Split comma separated tables
        $tables = array_map('trim', explode(',', $task->reference_table));

        $result = [];
        foreach ($tables as $table) {
            try {
                // Fetch a sample of 5 rows
                $rows = DB::table($table)->limit(5)->get();
                $columns = Schema::getColumnListing($table);

                $result[$table] = [
                    'columns' => $columns,
                    'rows'    => $rows
                ];
            } catch (\Exception $e) {
                $result[$table] = ['error' => "Could not load table {$table}"];
            }
        }

        return response()->json($result);
    }

    public function awardBadge($playerId, $badgeName)
    {
        $player = Player::find($playerId);
        $achievement = Achievement::where('name', $badgeName)->first();

        if ($player && $achievement) {
            $player->achievements()->syncWithoutDetaching([$achievement->id]);
            $player->increment('score', 100); // add points
        }
    }
}
