<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\CommentLike;

class CommentController extends Controller
{
    public function like($id)
    {
        $like = new CommentLike();
        Comment::find($id)->likes_relation()->save($like);
        return null;
    }
}
