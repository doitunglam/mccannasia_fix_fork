<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCampainController;
use App\Http\Controllers\ApiCampainMissionController;
use App\Http\Controllers\ApiAgencyController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::controller(AuthController::class)->group(function() {
        Route::post('login', 'login');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::middleware('jwt.auth')->post('me', 'me')->name('api.me');
    });
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'campain'
], function ($router) {
    Route::controller(ApiCampainController::class)->group(function() {
        Route::middleware('jwt.auth')->get('', 'list');
    });
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'campain-mission'
], function ($router) {
    Route::controller(ApiCampainMissionController::class)->group(function() {
        Route::middleware('jwt.auth')->get('', 'list');
    });
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'agency'
], function ($router) {
    Route::controller(ApiAgencyController::class)->group(function() {
        Route::middleware('jwt.auth')->get('', 'list');
    });
});
