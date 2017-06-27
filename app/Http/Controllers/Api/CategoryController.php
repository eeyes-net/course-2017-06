<?php

namespace App\Http\Controllers\Api;

use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all()->pluck('simple_data');
    }

    public function show($name)
    {
        return Category::findByName($name);
    }

    public function courses($name)
    {
        if (!is_string($name)) {
            abort(400);
            return;
        }
        $category = Category::findByName($name);
        if (!$category) {
            abort(404);
            return;
        }
        return $category->courses()->ordered()->paginatePluckSimpleData();
    }
}
