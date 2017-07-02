<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix' => config('admin.prefix'),
    'namespace' => Admin::controllerNamespace(),
    'middleware' => ['web', 'admin'],
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('teachers', 'TeacherController');
    $router->resource('courses', 'CourseController');
    $router->resource('categories', 'CategoryController');
    $router->resource('comments', 'CommentController');
    $router->resource('feedback', 'FeedbackController');

    $router->get('api/posts', 'Api\PostController@index');
});