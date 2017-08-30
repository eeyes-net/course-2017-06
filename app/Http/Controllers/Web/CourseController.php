<?php

namespace App\Http\Controllers\Web;

class CourseController extends Controller
{
    use WebControllerTrait,
        PostControllerTrait;

    protected $viewPrefix = 'course';
    protected $apiControllerClass = \App\Http\Controllers\Api\CourseController::class;
}
