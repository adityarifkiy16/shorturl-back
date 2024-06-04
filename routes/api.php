<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserControler;
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

Route::get('/hello', function () {
    return json_encode(['message' => 'success accessing api']);
});

Route::middleware(['guest', 'session'])->group(function () {
    Route::resource('user', UserControler::class);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::middleware('auth')->group(function () {
    // Route::post('/logout', [LoginController::class, 'logout']);
});
