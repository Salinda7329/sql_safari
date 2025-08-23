<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SqlGameController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/introduction/section_{section}', [SqlGameController::class, 'showIntroduction']);

Route::get('/sql-game/{level}', [SqlGameController::class, 'showLevel']);
Route::post('/sql-game/{level}/run', [SqlGameController::class, 'runQuery']);

Route::get('/sql-game/reference-tables/{taskId}', [SqlGameController::class, 'getReferenceTables']);
