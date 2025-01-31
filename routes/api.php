<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamMemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return ['user' => $request->user()];
    });
    Route::get('/users', function (Request $request) {
        return ['users' => $request->user()->all()];
    });


    Route::group(['prefix' => 'team'], function () {
        Route::get('/', [TeamController::class, 'index']);
        Route::post('/', [TeamController::class, 'store']);
        Route::get('/{team}', [TeamController::class, 'show']);
        Route::put('/{team}', [TeamController::class, 'update']);
        Route::delete('/{team}', [TeamController::class, 'destroy']);
        Route::delete('/{team}/leave', [TeamController::class, 'leave']);

        Route::get('/{team}/member', [TeamMemberController::class, 'index']);
        Route::post('/{team}/member', [TeamMemberController::class, 'store']);
        Route::delete('/{team}/member/{user}', [TeamMemberController::class, 'destroy']);

        Route::get('/{team}/task', [TaskController::class, 'index']);
        Route::post('/{team}/task', [TaskController::class, 'store']);
        Route::get('/{team}/task/{task}', [TaskController::class, 'show']);
        
        Route::delete('/{team}/task/{task}', [TaskController::class, 'destroy']);
    });
});