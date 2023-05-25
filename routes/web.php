<?php

use App\Http\Controllers\TwitterSearchController;
use App\Http\Controllers\AuthController;
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
    // return view('welcome');
//     $querier = \Atymic\Twitter\Facade\Twitter::forApiV2()
//     ->getQuerier();
// $result = $querier
//     ->withOAuth2Client()
    // ->get('tweets/counts/recent', ['query' => 'foo']);
});

use App\Http\Controllers\UserController;

Route::get('/twitter/search', [TwitterSearchController::class, 'search']);

Route::get('firebase-phone-authentication', [AuthController::class, 'index']);

Route::get('imagess', [ImageController::class, 'index']);

Route::post('upload-images', [ImageController::class, 'uploadImages']);
