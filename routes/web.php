<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('docs/{name?}', 'DocumentationController@show')->where('name', '.*?');


Route::get('index', function () {
    return view('web.layouts.master');
});

Route::namespace('Web')->group(function () {
    Route::get('s', 'SearchController@search');
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
    });
    Route::prefix('teacher')->group(function () {
        Route::get('/', 'TeacherController@index');
        Route::get('s', 'TeacherController@search');
        Route::get('{id}', 'TeacherController@show');
        Route::get('{id}/comment', 'TeacherController@comment');
    });
});