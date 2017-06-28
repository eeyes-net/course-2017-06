<?php

namespace App\Http\Controllers\Api;

use App\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request) {
        $content = $request->input('content', '');
        if (empty($content)) {
            return build_api_return(null, 400, '内容不能为空');
        }
        $feedback = new Feedback();
        $feedback->content = $content;
        $feedback->save();
        return null;
    }
}
