<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * 排序算法
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query;
    }
}
