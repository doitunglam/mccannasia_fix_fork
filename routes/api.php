<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCampainController;
use App\Http\Controllers\ApiCampainMissionController;
use App\Http\Controllers\ApiAgencyController;
use App\Http\Controllers\ApiResuftController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiWithDrawController;
use App\Http\Controllers\ApiRechargeController;
use App\Http\Controllers\ApiAnalysisController;
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
    'prefix' => 'analysis'
], function ($router) {
    Route::controller(ApiAnalysisController::class)->group(function() {
        Route::middleware('jwt.auth')->get('', 'list');
    });
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'campain'
], function ($router) {
    Route::controller(ApiCampainController::class)->group(function() {
        Route::middleware('jwt.auth')->get('', 'list');
        Route::middleware('jwt.auth')->get('get-info-create', 'getInfoCreate');
        Route::middleware('jwt.auth')->get('/{id}', 'getModelById');
        Route::middleware('jwt.auth')->delete('/{id}', 'deleteItemById');
        Route::middleware('jwt.auth')->post('', 'store');
    });
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'campain-mission'
], function ($router) {
    Route::controller(ApiCampainMissionController::class)->group(function() {
        Route::middleware('jwt.auth')->get('', 'list');
        Route::middleware('jwt.auth')->post('', 'store');
        Route::middleware('jwt.auth')->get('/{id}', 'getModelById');
        Route::middleware('jwt.auth')->delete('/{id}', 'deleteItemById');
    });
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'agency'
], function ($router) {
    Route::controller(ApiAgencyController::class)->group(function() {
        Route::middleware('jwt.auth')->get('', 'list');
        Route::middleware('jwt.auth')->post('', 'store');
        Route::middleware('jwt.auth')->get('/{id}', 'getModelById');
        Route::middleware('jwt.auth')->put('/change-amount/{id}', 'changeAmount');
        Route::middleware('jwt.auth')->put('/block/{id}', 'block');
        Route::middleware('jwt.auth')->put('/reset-password/{id}', 'resetPassword');
    });
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'result'
], function ($router) {
    Route::controller(ApiResuftController::class)->group(function() {
        Route::middleware('jwt.auth')->get('', 'list');
        Route::middleware('jwt.auth')->put('/{id}', 'handleAction');
        Route::middleware('jwt.auth')->put('', 'handleAcceptAll');
    });
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'withdraw'
], function ($router) {
    Route::controller(ApiWithDrawController::class)->group(function() {
        Route::middleware('jwt.auth')->get('', 'list');
        Route::middleware('jwt.auth')->put('/{id}', 'store');
    });
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'recharge'
], function ($router) {
    Route::controller(ApiRechargeController::class)->group(function() {
        Route::middleware('jwt.auth')->get('', 'list');
        Route::middleware('jwt.auth')->put('/{id}', 'store');
    });
});
