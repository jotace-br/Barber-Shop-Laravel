<?php

App::setLocale('pt');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\MeetingController;
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

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'sector'
], function ($router) {
    Route::get('index', [SectorController::class, 'index']);
    Route::get('getName/{id}', [SectorController::class, 'getNameById']);
    Route::get('getCompanies', [SectorController::class, 'getOnlyCompanies']);
    Route::post('register', [SectorController::class, 'register']);
    Route::put('update/{id}', [SectorController::class, 'update']);
    Route::delete('delete/{id}', [SectorController::class, 'delete']);
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

Route::group(
    ['middleware' => 'auth:api',
    'prefix' => 'meeting'
], function ($router) {
    Route::get('index', [MeetingController::class, 'index']);
    Route::get('mySector/{sectorID}', [MeetingController::class, 'getMySector']);
    Route::post('register', [MeetingController::class, 'register']);
    Route::put('update/{id}', [MeetingController::class, 'update']);
    Route::delete('delete/{id}', [MeetingController::class, 'delete']);
});
