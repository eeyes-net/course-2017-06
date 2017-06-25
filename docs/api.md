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
GET /api/post/
```

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "course": [
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
        "teacher": [
            {
                "id": 1,
                "type": "teacher",
                "title": "教师A的名称",
                "excerpt": "教师A的简介",
                "visit_count": 0
            }
        ]
    }
}
```
