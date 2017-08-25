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
    Route::get('s', 'SearchController@search');
    Route::post('feedback', 'FeedbackController@store');
    Route::prefix('category')->group(function () {
        Route::get('/', 'CategoryController@index');
        Route::get('course', 'CategoryController@courseIndex');
        Route::get('s', 'TeacherController@search');
        Route::get('{name}', 'CategoryController@show');
        Route::get('{name}/courses', 'CategoryController@courses');
    });
    Route::prefix('course')->group(function () {
        Route::get('/', 'CourseController@index');
        Route::get('s', 'CourseController@search');
        Route::get('{id}', 'CourseController@show');
        Route::get('{id}/comment', 'CourseController@comment');
        Route::post('{id}/comment', 'CourseController@commentStore');
    });
    Route::prefix('teacher')->group(function () {
        Route::get('/', 'TeacherController@index');
        Route::get('s', 'TeacherController@search');
        Route::get('{id}', 'TeacherController@show');
        Route::get('{id}/comment', 'TeacherController@comment');
        Route::post('{id}/comment', 'TeacherController@commentStore');
    });
    Route::prefix('comment')->group(function () {
        Route::post('{id}/like', 'CommentController@like');
    });
});
