# 课程

## 课程首页（每个专业大类显示两个课程）

```text
GET {{host}}/post/courses/categorized
```

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "工科一": [
            {
                "id": 3,
                "type": "course",
                "title": "课程B的名称",
                "excerpt": "课程B的简介",
                "categories": [
                    "工科一",
                    "理科"
                ],
                "visit_count": 8
            }
        ],
        "工科二": [
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
            }
        ],
        "理科": [
            {
                "id": 3,
                "type": "course",
                "title": "课程B的名称",
                "excerpt": "课程B的简介",
                "categories": [
                    "工科一",
                    "理科"
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
            }
        ]
    }
}
```

## 课程列表

```text
GET {{host}}/post/courses?page={{page}}
```

* 没有page参数则默认为page=1
* 返回数据格式全部文章

## 某专业大类课程列表

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
                    "理科"
                ],
                "visit_count": 8
            },
            {
                "id": 2,
                "type": "course",
                "title": "课程A的名称",
                "excerpt": "课程A的简介",
                "categories": [
                    "工科一",
                    "工科二",
                    "理科"
                ],
                "visit_count": 7
            }
        ],
        "from": 1,
        "last_page": 1,
        "next_page_url": null,
        "path": "https://course.eeyes.net/api/category/%E5%B7%A5%E7%A7%91%E4%B8%80/courses",
        "per_page": 15,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    }
}
```

## 专业大类列表

```text
GET {{host}}/category?page={{page}}
```

```json
{
    "code": 200,
    "msg": "OK",
    "data": [
        {
            "id": 1,
            "name": "工科一",
            "excerpt": "工科一的简介"
        },
        {
            "id": 2,
            "name": "工科二",
            "excerpt": "工科二的简介"
        },
        {
            "id": 3,
            "name": "理科",
            "excerpt": "理科的简介"
        }
    ]
}
```

## 专业大类详情

```text
GET {{host}}/category/{{category_name}}
```

例如：
```text
GET {{host}}/category/工科一
```

* `category_name`需要经过urlencoded（例如：`工科一`需写成`E5%B7%A5%E7%A7%91%E4%B8%80`）

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "id": 1,
        "name": "工科一",
        "excerpt": "工科一的简介",
        "content": "工科一"
    }
}
```
