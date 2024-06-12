# SimpleCMS

测试包，请勿滥用。

## 安装流程

安装测试流程

### 安装包

```bash
composer create simplecms/simplecms simplecms #目录名
```

### 安装数据库

```bash
php artisan migrate
```

### 导入默认数据

```bash
php artisan db:seed DictSeeder
php artisan db:seed ManagerSeeder
php artisan db:seed MenuSeeder
```
