<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SqlNavController;
use App\Http\Controllers\SqlGameController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\LeaderboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/introduction/section/{level}', [SqlGameController::class, 'showIntroduction'])->name('introduction.section.level');

Route::get('/sql-game/{level}', [SqlGameController::class, 'showLevel'])->name('sql.level');
Route::post('/sql-game/{level}/run', [SqlGameController::class, 'runQuery']);

Route::get('/sql-game/reference-tables/{taskId}', [SqlGameController::class, 'getReferenceTables']);

Route::get('/achievements', [LeaderboardController::class, 'index'])->name('achievements');
Route::post('/achievements/{id}/email', [AchievementController::class, 'emailBadge'])->name('achievements.email');
Route::post('/achievements/award/{id}', [AchievementController::class, 'awardBadge'])->name('achievements.award');

// NEW: level intro routes
Route::get('/sql-game/{level}/intro', [SqlNavController::class, 'intro'])->name('sql.intro');
Route::post('/sql-game/{level}/intro/complete', [SqlNavController::class, 'introComplete'])->name('sql.intro.complete');


Route::get('/sql-game/continue', [SqlNavController::class, 'continue'])->name('sql.continue');
Route::post('/sql-game/next', [SqlNavController::class, 'next'])->name('sql.next');
Route::get('/sql-game/intro/next', [SqlNavController::class, 'introNext'])->name('sql.intro.next');

// reset the game
Route::post('/reset-game', [SqlGameController::class, 'reset'])->name('game.reset');
