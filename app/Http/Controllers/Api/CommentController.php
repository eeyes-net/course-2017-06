<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
    {
        return Post::find($id)->comments()->where('approved', '1')->ordered()->get();
    }

    public function store(Request $request, $id)
    {
        $content = $request->input('content', '');
        if (empty($content)) {
            return build_api_return(null, 400, '内容不能为空');
        }
        $comment = new Comment();
        $comment->content = $content;
        Post::find($id)->comments()->save($comment);
        return null;
    }
}
