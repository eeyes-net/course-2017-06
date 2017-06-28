<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::ordered()->paginatePluckSimpleData();
    }

    public function courses_categorized()
    {
        $result = [];
        $categories = Category::all();
        foreach ($categories as $category) {
            $result[$category->name] = $category->courses()->limit(2)->ordered()->get()->pluck('simple_data');
        }
        return $result;
    }

    public function courses()
    {
        return Post::ofType('course')->ordered()->paginatePluckSimpleData();
    }

    public function teachers()
    {
        return Post::ofType('teacher')->ordered()->paginatePluckSimpleData();
    }

    public function show($id)
    {
        return Post::find($id)->data;
    }

    public function search(Request $request)
    {
        $q = $request->query('q', '');
        return Post::search($q)->ordered()->paginatePluckSimpleData()->appends(compact('q'));
    }
}
