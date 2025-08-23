<?php
// app/Http/Controllers/SqlNavController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlNavController extends Controller
{
    // TEMP: single demo user
    private int $playerId = 1;

    // GET /sql-game/continue  -> redirects to /sql-game/{current_level}
    public function continue(Request $request)
    {
        $p = DB::table('player_progress')->where('player_id', $this->playerId)->first();
        if (!$p) abort(403, 'Player progress not found');

        // Ensure level exists
        $level = DB::table('levels')->where('id', $p->current_level)->first();
        if (!$level) abort(404, 'Level not found');

        // Ensure task exists & is consistent with level; if not, repair to first task of that level
        $task = $p->current_task_id
            ? DB::table('level_tasks')->where('id', $p->current_task_id)->first()
            : null;

        if (!$task || $task->level_id != $level->id) {
            $orderCol = $this->taskOrderCol();
            $firstTask = DB::table('level_tasks')
                ->where('level_id', $level->id)
                ->orderBy($orderCol)->first();

            if (!$firstTask) abort(500, 'Level has no tasks configured');

            DB::table('player_progress')->where('player_id', $this->playerId)->update([
                'current_task_id' => $firstTask->id,
            ]);
        }

        return redirect()->route('sql.level', ['level' => $level->id]);
    }

    // POST /sql-game/next  -> advance then redirect appropriately
    public function next(Request $request)
    {
        $orderCol = $this->taskOrderCol();

        return DB::transaction(function () use ($orderCol) {
            $p = DB::table('player_progress')->where('player_id', $this->playerId)->lockForUpdate()->first();
            if (!$p) abort(403, 'Player progress not found');

            $currentLevelId = (int)$p->current_level;
            $currentTask    = DB::table('level_tasks')->where('id', $p->current_task_id)->first();

            if (!$currentTask) {
                // Repair: jump to first task of current level
                $firstTask = DB::table('level_tasks')
                    ->where('level_id', $currentLevelId)->orderBy($orderCol)->first();
                if (!$firstTask) abort(500, 'Current level has no tasks');
                DB::table('player_progress')->where('player_id', $this->playerId)->update([
                    'current_task_id' => $firstTask->id,
                ]);
                return redirect()->route('sql.level', ['level' => $currentLevelId]);
            }

            // Try next task in the same level
            $nextTask = DB::table('level_tasks')
                ->where('level_id', $currentLevelId)
                ->where($orderCol, '>', $currentTask->{$orderCol})
                ->orderBy($orderCol)->first();

            if ($nextTask) {
                DB::table('player_progress')->where('player_id', $this->playerId)->update([
                    'current_task_id' => $nextTask->id,
                ]);
                return redirect()->route('sql.level', ['level' => $currentLevelId]);
            }

            // No more tasks → next level first task
            $nextLevel = DB::table('levels')->where('id', '>', $currentLevelId)->orderBy('id')->first();
            if (!$nextLevel) {
                // game complete
                return redirect('/achievements');
            }

            $firstTaskNext = DB::table('level_tasks')
                ->where('level_id', $nextLevel->id)->orderBy($orderCol)->first();
            if (!$firstTaskNext) abort(500, 'Next level has no tasks');

            DB::table('player_progress')->where('player_id', $this->playerId)->update([
                'current_level'   => $nextLevel->id,
                'current_task_id' => $firstTaskNext->id,
                'highest_level'   => max((int)$p->highest_level, (int)$nextLevel->id),
                'attempts_left'   => 3, // optional reset
            ]);

            return redirect()->route('sql.level', ['level' => $nextLevel->id]);
        });
    }

    private function taskOrderCol(): string
    {
        $schema = DB::getSchemaBuilder();
        if ($schema->hasColumn('level_tasks', 'sequence')) return 'sequence';
        if ($schema->hasColumn('level_tasks', 'order'))    return 'order';
        return 'id';
    }
}
