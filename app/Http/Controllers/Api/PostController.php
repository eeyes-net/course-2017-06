<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::limit(5)->ordered()->get()->pluck('simple_data');
    }

    public function courses()
    {
        $result = [];
        $categories = Category::all();
        foreach ($categories as $category) {
            $result[$category->name] = $category->courses()->limit(2)->ordered()->paginatePluckSimpleData();
        }
        return $result;
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
