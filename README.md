# SimpleCMS

## 中文 / Chinese

SimpleCMS 是一个围绕 SimpleCMS-Framework 构建的 CMS 产品化方案，底层基于 Laravel 12，并采用 Inertia + Vue 3 实现前端交互与页面渲染。它不仅是一个企业站示例，更是一个面向内容管理、后台运营与前端展示一体化的可扩展 SimpleCMS IP。

### 项目定位

- IP 核心：以 SimpleCMS 为品牌与能力基座，形成统一的内容管理与企业展示能力体系
- 技术底座：SimpleCMS-Framework 提供统一的后台能力、模块化服务、权限与数据编排能力
- 后端框架：Laravel 12 负责稳定的路由、控制器、模型、认证与数据库管理
- 前端渲染：Inertia + Vue 3 负责页面渲染、交互能力和企业级展示层
- 业务场景：企业官网、产品展示、资讯发布、轻型 CMS、内部管理后台的快速落地

### 适用技术栈

- 底座框架：SimpleCMS-Framework
- 后端：PHP 8.2 + Laravel 12
- 前端：Vue 3 + Inertia.js + Vite
- 样式：SCSS + Element Plus
- 生态：Sanctum、Media Library、Ziggy

### 目录结构

```text
simplecms/
├─ app/
├─ config/
├─ database/
├─ public/
├─ resources/
│  ├─ js/
│  └─ views/
├─ routes/
├─ storage/
├─ tests/
├─ composer.json
├─ package.json
├─ vite.config.js
├─ phpunit.xml
├─ README.md
└─ .env
```

### 快速开始

#### 1. 安装依赖

```bash
composer install
npm install
```

#### 2. 配置环境变量

```bash
cp .env.example .env
```

然后补充数据库配置：

- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

生成应用 Key：

```bash
php artisan key:generate
```

#### 3. 执行数据库迁移

```bash
php artisan migrate
```

#### 4. 初始化基础数据（如需要）

```bash
php artisan db:seed
```

或者按需要单独执行：

```bash
php artisan db:seed DictSeeder
php artisan db:seed ManagerSeeder
php artisan db:seed MenuSeeder
```

### 前台展示页

当前前台已具备以下页面：

- 首页：/
- 关于：/about
- 服务：/services
- 方案：/solutions
- 产品：/products
- 案例：/cases
- 新闻：/news
- 新闻详情：/news/{slug}
- 联系：/contact

对应控制器：

- [app/Http/Controllers/Frontend/HomeController.php](app/Http/Controllers/Frontend/HomeController.php)

对应路由：

- [routes/web.php](routes/web.php)

### 后台入口

后台入口位于：

```text
/backend
```

含基础管理模块：用户、字典、菜单、日志、角色、系统设置等。

### 开发命令

#### 启动前端开发

```bash
npm run dev
```

#### 构建生产资源

```bash
npm run build
```

### 已验证状态

已实际执行并验证：

```bash
npm run build
```

验证结果：构建成功，生成了前端产物，未出现 Vue 模板编译错误。

### 文档索引

详细文档请参见：

- [docs/README.md](docs/README.md)
- [docs/01-项目概览.md](docs/01-%E9%A1%B9%E7%9B%AE%E6%A6%82%E8%A7%80.md)
- [docs/02-前端页面与交互说明.md](docs/02-%E5%89%8D%E7%AB%AF%E9%A1%B5%E9%9D%A2%E4%B8%8E%E4%BA%A4%E4%BA%92%E8%AF%B4%E6%98%8E.md)
- [docs/03-后端架构与模块说明.md](docs/03-%E5%90%8E%E7%AB%AF%E6%9E%B6%E6%9E%84%E4%B8%8E%E6%A8%A1%E5%9D%97%E8%AF%B4%E6%98%8E.md)
- [docs/04-部署、环境与扩展指南.md](docs/04-%E9%83%A8%E7%BD%B2%E3%80%81%E7%8E%AF%E5%A2%83%E4%B8%8E%E6%89%A9%E5%B1%95%E6%8C%87%E5%8D%97.md)

### 说明

这个项目适合作为：

- 企业官网模板
- 内容管理系统基础项目
- 营销型前台 + 后台管理一体化方案
- 二次开发的快速启动工程

后续若要继续扩展，可在此基础上增加：文章管理、栏目树、内容审核、用户权限细化和更完整的运营后台功能。

---

## English / 英文

SimpleCMS is a productized CMS solution built around the SimpleCMS-Framework, powered by Laravel 12 and rendered with Inertia + Vue 3 on the frontend. It is not just an enterprise site demo; it is an extendable SimpleCMS IP designed for content management, operational control, and frontend presentation in one system.

### Product Positioning

- Brand core: SimpleCMS acts as the product identity and capability foundation for a unified content management and enterprise display system
- Technology base: SimpleCMS-Framework provides backend capabilities, modular services, permissions, and data orchestration
- Backend framework: Laravel 12 handles routing, controllers, models, authentication, and database management
- Frontend rendering: Inertia + Vue 3 provides page rendering, interaction patterns, and enterprise presentation layers
- Business scenarios: enterprise official sites, showcase pages, news publishing, lightweight CMS, and rapid internal admin platform delivery

### Tech Stack

- Core framework: SimpleCMS-Framework
- Backend: PHP 8.2 + Laravel 12
- Frontend: Vue 3 + Inertia.js + Vite
- Styling: SCSS + Element Plus
- Ecosystem: Sanctum, Media Library, Ziggy

### Project Structure

```text
simplecms/
├─ app/
├─ config/
├─ database/
├─ public/
├─ resources/
│  ├─ js/
│  └─ views/
├─ routes/
├─ storage/
├─ tests/
├─ composer.json
├─ package.json
├─ vite.config.js
├─ phpunit.xml
├─ README.md
└─ .env
```

### Quick Start

#### 1. Install dependencies

```bash
composer install
npm install
```

#### 2. Configure environment variables

```bash
cp .env.example .env
```

Then configure:

- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

Generate the app key:

```bash
php artisan key:generate
```

#### 3. Run migrations

```bash
php artisan migrate
```

#### 4. Seed base data if needed

```bash
php artisan db:seed
```

Or run specific seeders when needed:

```bash
php artisan db:seed DictSeeder
php artisan db:seed ManagerSeeder
php artisan db:seed MenuSeeder
```

### Frontend Pages

The current frontend includes:

- Home: /
- About: /about
- Services: /services
- Solutions: /solutions
- Products: /products
- Cases: /cases
- News: /news
- News detail: /news/{slug}
- Contact: /contact

Controller:

- [app/Http/Controllers/Frontend/HomeController.php](app/Http/Controllers/Frontend/HomeController.php)

Routes:

- [routes/web.php](routes/web.php)

### Backend Entry

Backend entry:

```text
/backend
```

Includes management modules for users, dictionaries, menus, logs, roles, and system configuration.

### Development Commands

#### Start frontend dev server

```bash
npm run dev
```

#### Build production assets

```bash
npm run build
```

### Validated Status

This has been verified with:

```bash
npm run build
```

Result: build succeeded and generated frontend assets without Vue compilation errors.

### Documentation Index

See the full docs here:

- [docs/README.md](docs/README.md)
- [docs/01-项目概览.md](docs/01-%E9%A1%B9%E7%9B%AE%E6%A6%82%E8%A7%80.md)
- [docs/02-前端页面与交互说明.md](docs/02-%E5%89%8D%E7%AB%AF%E9%A1%B5%E9%9D%A2%E4%B8%8E%E4%BA%A4%E4%BA%92%E8%AF%B4%E6%98%8E.md)
- [docs/03-后端架构与模块说明.md](docs/03-%E5%90%8E%E7%AB%AF%E6%9E%B6%E6%9E%84%E4%B8%8E%E6%A8%A1%E5%9D%97%E8%AF%B4%E6%98%8E.md)
- [docs/04-部署、环境与扩展指南.md](docs/04-%E9%83%A8%E7%BD%B2%E3%80%81%E7%8E%AF%E5%A2%83%E4%B8%8E%E6%89%A9%E5%B1%95%E6%8C%87%E5%8D%97.md)

### Summary

This project is suitable for:

- enterprise website templates
- content management system foundations
- integrated marketing frontend + backend management solutions
- rapid startup projects for secondary development

It can be extended further with article management, category trees, content review, refined permissions, and a more complete operational dashboard.
