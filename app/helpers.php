<?php

/**
 * @param string $sql
 *
 * @return string mixed
 */
function sql_filter($sql)
{
    return str_replace(
        ["'", '"', '&', '|', '@', '%', '*', '(', ')', '-', '\\'],
        ['', '', '', '', '', '', '', '', '', '', ''],
        $sql);
}

/**
 * 搜索
 *
 * @param \Illuminate\Database\Query\Builder $query
 * @param string $q 查找的文字
 *
 * @return mixed
 */
function query_search(&$query, $q, $searchFields = null)
{
    $q = sql_filter($q);
    if (empty($q)) {
        return $query->whereRaw('FALSE');
    }
    // replace '你好世界' with '%你%好%世%界%';
    $q = '%' . preg_replace('/./u', '$0%', $q);
    if (!isset($searchFields)) {
        $searchFields = [
            'title',
            'excerpt',
            'content',
        ];
    }
    foreach ($searchFields as $field) {
        $query->orWhere($field, 'like', $q);
    }
    return $query;
}

function build_api_return($data = null, $code = 200, $msg = 'OK')
{
    return [
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
    ];
}

/**
 * 页码列表
 *
 * @link https://gist.github.com/kottenator/9d936eb3e4e3c3e02598
 * @return {Array}
 */
function pageList($last, $current, $delta = 2)
{
    $left = $current - $delta;
    $right = $current + $delta;
    $range = [];
    for ($i = 1; $i <= $last; ++$i) {
        if ($i === 1 || $i === $last || $i >= $left && $i <= $right) {
            $range[] = $i;
        }
    }
    $result = [];
    $lastPage = 0;
    for ($i = 0; $i < count($range); ++$i) {
        $page = $range[$i];
        $deltaPage = $page - $lastPage;
        if ($deltaPage > 2) {
            $result[] = [
                'paginationEllipsis' => true,
                'page' => '\u8230',
                'isCurrent' => false,
            ];
        } else {
            if ($deltaPage === 2) {
                $result[] = [
                    'page' => $page - 1,
                    'paginationEllipsis' => false,
                    'isCurrent' => false,
                ];
            }
        }
        $result[] = [
            'page' => $page,
            'paginationEllipsis' => false,
            'isCurrent' => ($page === $current),
        ];
        $lastPage = $page;
    }
    return $result;
}

/**
 * @param \Illuminate\Database\Eloquent\Model $model
 */
function increase_visit_count($model)
{
    try {
        $model->increment('visit_count');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->errorInfo[1] !== 1054) {
            throw $e;
        }
    }
}

/**
 * 更新用户名称
 *
 * @param \Encore\Admin\Auth\Database\Administrator|string $user
 *
 * @return \Encore\Admin\Auth\Database\Administrator|\Illuminate\Database\Eloquent\Model|null|string|static
 */
function update_admin_name($user)
{
    if (is_string($user)) {
        $user = \Encore\Admin\Auth\Database\Administrator::where(['username' => $user])->first();
    }
    if ($user instanceof \Encore\Admin\Auth\Database\Administrator) {
        $user_info = \App\Library\Eeyes\Api\XjtuUserInfo::getByNetId($user->username);
        $user->name = $user_info ? $user_info['username'] : ucfirst($user);
        $user->save();
        return $user;
    }
    return null;
}
