<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use Eeyes\Common\Api\Eeyes\Notification;
use Illuminate\Http\Request;

/**
 * Trait PostControllerTrait
 *
 * @package App\Http\Controllers\Api
 *
 * @property \App\PostTrait $model
 */
trait PostControllerTrait
{
    public function index()
    {
        return $this->model::ordered()->paginatePluckSimpleData();
    }

    public function show($id)
    {
        $model = $this->model::find($id);
        increase_visit_count($model);
        return $model;
    }

    public function search(Request $request)
    {
        $q = $request->query('q', '');
        if (empty($q)) {
            return [];
        }
        return $this->model::search($q)->ordered()->paginatePluckSimpleData();
    }

    public function comment($id)
    {
        return $this->model::find($id)->comments_relation()->approved()->ordered()->paginate();
    }

    public function commentStore(Request $request, $id)
    {
        $content = $request->input('content', '');
        if (empty($content)) {
            return build_api_return(null, 400, '内容不能为空');
        }
        $comment = new Comment();
        $comment->content = $content;
        $model = $this->model::find($id);
        $model->comments_relation()->save($comment);
        Notification::dingTalk("【e学堂评论】\r\n内容：{$comment->content}\r\n文章标题：{$model->title}");
        return null;
    }
}