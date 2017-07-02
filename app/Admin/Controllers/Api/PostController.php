<?php

namespace App\Admin\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        $q = request()->get('q');
        return Post::where('title', 'like', "%$q%")->paginate(null, ['id', 'title as text']);
    }
}
