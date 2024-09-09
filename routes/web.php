<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
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
    return view('tasks');
});

Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{status}', [TaskController::class, 'filter']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/task/complete/{task}', [TaskController::class, 'complete']);
Route::put('/task/{task}', [TaskController::class, 'update']);
Route::delete('/task/{task}', [TaskController::class, 'destroy']);


