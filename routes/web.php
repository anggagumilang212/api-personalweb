<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectViewController;
use App\Http\Controllers\BlogViewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

// Projects
Route::get('/projects', [ProjectViewController::class, 'index'])->name('projects.index');
Route::post('/projects', [ProjectViewController::class, 'store'])->name('projects.store');
Route::post('/projects/{id}', [ProjectViewController::class, 'update'])->name('projects.update');
Route::delete('/projects/{id}', [ProjectViewController::class, 'destroy'])->name('projects.destroy');

// Blogs
Route::get('/blogs', [BlogViewController::class, 'index'])->name('blogs.index');
Route::post('/blogs', [BlogViewController::class, 'store'])->name('blogs.store');
Route::post('/blogs/{id}', [BlogViewController::class, 'update'])->name('blogs.update');
Route::delete('/blogs/{id}', [BlogViewController::class, 'destroy'])->name('blogs.destroy');

