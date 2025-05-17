<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('v1/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum' ], function () {

    Route::group(['prefix' => 'teams'], function () {

        Route::post('/create', [TeamController::class, 'store'])->name('teams.store');
        Route::post('/{id}/members', [TeamController::class, 'addMember'])->name('teams.addMember');
        Route::post('/{id}/projects', [ProjectController::class, 'addProject'])->name('teams.addProject');

    });

    Route::group(['prefix' => 'projects'], function () {

        Route::get('/{id}', [ProjectController::class, 'show'])->name('projects.show');
        Route::post('/{id}/tasks', [TaskController::class, 'addTask'])->name('projects.addTask');

    });

    Route::group(['prefix' => 'tasks'], function () {

        Route::put('/{id}/assign', [TaskController::class, 'assignTask'])->name('tasks.assignTask');
        Route::get('', [TaskController::class, 'tasksWithFilter'])->name('tasks.tasksWithFilter');

    });

});
