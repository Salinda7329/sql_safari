<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlNavController extends Controller
{
    private int $playerId = 1; // temp until auth

    public function introNext()
    {
        $p = DB::table('player_progress')->where('player_id', $this->playerId)->first();
        if (!$p) abort(403, 'Player progress not found');

        $introStatus = (int) ($p->intro_status ?? 0);
        $nextLevelId = $introStatus + 1;

        $exists = DB::table('levels')->where('id', $nextLevelId)->exists();
        if (!$exists) {
            return redirect('/achievements')->with('success', 'All level intros are complete.');
        }

        // send to /sql-game/{level}/intro
        return redirect()->route('introduction.section.level', ['level' => $nextLevelId]);
    }


    public function next(Request $request)
    {
        $orderCol = $this->taskOrderCol();

        return DB::transaction(function () use ($orderCol) {
            $p = DB::table('player_progress')->where('player_id', $this->playerId)->lockForUpdate()->first();
            if (!$p) abort(403, 'Player progress not found');

            $currentLevelId = (int)$p->current_level;
            $currentTask    = $p->current_task_id
                ? DB::table('level_tasks')->where('id', $p->current_task_id)->first()
                : null;

            if (!$currentTask) {
                $firstTask = DB::table('level_tasks')->where('level_id', $currentLevelId)->orderBy($orderCol)->first();
                if (!$firstTask) abort(500, 'Current level has no tasks');

                DB::table('player_progress')->where('player_id', $this->playerId)->update([
                    'current_task_id' => $firstTask->id,
                ]);

                // Gate intro for current level
                if ((int)$p->intro_status < $currentLevelId) {
                    return redirect()->route('sql.intro', ['level' => $currentLevelId]);
                }
                return redirect()->route('sql.level', ['level' => $currentLevelId]);
            }

            // Try next task in same level
            $nextTask = DB::table('level_tasks')
                ->where('level_id', $currentLevelId)
                ->where($orderCol, '>', $currentTask->{$orderCol})
                ->orderBy($orderCol)
                ->first();

            if ($nextTask) {
                DB::table('player_progress')->where('player_id', $this->playerId)->update([
                    'current_task_id' => $nextTask->id,
                ]);
                return redirect()->route('sql.level', ['level' => $currentLevelId]);
            }

            // Move to first task of the next level
            $nextLevel = DB::table('levels')->where('id', '>', $currentLevelId)->orderBy('id')->first();
            if (!$nextLevel) return redirect('/achievements');

            $firstTaskNext = DB::table('level_tasks')->where('level_id', $nextLevel->id)->orderBy($orderCol)->first();
            if (!$firstTaskNext) abort(500, 'Next level has no tasks');

            DB::table('player_progress')->where('player_id', $this->playerId)->update([
                'current_level'   => $nextLevel->id,
                'current_task_id' => $firstTaskNext->id,
                'highest_level'   => max((int)$p->highest_level, (int)$nextLevel->id),
                'attempts_left'   => 3,
            ]);

            // Gate intro for the next level
            if ((int)$p->intro_status < (int)$nextLevel->id) {
                return redirect()->route('sql.intro', ['level' => $nextLevel->id]);
            }

            return redirect()->route('sql.level', ['level' => $nextLevel->id]);
        });
    }

    public function intro(int $level)
    {
        $levelData = DB::table('levels')->where('id', $level)->first();
        if (!$levelData) abort(404, 'Level not found');

        $orderCol  = $this->taskOrderCol();
        $firstTask = DB::table('level_tasks')->where('level_id', $level)->orderBy($orderCol)->first();

        return view('level_intro', ['level' => $levelData, 'firstTask' => $firstTask]);
    }

    public function introComplete(Request $request, int $level)
    {
        DB::table('player_progress')->where('player_id', $this->playerId)->update([
            'intro_status' => DB::raw('GREATEST(intro_status, ' . (int)$level . ')'),
        ]);
        return redirect()->route('sql.level', ['level' => $level]);
    }

    private function taskOrderCol(): string
    {
        $schema = DB::getSchemaBuilder();
        if ($schema->hasColumn('level_tasks', 'sequence')) return 'sequence';
        if ($schema->hasColumn('level_tasks', 'order'))    return 'order';
        return 'id';
    }
}
