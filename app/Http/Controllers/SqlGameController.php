<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SqlGameController extends Controller
{
    public function showIntroduction(int $level)
    {
        $validSections = [1, 2, 3]; // Define valid sections
        if (!in_array($level, $validSections)) {
            abort(404);
        }

        return view('introductions.section_' . $level, ['levelId' => $level]);
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

        // --- Handle "Next" with ?advance=1 ---
        if (request()->boolean('advance')) {
            DB::transaction(function () use (&$progress, $playerId) {
                // Fresh progress in tx
                $progress = DB::table('player_progress')->where('player_id', $playerId)->lockForUpdate()->first();

                $currentLevelId = (int) $progress->current_level;
                $currentTaskId  = (int) $progress->current_task_id;

                $currentTask = DB::table('level_tasks')->where('id', $currentTaskId)->first();
                if (!$currentTask) {
                    abort(404, 'Current task not found');
                }

                // Choose an order column for tasks
                $taskOrderCol = DB::getSchemaBuilder()->hasColumn('level_tasks', 'sequence') ? 'sequence'
                    : (DB::getSchemaBuilder()->hasColumn('level_tasks', 'order')    ? 'order'
                        : 'id');

                // Next task in same level
                $nextTask = DB::table('level_tasks')
                    ->where('level_id', $currentLevelId)
                    ->where($taskOrderCol, '>', $currentTask->{$taskOrderCol})
                    ->orderBy($taskOrderCol, 'asc')
                    ->first();

                if ($nextTask) {
                    DB::table('player_progress')
                        ->where('player_id', $playerId)
                        ->update(['current_task_id' => $nextTask->id]);

                    // update in-memory progress for the redirect below
                    $progress->current_task_id = $nextTask->id;
                    return;
                }

                // No more tasks -> move to next level
                $nextLevel = DB::table('levels')
                    ->where('id', '>', $currentLevelId)
                    ->orderBy('id', 'asc')
                    ->first();

                if (!$nextLevel) {
                    // End of game: send them to achievements
                    redirect('/achievements')->send();
                    exit;
                }

                $firstTaskNextLevel = DB::table('level_tasks')
                    ->where('level_id', $nextLevel->id)
                    ->orderBy($taskOrderCol, 'asc')
                    ->first();

                if (!$firstTaskNextLevel) {
                    abort(500, 'Next level has no tasks configured.');
                }

                DB::table('player_progress')->where('player_id', $playerId)->update([
                    'current_level'   => $nextLevel->id,
                    'current_task_id' => $firstTaskNextLevel->id,
                ]);

                $progress->current_level   = $nextLevel->id;
                $progress->current_task_id = $firstTaskNextLevel->id;
            });

            // After advancing, always go to the player's current level page
            return redirect("/sql-game/{$progress->current_level}");
        }
        // --- end advance handling ---

        // Redirect to current_level if URL mismatch
        if ($level != $progress->current_level) {
            return redirect("/sql-game/{$progress->current_level}");
        }

        $levelData = DB::table('levels')->where('id', $level)->first();
        if (!$levelData) {
            abort(404);
        }

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

    // public function runQuery(Request $request, $level)
    // {
    //     $playerId = 1; // demo
    //     $taskId = $request->input('task_id');
    //     $userQuery = $request->input('query');

    //     $task = DB::table('level_tasks')->where('id', $taskId)->first();
    //     if (!$task) {
    //         return response()->json(['success' => false, 'message' => 'Task not found']);
    //     }

    //     $progress = DB::table('player_progress')->where('player_id', $playerId)->first();

    //     try {
    //         $userResult = DB::select($userQuery);
    //         $expectedResult = DB::select($task->expected_query);

    //         if ($userResult == $expectedResult) {
    //             // ✅ Correct answer
    //             $nextTask = DB::table('level_tasks')
    //                 ->where('id', '>', $task->id)
    //                 ->orderBy('id')
    //                 ->first();

    //             if ($nextTask) {
    //                 DB::table('player_progress')
    //                     ->where('player_id', $playerId)
    //                     ->update([
    //                         'attempts_left'   => 3,
    //                         'current_task_id' => $nextTask->id,
    //                         'current_level'   => $nextTask->level_id,
    //                         'highest_level'   => max($progress->highest_level, $nextTask->level_id)
    //                     ]);

    //                 return response()->json([
    //                     'success'      => true,
    //                     'message'      => "🎉 Task complete! Moving to Level " . $nextTask->level_id,
    //                     'result'       => $userResult,
    //                     'attempts_left' => 3,
    //                     'next_level'   => $nextTask->level_id
    //                 ]);
    //             } else {
    //                 // 🎉 Game complete
    //                 DB::table('player_progress')
    //                     ->where('player_id', $playerId)
    //                     ->update([
    //                         'attempts_left'   => 3,
    //                         'current_task_id' => null
    //                     ]);

    //                 return response()->json([
    //                     'success'      => true,
    //                     'message'      => "🏆 Congratulations! You finished all levels.",
    //                     'result'       => $userResult,
    //                     'attempts_left' => 3
    //                 ]);
    //             }
    //         } else {
    //             // ❌ Wrong query but valid SQL
    //             $remainingAttempts = max(0, $progress->attempts_left - 1);

    //             DB::table('player_progress')->where('player_id', $playerId)
    //                 ->update(['attempts_left' => $remainingAttempts]);

    //             return response()->json([
    //                 'success'       => false,
    //                 'message'       => "❌ Wrong answer.",
    //                 'attempts_left' => $remainingAttempts,
    //                 'clue'          => $remainingAttempts > 0 ? $task->clue : null,
    //                 'help'          => $remainingAttempts == 0 ? $task->help : null
    //             ]);
    //         }
    //     } catch (\Exception $e) {
    //         // ⚠ SQL or runtime error
    //         $remainingAttempts = max(0, $progress->attempts_left - 1);

    //         DB::table('player_progress')->where('player_id', $playerId)
    //             ->update(['attempts_left' => $remainingAttempts]);

    //         return response()->json([
    //             'success'       => false,
    //             'message'       => "⚠ Error: " . $e->getMessage(),
    //             'attempts_left' => $remainingAttempts,
    //             'clue'          => $remainingAttempts > 0 ? $task->clue : null,
    //             'help'          => $remainingAttempts == 0 ? $task->help : null
    //         ]);
    //     }
    // }

    public function runQuery(Request $request, $level)
    {
        $playerId = 1; // demo
        $taskId = $request->input('task_id');
        $userQuery = $request->input('query');

        $task = DB::table('level_tasks')->where('id', $taskId)->first();
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ]);
        }

        $progress = DB::table('player_progress')->where('player_id', $playerId)->first();

        try {
            // 🔹 Run player's query and task's expected query
            $userResult = DB::select($userQuery);
            $expectedResult = DB::select($task->expected_query);

            // ✅ If both results match → task complete
            if ($userResult == $expectedResult) {
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
                        'success'       => true,
                        'message'       =>"correct",
                        'result'        => $userResult, // 🔹 Always return result
                        'attempts_left' => 3,
                        'next_level'    => $nextTask->level_id
                    ]);
                } else {
                    // 🎉 All levels complete
                    DB::table('player_progress')
                        ->where('player_id', $playerId)
                        ->update([
                            'attempts_left'   => 3,
                            'current_task_id' => null
                        ]);

                    return response()->json([
                        'success'       => true,
                        'message'       => "🏆 Congratulations! You finished all levels.",
                        'result'        => $userResult, // 🔹 Return final result
                        'attempts_left' => 3
                    ]);
                }
            } else {
                // ❌ Wrong answer but SQL valid
                $remainingAttempts = max(0, $progress->attempts_left - 1);

                DB::table('player_progress')->where('player_id', $playerId)
                    ->update(['attempts_left' => $remainingAttempts]);

                return response()->json([
                    'success'        => false,
                    'message'        => "wrong_answer",//wrong
                    'result'         => $userResult, // 🔹 Still return what the DB produced
                    'attempts_left'  => $remainingAttempts,
                    'clue'           => $remainingAttempts > 0 ? $task->clue : null,
                    'help'           => $remainingAttempts == 0 ? $task->help : null
                ]);
            }
        } catch (\Exception $e) {
            // ⚠ SQL or runtime error
            $remainingAttempts = max(0, $progress->attempts_left - 1);

            DB::table('player_progress')->where('player_id', $playerId)
                ->update(['attempts_left' => $remainingAttempts]);

            return response()->json([
                'success'        => false,
                'message'        => "⚠ Error: " . $e->getMessage(),
                'result'         => null, // 🔹 No result because it errored
                'attempts_left'  => $remainingAttempts,
                'clue'           => $remainingAttempts > 0 ? $task->clue : null,
                'help'           => $remainingAttempts == 0 ? $task->help : null
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
