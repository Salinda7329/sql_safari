<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SqlGameController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/sql-game/{level}', [SqlGameController::class, 'showLevel']);
Route::post('/sql-game/{level}/run', [SqlGameController::class, 'runQuery']);

Route::get('/sql-game/{level}/schema', [SqlGameController::class, 'schema']);
