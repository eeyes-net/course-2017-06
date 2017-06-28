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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {
    Route::prefix('category')->group(function () {
        Route::get('/', 'CategoryController@index');
        Route::get('{name}', 'CategoryController@show');
        Route::get('{name}/courses', 'CategoryController@courses');
    });
    Route::prefix('post')->group(function () {
        Route::get('/', 'PostController@index');
        Route::get('courses/categorized', 'PostController@courses_categorized');
        Route::get('courses', 'PostController@courses');
        Route::get('teachers', 'PostController@teachers');
        Route::get('s', 'PostController@search');
        Route::get('{id}', 'PostController@show');
        Route::get('{id}/comment', 'CommentController@index');
        Route::post('{id}/comment', 'CommentController@store');
    });
    Route::post('feedback', 'FeedbackController@store');
});
