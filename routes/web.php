<?php

use App\Models\Projet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ListEditController;
use App\Http\Controllers\TaskEditController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/projets', ProjetController::class)->middleware('auth');

Route::get('/invitation', [InvitationController::class, 'index'])->name('invitation.index')->middleware('auth');

Route::post('/invitation', [InvitationController::class, 'update'])->name('invitation.update')->middleware('auth');


Route::resource('/lists', ListController::class)->middleware('auth');

Route::get('lists/{id}/{idList}', [ListEditController::class, "edit"])->middleware('auth')->name('listes.edit');

Route::put('lists/{id}/{idList}', [ListEditController::class, "update"])->middleware('auth')->name('listes.update');

Route::resource('/tasks', TaskController::class);

Route::post('tasks/{id}', [TaskEditController::class, "store"])->middleware('auth')->name('taskes.store');

Route::delete('lists/{id}/{idList}', [ListEditController::class, "destroy"])->middleware('auth')->name('listes.destroy');

Route::delete('tasks/{id}/{idList}/{idTask}', [TaskEditController::class, "detruire"])->middleware('auth')->name('taskes.detruire');
