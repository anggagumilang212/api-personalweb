<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//project
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{id}', [ProjectController::class, 'detail']);
Route::post('/create-projects', [ProjectController::class, 'store']);
Route::put('/update-projects/{id}', [ProjectController::class, 'update']);
Route::delete('/delete-projects/{id}', [ProjectController::class, 'destroy']);

//auhtor
Route::get('/authors', [AuthorController::class, 'index']);
