# 开发说明

## 框架

本项目采用[Laravel 5.4](https://laravel.com/docs/5.4)进行开发，使用[Laravel Admin](https://z-song.github.io/laravel-admin/#/zh/)开发后台管理页面

### 目录结构

| 目录 | 说明 |
| :---: | :--- |
| app | 应用主要代码目录（主要开发目录），全部文件都需要维护（部分文件为Laravel安装器自动生成） |
| bootstrap | Laravel启动文件目录，通常不需要改动 |
| config | 一般不需要改，必要时修改 |
| database | 通常只改动其中的migrations文件夹中的数据库迁移文件 |
| docs | 说明文档，必须及时更新维护，保证与代码的统一 |
| public | 服务器根目录，根目录下的文件一般不改，只改子文件夹的文件 |
| resources | 资源目录（本项目是纯API接口，不涉及此目录） |
| routes | 路由目录（主要开发目录） |
| storage | 通常不需要改动 |
| tests | 应该与代码保持一致（由于项目较小，可以忽略） |
| vendor | 不需要手动修改 |

## 数据库

| 表名 | 模型 | 说明 |
| :---: | :---: | :---: |
| admin_* | \Encore\Admin\Auth\Database\\* | Laravel admin的表 |
| api_logs | \App\ApiLog | API记录 |
| categories | \App\Category | 课程分类 |
| comments | \App\Comment | 评论 |
| comment_likes | \App\CommentLike | 评论点赞 |
| courses | \App\Course | 课程 |
| downloads | \App\Download | 下载 |
| feedback | \App\Feedback | 反馈 |
| teachers | \App\Teacher | 教师 |
| category_course |  | 课程分类和课程的多对多关联 |
| course_download |  | 课程和下载的多对多关联 |
| course_teacher |  | 课程和教师的多对多关联 |
