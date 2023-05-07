<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::controller(AuthController::class)
        ->prefix('auth')
        ->group(function () {
            Route::post('register', 'register')->withoutMiddleware('auth:sanctum');
            Route::post('login', 'login')->withoutMiddleware('auth:sanctum');
            Route::post('logout', 'logout');
            Route::get('{id}', 'detail');
        });

    Route::controller(UrlController::class)
        ->prefix('url')
        ->group(function () {
            Route::get('', 'list');
            Route::get('{id}', 'detail');
            Route::post('create', 'create');
            Route::post('{id}', 'update');
            Route::delete('{id}', 'delete');
        });
});
