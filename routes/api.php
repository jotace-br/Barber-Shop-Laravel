<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('login', [JWTAuthController::class, 'login']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'auth'
], function ($router) {
    Route::get('profile', [JWTAuthController::class, 'profile']);
    Route::post('refresh', [JWTAuthController::class, 'refresh']);
    Route::post('logout', [JWTAuthController::class, 'logout']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'user'
], function ($router) {
    Route::get('index', [UserController::class, 'index']);
    Route::get('indexPendences', [UserController::class, 'indexPendences']);
    Route::get('getEmail/{id}', [UserController::class, 'getEmail']);
    Route::get('listEmails/{sectorId}', [UserController::class, 'listEmails']);
    Route::post('uploadImage', [UserController::class, 'uploadImage']);
    Route::put('update/{id}', [UserController::class, 'updateUser']);
    Route::delete('delete/{id}', [UserController::class, 'deleteUser']);
});
