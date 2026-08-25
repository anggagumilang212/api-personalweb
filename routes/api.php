<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ResumeController;
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

// Projects
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{id}', [ProjectController::class, 'detail']);
Route::post('/create-projects', [ProjectController::class, 'store']);
Route::put('/update-projects/{id}', [ProjectController::class, 'update']);
Route::delete('/delete-projects/{id}', [ProjectController::class, 'destroy']);

// Authors
Route::get('/authors', [AuthorController::class, 'index']);

// Products
Route::get('/products', [ProductController::class, 'index']);
Route::post('/create-products', [ProductController::class, 'store']);
Route::put('/update-products/{id}', [ProductController::class, 'update']);
Route::delete('/delete-products/{id}', [ProductController::class, 'destroy']);

// Blogs
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'detail']);
Route::post('/create-blogs', [BlogController::class, 'store']);
Route::put('/update-blogs/{id}', [BlogController::class, 'update']);
Route::delete('/delete-blogs/{id}', [BlogController::class, 'destroy']);

// Resume / CV
Route::get('/resume/active', [ResumeController::class, 'active']);
Route::get('/resumes', [ResumeController::class, 'index']);

