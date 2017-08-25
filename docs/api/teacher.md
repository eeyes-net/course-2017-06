# 教师

返回格式和[课程](course.md)相同，省略

## 列表

```text
GET {{host}}/teacher?page={{page}} 
```

## 查找

```text
GET {{host}}/teacher/s?q={{search_query}}&page={{page}} 
```

## 详情

```text
GET {{host}}/teacher/{{teacher_id}} 
```

## 评论列表

```text
GET {{host}}/teacher/{{teacher_id}}/comment?page={{page}} 
```

## <a id="post_comment"></a>发表评论

```text
POST {{host}}/teacher/{{cousre_id}}/comment 
Content-Type: application/json

{
    "content": "Hello, world!"
}
```