#### RBAC脚手架

1. 基于laravel5.8框架
2. 开箱即用

#### 使用

1. 拉取代码
2. 执行 composer install 或 composer update
3. 完善配置
4. 执行 php artisan migrate 创建数据表
5. 执行  php artisan db:seed --class=RBACSeeder 填充初始数据
6. 测试url：http://localhosts/admin/login,测试账号 admin@admin.com 密码：123456