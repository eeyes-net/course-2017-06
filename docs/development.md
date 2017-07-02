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

本项目的数据库结构仿照WordPress，例如`post`表是课程和教师信息，`post_meta`是额外的单独信息，方便扩展。

| 表名 | 模型 | 说明 |
| :---: | :---: | :---: |
| posts | \App\Post | 课程和教师信息（之后简称“文章”） |
| post_metas | \App\PostMeta | 课程和教师扩展信息 |
| teacher_course |  | 教师和课程的多对多关联 |
| comments | \App\Comment | 文章的评论 |
| categories | \App\Category | 专业大类 |
| category_course |  | 专业大类和课程的多对多关联 |
| feedback | \App\Feedback | 反馈信息 |
| admin_* | \Encore\Admin\Auth\Database\\* | Laravel admin的表 |
