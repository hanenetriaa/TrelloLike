<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ListController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/envoie', [ProjetController::class, "update"]);

Route::post('/delete', [ProjetController::class, "destroy"]);

Route::post('/email', [InvitationController::class, "store"]);

Route::post('tasks/move', [TaskController::class, 'move'])->name('tasks.move');

Route::post('/id', [ListController::class, 'index']);
