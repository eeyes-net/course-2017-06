<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @package App
 *
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $excerpt
 * @property string $content
 * @property int $visit_count
 *
 * @property array $metas
 */
class Post extends Model
{
    protected $with = [
        'metas',
    ];

    public function metas()
    {
        return $this->hasMany(PostMeta::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Post::class, 'teacher_course', 'teacher_id', 'course_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Post::class, 'teacher_course', 'course_id', 'teacher_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 排序算法
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('visit_count', 'desc');
    }

    /**
     * 排序算法
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return mixed
     */
    public function scopePaginatePluckSimpleData($query)
    {
        $paginator = $query->paginate();
        $paginator->setCollection($paginator->getCollection()->pluck('simple_data'));
        return $paginator;
    }

    /**
     * 搜索
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $q 查找的文字
     *
     * @return mixed
     */
    public function scopeSearch($query, $q)
    {
        $q = sql_filter($q);
        if (empty($q)) {
            return $query->whereRaw('FALSE');
        }
        // replace '你好世界' with '%你%好%世%界%';
        $q = '%' . preg_replace('/./u', '$0%', $q);
        return $query->where('title', 'like', $q)
            ->orWhere('excerpt', 'like', $q);
    }

    /**
     * 获取元数据的值
     *
     * @param null|array|string $name null全部，array指定几个，string某一个
     * @param mixed $default 默认值
     *
     * @return mixed
     */
    public function getMeta($name = null, $default = null)
    {
        if (is_null($name)) {
            $result = [];
            foreach ($this->metas as $meta) {
                $result[$meta->meta_key] = $meta->meta_value;
            }
        } elseif (is_array($name)) {
            $result = [];
            foreach ($this->metas as $meta) {
                if (in_array($meta->meta_key, $name)) {
                    $result[$meta->meta_key] = $meta->meta_value;
                }
            }
            foreach ($name as $name1) {
                if (!isset($result[$name1])) {
                    $result[$name1] = $default;
                }
            }
        } else {
            $result = $default;
            foreach ($this->metas as $meta) {
                if ($meta->meta_key === $name) {
                    $result = $meta->meta_value;
                }
            }
        }
        return $result;
    }

    /**
     * 设定元数据的值
     *
     * @param string $name
     * @param mixed $value
     *
     * @return mixed
     */
    public function setMeta($name, $value)
    {
        $post_meta = $this->metas->where('name', $name)->first();
        if (!$post_meta) {
            $post_meta = new PostMeta();
            $post_meta->meta_key = $name;
            $post_meta->post_id = $this->id;
        }
        $post_meta->meta_value = $value;
        $post_meta->save();
        return $post_meta;
    }

    /**
     * 获取所有有用信息
     *
     * @return array
     * @throws PostTypeException
     */
    public function getDataAttribute()
    {
        switch ($this->type) {
            case 'course':
                $metas = $this->getMeta(['category', 'credit']);
                return [
                    'id' => $this->id,
                    'type' => $this->type,
                    'title' => $this->title,
                    'excerpt' => $this->excerpt,
                    'content' => $this->content,
                    'visit_count' => $this->visit_count,
                    'category' => $metas['category'],
                    'credit' => $metas['credit'],
                    'teachers' => $this->teachers->pluck('simple_data'),
                ];
                break;
            case 'teacher':
                $metas = $this->getMeta(['department', 'email']);
                return [
                    'id' => $this->id,
                    'type' => $this->type,
                    'title' => $this->title,
                    'excerpt' => $this->excerpt,
                    'content' => $this->content,
                    'visit_count' => $this->visit_count,
                    'department' => $metas['department'],
                    'email' => $metas['email'],
                    'courses' => $this->courses->pluck('simple_data'),
                ];
                break;
            default:
                throw new PostTypeException($this, 'course|teacher');
        }
    }

    /**
     * 获取所有有用信息
     *
     * @return array
     * @throws PostTypeException
     */
    public function getSimpleDataAttribute()
    {
        switch ($this->type) {
            case 'course':
            case 'teacher':
                return [
                    'id' => $this->id,
                    'type' => $this->type,
                    'title' => $this->title,
                    'excerpt' => $this->excerpt,
                    'visit_count' => $this->visit_count,
                ];
                break;
            default:
                throw new PostTypeException($this, 'course|teacher');
        }
    }
}
