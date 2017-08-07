# 课程、教师通用

## 全部文章

```text
GET {{host}}/post?page={{page}}
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
                "id": 3,
                "type": "course",
                "title": "课程B的名称",
                "excerpt": "课程B的简介",
                "categories": [
                    "工科一",
                    "工科二"
                ],
                "visit_count": 8
            },
            {
                "id": 2,
                "type": "course",
                "title": "课程A的名称",
                "excerpt": "课程A的简介",
                "categories": [
                    "工科二",
                    "理科"
                ],
                "visit_count": 7
            },
            {
                "id": 1,
                "type": "teacher",
                "title": "教师A的姓名",
                "excerpt": "教师A的简介",
                "visit_count": 2
            }
        ],
        "from": 1,
        "last_page": 1,
        "next_page_url": null,
        "path": "https://course.eeyes.net/api/post",
        "per_page": 15,
        "prev_page_url": null,
        "to": 3,
        "total": 3
    }
}
```

## 查找文章

```text
GET {{host}}/post/s?q={{search_query}}&page={{page}}
```

* 没有page参数则默认为page=1
* 返回数据格式全部文章

## 文章内容页

```text
GET {{host}}/post/{{post_id}}
```

## 查看评论

```text
GET {{host}}/post/{{post_id}}/comment?page={{page}}
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
                "created_at": "2017-06-23 17:16:56",
                "likes_count": 2
            }
        ],
        "from": 1,
        "last_page": 1,
        "next_page_url": null,
        "path": "https://course.eeyes.net/api/post/1/comment",
        "per_page": 15,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```

## 发表评论

```text
POST {{host}}/post/{{post_id}}/comment
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

## 评论点赞

```text
POST {{host}}/comment/{{comment_id}}/like
```

```json
{
    "code": 200,
    "msg": "OK",
    "data": null
}
```
