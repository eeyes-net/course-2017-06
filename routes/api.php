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

Route::namespace('Api')->prefix('post')->group(function () {
    Route::get('courses', 'PostController@courses');
    Route::get('teachers', 'PostController@teachers');
    Route::get('/', 'PostController@index');
    Route::get('s', 'PostController@search');
    Route::get('{id}', 'PostController@show');
    Route::get('{id}/comment', 'CommentController@index');
    Route::post('{id}/comment', 'CommentController@store');
});
