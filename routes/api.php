<?php

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
Route::post('request-token', 'App\Http\Controllers\PassportAuthController@login');
Route::get('fetch-word', 'App\Http\Controllers\ApiController@fetchWord');
Route::post('submit-word', 'App\Http\Controllers\ApiController@submitWord');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
