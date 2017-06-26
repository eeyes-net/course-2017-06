<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class PostController extends Controller
{
    public function index() {
        return redirect(action('Api\PostController@courses'));
    }

    public function courses()
    {
        /** @var Paginator $courses */
        return Post::where('type', 'course')->ordered()->paginatePluckSimpleData();
    }

    public function teachers()
    {
        /** @var Paginator $courses */
        return Post::where('type', 'teacher')->ordered()->paginatePluckSimpleData();
    }

    public function show($id)
    {
        return Post::find($id)->data;
    }

    public function search(Request $request)
    {
        $q = $request->query('q', '');
        return Post::search($request->query('q', ''))->ordered()->paginatePluckSimpleData()->appends(compact('q'));
    }
}
