<?php

App::setLocale('pt');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;

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
    Route::put('update/{id}', [UserController::class, 'updateUser']);
    Route::delete('delete/{id}', [UserController::class, 'deleteUser']);
});

Route::group(
    ['middleware' => 'auth:api',
    'prefix' => 'userType'
], function ($router) {
    Route::get('index', [UserTypeController::class, 'index']);
    Route::post('register', [UserTypeController::class, 'register']);
    Route::put('update/{id}', [UserTypeController::class, 'update']);
    Route::delete('delete/{id}', [UserTypeController::class, 'delete']);
});
