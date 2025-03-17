<?php

use App\Http\Controllers\ChessController;
use Illuminate\Support\Facades\Route;

Route::get('/knight-form', function () {
    return view('knight');
});

Route::post('/knight-path', [ChessController::class, 'findShortestPath']);

Route::get('/', function () {
    return view('welcome');
});
