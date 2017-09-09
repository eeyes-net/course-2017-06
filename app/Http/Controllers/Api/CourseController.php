<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Course;

class CourseController extends Controller
{
    use PostControllerTrait;

    protected $model = Course::class;
}
