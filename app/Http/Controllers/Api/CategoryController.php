<?php

namespace App\Http\Controllers\Api;

use App\Category;

class CategoryController extends Controller
{
    use PostControllerTrait;

    protected $model = Category::class;

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
        $category = Category::findByName($name);
        if (!$category) {
            return null;
        }
        return $category->courses_relation()->ordered()->paginatePluckSimpleData();
    }

    public function courseIndex()
    {
        $result = [];
        $categories = Category::all();
        foreach ($categories as $category) {
            $result[] = [
                'name' => $category->name,
                'data' => $category->courses_relation()->limit(2)->ordered()->get()->pluck('simple_data'),
            ];
        }
        return $result;
    }
}
