<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectViewController;

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


Route::get('/projects', [ProjectViewController::class, 'index'])->name('projects.index');
Route::post('/projects', [ProjectViewController::class, 'store'])->name('projects.store');
Route::post('/projects/{id}', [ProjectViewController::class, 'update'])->name('projects.update');
Route::delete('/projects/{id}', [ProjectViewController::class, 'destroy'])->name('projects.destroy');
