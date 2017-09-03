<?php

namespace App\Http\Controllers\Web;

class CategoryController extends Controller
{
    use WebControllerTrait;

    protected $apiControllerClass = \App\Http\Controllers\Api\CategoryController::class;

    public function courses($name)
    {
        return $this->apiController()->courses($name);
    }
}
