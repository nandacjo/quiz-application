<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return Inertia('Home');
});

Route::get('/questions',[ QuestionController::class, 'index']);
Route::post('/questions', [QuestionController::class, 'store']);
