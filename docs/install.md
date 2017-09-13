# 安装说明

## 环境要求

* php >=5.6.4

具体要求请参考[Laravel 5.4 安装说明](https://laravel.com/docs/5.4/#installation)

## 安装步骤

1. 创建数据库用户、数据库
2. 将代码解压到服务器，分配一个域名的根目录到`public/`文件夹
3. 执行`composer install`
4. 执行`chmod 777 storage -R` `chmod 777 bootstrap/cache -R`
5. 修改`.env`文件中的数据库相关配置（生产环境请关闭`APP_DEBUG`）
6. 执行`php artisan migrate`
7. 执行`php artisan vendor:publish --tag=laravel-admin`
8. 执行`php artisan admin:install`，（生产环境下：第一个提示（数据库迁移）输入`yes`，第二个提示（创建Admin文件夹）输入`no`）
9. 执行`php artisan admin:menu:install`

## 安装完成后

* 访问后台管理页面`/admin`，默认用户名和密码均为`admin`，请及时修改密码
* Laravel-admin的其他配置请参考[Laravel admin 快速开始](https://z-song.github.io/laravel-admin/#/zh/quick-start)
