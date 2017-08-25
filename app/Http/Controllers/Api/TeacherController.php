<?php

namespace App\Http\Controllers\Api;

use App\Teacher;

class TeacherController extends Controller
{
    use PostControllerTrait;

    protected $model = Teacher::class;
}
