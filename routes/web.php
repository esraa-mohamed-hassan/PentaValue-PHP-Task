<?php

use App\Http\Controllers\TwitterSearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;

use Illuminate\Support\Facades\Route;
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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [ImageController::class, 'index'])->name('dashboard');
    Route::post('/upload', [ImageController::class, 'upload'])->name('upload');
    Route::post('/approve', [ImageController::class, 'approve'])->name('approve');
    Route::post('/reject', [ImageController::class, 'reject'])->name('reject');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');

});
