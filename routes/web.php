<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SqlGameController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\LeaderboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/introduction/section_{section}', [SqlGameController::class, 'showIntroduction']);

Route::get('/sql-game/{level}', [SqlGameController::class, 'showLevel']);
Route::post('/sql-game/{level}/run', [SqlGameController::class, 'runQuery']);

Route::get('/sql-game/reference-tables/{taskId}', [SqlGameController::class, 'getReferenceTables']);

Route::get('/achievements', [LeaderboardController::class, 'index'])->name('achievements');
Route::post('/achievements/{id}/email', [AchievementController::class, 'emailBadge'])->name('achievements.email');
Route::post('/achievements/award/{id}', [AchievementController::class, 'awardBadge'])->name('achievements.award');

