<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SqlGameController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/sql-game', [SqlGameController::class, 'index']);
Route::post('/sql-game/run', [SqlGameController::class, 'runQuery']);
