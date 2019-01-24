<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('mobile/v1/','ApiController@index')->middleware('token','mobile');

foreach(\App\Http\Controllers\ApiController::$OPERATIONS as $operation ) {
    Route::post('mobile/v1/'.$operation,'ApiController@index')->middleware('token','mobile');
}

Route::get('smart/v1/categories','CategoryController@show');

Route::get('smart/v1/channels','ChannelsController@show');

Route::get('smart/v1/archives','ArchiveController@show');