# 反馈

## 发送反馈

```text
POST {{host}}/feedback
Content-Type: application/json

{
    "content": "Hello, world!",
    "contact": "13579246810 or 10000@qq.com or 10000"
}
```

`contact`字段非必需

```json
{
    "code": 200,
    "msg": "OK",
    "data": null
}
```
