<?php

namespace App\Http\Controllers\Web;

class TeacherController extends Controller
{
    use WebControllerTrait,
        PostControllerTrait;

    protected $viewPrefix = 'teacher';
    protected $apiControllerClass = \App\Http\Controllers\Api\TeacherController::class;
}
