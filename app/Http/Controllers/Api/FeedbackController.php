<?php

namespace App\Http\Controllers\Api;

use App\Feedback;
use Eeyes\Common\Api\Eeyes\Notification;
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
        $feedback->contact = $request->input('contact', '');
        $feedback->save();
        Notification::dingTalk("【e学堂意见反馈】\r\n内容：{$feedback->content}\r\n联系方式：{$feedback->contact}");
        return null;
    }
}
