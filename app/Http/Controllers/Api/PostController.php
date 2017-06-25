<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $course = Post::where('type', 'course')->limit(2)->ordered()->get()->pluck('simple_data')->toArray();
        $teacher = Post::where('type', 'teacher')->limit(2)->ordered()->get()->pluck('simple_data')->toArray();
        return compact('course', 'teacher');
    }

    public function show($id)
    {
        return Post::find($id)->data;
    }

    public function search(Request $request)
    {
        return Post::search($request->query('q', ''))->pluck('simple_data');
    }
}
