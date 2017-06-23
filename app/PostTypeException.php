<?php

namespace App;

use Exception;

class PostTypeException extends Exception
{
    public function __construct(Post $post, $expect, $message = null)
    {
        if (is_null($message)) {
            $message = "Post type '$expect' expected, but '{$post->type}' found where post_id = {$post->id}.";
        }
        parent::__construct($message);
    }
}
