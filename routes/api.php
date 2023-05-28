<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporController;
use App\Http\Controllers\TwitterSearchController;

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

Route::get('/all_data', [ReporController::class, 'index'])->name('report.all_data');

Route::get('/get_tasks', [ReporController::class, 'taskRelatedPriceProduct'])->name('report.get_tasks');

Route::post('/store', [ReporController::class, 'store'])->name('report.store');

Route::get('/twitter/search', [TwitterSearchController::class, 'search']);
