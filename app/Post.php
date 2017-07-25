<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @package App
 *
 * @property int $id ID
 * @property string $type 文章类型
 * @property string $title 文章标题
 * @property string $excerpt 文章简介
 * @property string $content 文章内容
 * @property int $visit_count 访问量
 *
 * @property \Illuminate\Database\Eloquent\Collection $metas
 * @property \Illuminate\Database\Eloquent\Collection $categories
 * @property \Illuminate\Database\Eloquent\Collection $data
 * @property \Illuminate\Database\Eloquent\Collection $simple_data
 * @property \Illuminate\Database\Eloquent\Collection $courses
 * @property \Illuminate\Database\Eloquent\Collection $teachers
 * @property \Illuminate\Database\Eloquent\Collection $downloads
 * @property string $credit 课程学分
 * @property string $avatar 教师头像（数据库中的值）
 * @property string $avatar_url 教师头像（完整链接）
 * @property string $email 教师邮箱
 * @property string $department 教师的学院或部门
 *
 * @method \Illuminate\Database\Query\Builder ordered
 * @method \Illuminate\Database\Query\Builder ofType
 * @method \Illuminate\Database\Query\Builder paginatePluckSimpleData
 * @method \Illuminate\Database\Query\Builder search
 * @method static Post find($id)
 */
class Post extends Model
{
    protected $with = [
        'metas',
        'categories',
    ];
    protected $hidden = ['metas'];
    protected $appends = [
        'credit',
        'avatar',
        'email',
        'department'
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_course', 'course_id', 'category_id');
    }

    public function downloads()
    {
        return $this->belongsToMany(Download::class, 'course_download', 'course_id', 'download_id');
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
     * @param string $type 类型
     *
     * @return mixed
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
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
        $post_meta = $this->metas->where('meta_key', $name)->first();
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
                return [
                    'id' => $this->id,
                    'type' => $this->type,
                    'title' => $this->title,
                    'excerpt' => $this->excerpt,
                    'content' => $this->content,
                    'categories' => $this->categories->pluck('name'),
                    'visit_count' => $this->visit_count,
                    'credit' => $this->credit,
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
                    'department' => $this->department,
                    'email' => $this->email,
                    'courses' => $this->courses->pluck('simple_data'),
                    'avatar' => $this->avatar_url,
                    'downloads' => $this->downloads->pluck('simple_data'),
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
                return [
                    'id' => $this->id,
                    'type' => $this->type,
                    'title' => $this->title,
                    'excerpt' => $this->excerpt,
                    'categories' => $this->categories->pluck('name'),
                    'visit_count' => $this->visit_count,
                ];
                break;
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

    public function getAvatarAttribute()
    {
        return $this->getMeta('avatar', '');
    }

    public function setAvatarAttribute($value)
    {
        if ($this->type !== 'teacher') {
            throw new PostTypeException($this, 'teacher');
        }
        $this->setMeta('avatar', $value);
    }

    public function getAvatarUrlAttribute()
    {
        return config('filesystems.disks.admin.url') . '/' . $this->avatar;
    }

    public function getCreditAttribute()
    {
        return $this->getMeta('credit', '');
    }

    public function setCreditAttribute($value)
    {
        if ($this->type !== 'course') {
            throw new PostTypeException($this, 'course');
        }
        $this->setMeta('credit', $value);
    }

    public function getDepartmentAttribute()
    {
        return $this->getMeta('department', '');
    }

    public function setDepartmentAttribute($value)
    {
        if ($this->type !== 'teacher') {
            throw new PostTypeException($this, 'teacher');
        }
        $this->setMeta('department', $value);
    }

    public function getEmailAttribute()
    {
        return $this->getMeta('email', '');
    }

    public function setEmailAttribute($value)
    {
        if ($this->type !== 'teacher') {
            throw new PostTypeException($this, 'teacher');
        }
        $this->setMeta('email', $value);
    }
}
