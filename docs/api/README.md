# API文档

## 通用接口格式

### 接口地址

`https://course.eeyes.net/api/...`

注意：地址前面统一加`api/`

以下所有的`{{host}}`代表`https://course.eeyes.net/api`

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

### [课程、教师通用](post.md)

* 全部文章
* 查找文章
* 文章内容页
* 文章评论
    * 查看评论
    * 发表评论

### [教师](teacher.md)

* 教师列表（教师首页）

### [课程](course.md)

* 课程首页（每个专业大类显示两个课程）
* 课程列表
* 某专业大类课程列表
* 专业大类
    * 专业大类列表
    * 专业大类详情

### [其他](other.md)

* 发送反馈
