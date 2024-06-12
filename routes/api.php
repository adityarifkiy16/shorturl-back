<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\UrlController;

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

Route::get('/hello', function () {
    return json_encode([
        'code' => 200,
        'message' => 'this is message!',
        'data' => [
            'id' => 1,
            'dummy' => 'hello dummy',
        ]
    ]);
});


// auth
Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');


//authorize
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user()->id;
    });

    Route::prefix('url')->group(function () {
        Route::get('/show', [UrlController::class, 'show'])->name('url.show');
    });

    Route::get('/logout', LogoutController::class)->name('logout');
});

// non-authorize
Route::post('/create', [UrlController::class, 'create'])->name('url.create');
Route::get('/url/{shorturl}', [UrlController::class, 'redirectUrl'])->name('shorturl');
