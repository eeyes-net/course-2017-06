<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix' => config('admin.prefix'),
    'namespace' => Admin::controllerNamespace(),
    'middleware' => ['web', 'admin'],
], function (Router $router) {

    $router->get('auth/login', 'AuthController@login');
    $router->post('auth/login', 'AuthController@login');
    $router->get('auth/logout', 'AuthController@logout');

    $router->get('/', 'HomeController@index');
    $router->resource('teacher', 'TeacherController');
    $router->resource('course', 'CourseController');
    $router->resource('category', 'CategoryController');
    $router->resource('download', 'DownloadController');
    $router->resource('comment', 'CommentController');
    $router->resource('feedback', 'FeedbackController');
    $router->resource('api_log', 'ApiLogController');
});
