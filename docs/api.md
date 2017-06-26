# API文档

## 通用接口格式

### 接口地址

`https://course.dev/api/...`

地址前面统一加`api/`

### 数据提交格式

使用json格式提交数据，header部分要有`Content-Type: application/json`

### 数据返回格式

统一返回json格式数据

```json
{
    "code": 200,
    "msg": "OK",
    "data": []
}
```

* `data`部分可以是`{}`或`[]`

* `code=200`一定`msg=OK`，其他错误代码或者返回消息见下方具体说明。

* HTTP状态码与返回的json中的`code`字段不一定一样

    | HTTP状态码 | 说明 |
    | :--- | :--- |
    | 200 OK | 服务器处理正常（但可能参数不合理，返回`code`不为`200`） |
    | 400 Bad request | 必选参数不存在 |
    | 403 Forbidden | 未授权（检查cookie或token） |
    | 404 Not Found | 此路由不存在 |
    | 500 Internal Server Error | 服务器内部错误（联系后台同学） |

* 只有`HTTP 200 OK`会正常返回json，其他状态码body部分不会有数据

## API

### 课程首页

```text
GET /api/post/courses?page=1
```

* 没有page参数则默认为page=1

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 2,
                "type": "course",
                "title": "课程A的名称",
                "excerpt": "课程A的简介",
                "visit_count": 0
            },
            {
                "id": 3,
                "type": "course",
                "title": "课程B的名称",
                "excerpt": "课程B的简介",
                "visit_count": 0
            }
        ],
        "from": 1,
        "last_page": 1,
        "next_page_url": null,
        "path": "http://course.dev/api/post/courses",
        "per_page": 15,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    }
}
```

### 教师首页

```text
GET /api/post/teachers?page=1
```

* 没有page参数则默认为page=1

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "type": "teacher",
                "title": "教师A的名称",
                "excerpt": "教师A的简介",
                "visit_count": 0
            },
            {
                "id": 4,
                "type": "teacher",
                "title": "教师B的名称",
                "excerpt": "教师B的简介",
                "visit_count": 0
            }
        ],
        "from": 1,
        "last_page": 1,
        "next_page_url": null,
        "path": "http://course.dev/api/post/teachers",
        "per_page": 15,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    }
}
```

### 通用查找页

```text
GET /api/post/s?q=课程A&page=1
```

* q参数应该经过urlencoded（例如`%E8%AF%BE%E7%A8%8BA`）
* 没有page参数则默认为page=1

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 2,
                "type": "course",
                "title": "课程A的名称",
                "excerpt": "课程A的简介",
                "visit_count": 0
            }
        ],
        "from": 1,
        "last_page": 1,
        "next_page_url": null,
        "path": "http://course.dev/api/post/s",
        "per_page": 15,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```

* q为空返回空集

### 课程、教师详情页

```text
GET /api/post/{id}
```

* 此处id为通过其他接口获取到的id

#### 教师详情页返回内容

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "id": 1,
        "type": "teacher",
        "title": "教师A的名称",
        "excerpt": "教师A的简介",
        "content": "教师A的具体介绍",
        "visit_count": 0,
        "department": "教师A的学院或部门",
        "email": "教师A的E-mail",
        "courses": [
            {
                "id": 2,
                "type": "course",
                "title": "课程A的名称",
                "excerpt": "课程A的简介",
                "visit_count": 0
            },
            {
                "id": 3,
                "type": "course",
                "title": "课程B的名称",
                "excerpt": "课程B的简介",
                "visit_count": 0
            }
        ]
    }
}
```

#### 课程详情页返回内容

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "id": 2,
        "type": "course",
        "title": "课程A的名称",
        "excerpt": "课程A的简介",
        "content": "课程A的具体介绍",
        "visit_count": 0,
        "category": "课程A的大类",
        "credit": "课程A的学分",
        "teachers": [
            {
                "id": 1,
                "type": "teacher",
                "title": "教师A的名称",
                "excerpt": "教师A的简介",
                "visit_count": 0
            },
            {
                "id": 4,
                "type": "teacher",
                "title": "教师B的名称",
                "excerpt": "教师B的简介",
                "visit_count": 0
            }
        ]
    }
}
```

### 查看评论

```text
GET /api/post/{id}/comment?page=1
```

* 没有page参数则默认为page=1

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "post_id": 1,
                "content": "Hello, world!",
                "created_at": "2017-06-23 17:16:56"
            }
        ],
        "from": 1,
        "last_page": 1,
        "next_page_url": null,
        "path": "http://course.dev/api/post/1/comment",
        "per_page": 15,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```

* 仅显示已通过评论

### 发布评论

```text
POST /api/post/{id}/comment
Content-Type: application/json

{
    "content": "Hello, world!"
}
```

```json
{
    "code": 200,
    "msg": "OK",
    "data": null
}
```
