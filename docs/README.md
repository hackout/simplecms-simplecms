# SimpleCMS Documentation Portal

## 中文 / Chinese

本文档集用于说明 SimpleCMS 的整体结构、前端展示能力、后端管理能力和开发部署方式，适合用于项目理解、二次开发与业务扩展。

### 文档目录

- [01-项目概览.md](01-%E9%A1%B9%E7%9B%AE%E6%A6%82%E8%A7%80.md)
- [02-前端页面与交互说明.md](02-%E5%89%8D%E7%AB%AF%E9%A1%B5%E9%9D%A2%E4%B8%8E%E4%BA%A4%E4%BA%92%E8%AF%B4%E6%98%8E.md)
- [03-后端架构与模块说明.md](03-%E5%90%8E%E7%AB%AF%E6%9E%B6%E6%9E%84%E4%B8%8E%E6%A8%A1%E5%9D%97%E8%AF%B4%E6%98%8E.md)
- [04-部署、环境与扩展指南.md](04-%E9%83%A8%E7%BD%B2%E3%80%81%E7%8E%AF%E5%A2%83%E4%B8%8E%E6%89%A9%E5%B1%95%E6%8C%87%E5%8D%97.md)

### 项目定位

SimpleCMS 是一个以 SimpleCMS-Framework 为核心能力层、Laravel 12 为后端基础、Inertia + Vue 3 为前端渲染方案的 CMS 产品化工程。它体现的不是单一的模板演示，而是一个可持续扩展的 SimpleCMS IP：

- 以 SimpleCMS-Framework 统一抽象后台能力、服务方法和模块化结构
- 以 Laravel 12 保障稳定的业务治理、认证、路由和数据层扩展
- 以 Inertia + Vue 3 支撑企业官网、运营后台和内容化页面的前端交互
- 以 SimpleCMS 作为产品名和业务品牌，承载 CMS、官网与运营后台的统一设计

它具备：

- 后台管理与权限系统
- 企业官网展示能力
- 结构化业务页面数据设计
- 扩展性强的控制器、模型、服务和路由层
- 面向中小型企业内容管理场景和数字化平台基础建设

### 当前已实现内容

当前版本已经具备较完整的企业展示型前端 demo，并且已进一步增强为一套具备内容运营闭环的 SimpleCMS 产品能力：

- 首页
- 关于页
- 服务页
- 方案页
- 产品页
- 案例页
- 新闻页
- 联系页
- 内容后台列表页
- 内容审核队列页
- 文章编辑 / 审核 / 发布工作流
- 角色权限细分：编辑、审核、发布分离
- 中英文文档结构与扩展说明

并且已经接通到 Laravel 路由与 Inertia 页面渲染体系，能够作为正式企业站点、CMS 和运营后台基础继续扩展。

### 关键目录

- [app](../app)
- [app/Http/Controllers/Frontend](../app/Http/Controllers/Frontend)
- [resources/views/Pages](../resources/views/Pages)
- [routes](../routes)
- [config](../config)
- [database](../database)
- [public](../public)
- [composer.json](../composer.json)
- [package.json](../package.json)

### 阅读建议

建议按以下顺序阅读：

1. 先看项目概览，理解定位与结构
2. 再看前端页面说明，理解页面组织与数据流
3. 再看后端架构，理解控制器、模型和权限设计
4. 最后参考部署指南，准备开发/部署环境

### 说明

本项目当前已达到“可展示、可扩展、可继续开发”的基础状态，可直接用于：

- 企业官网建设
- 品牌站点展示
- 轻型 CMS
- 内部管理后台基础模板
- SaaS 前台 + 后台一体化项目的快速启动

---

## English / 英文

This documentation set explains the overall architecture, frontend capabilities, backend modules, and deployment approach of SimpleCMS. It is intended for project understanding, secondary development, and business extension.

### Document Index

- [01-项目概览.md](01-%E9%A1%B9%E7%9B%AE%E6%A6%82%E8%A7%80.md)
- [02-前端页面与交互说明.md](02-%E5%89%8D%E7%AB%AF%E9%A1%B5%E9%9D%A2%E4%B8%8E%E4%BA%A4%E4%BA%92%E8%AF%B4%E6%98%8E.md)
- [03-后端架构与模块说明.md](03-%E5%90%8E%E7%AB%AF%E6%9E%B6%E6%9E%84%E4%B8%8E%E6%A8%A1%E5%9D%97%E8%AF%B4%E6%98%8E.md)
- [04-部署、环境与扩展指南.md](docs/04-%E9%83%A8%E7%BD%B2%E3%80%81%E7%8E%AF%E5%A2%83%E4%B8%8E%E6%89%A9%E5%B1%95%E6%8C%87%E5%8D%97.md)

### Project Positioning

SimpleCMS is a productized CMS project built around the SimpleCMS-Framework, with Laravel 12 as the backend foundation and Inertia + Vue 3 as the frontend rendering solution. It is not only a template demonstration, but a sustainable and extendable SimpleCMS IP that combines content operations, enterprise presentation, and management workflows.

- SimpleCMS-Framework abstracts backend capabilities, service methods, and modular structure
- Laravel 12 ensures stable business governance, authentication, routing, and data-layer extension
- Inertia + Vue 3 powers frontend interaction for corporate sites, operational dashboards, and content-driven pages
- SimpleCMS as a product and brand unifies CMS, website, and backend management under one design system

It includes:

- backend management and permission system
- enterprise website presentation capability
- structured business page data design
- highly extensible controllers, models, services, and routes
- support for small and medium enterprise content management scenarios and digital platform foundation building

### Current Implementations

The current version already includes a fairly complete enterprise display frontend demo with pages such as:

- Home
- About
- Services
- Solutions
- Products
- Cases
- News
- Contact

It is already integrated into the Laravel routing and Inertia rendering system and can continue to evolve into a formal corporate website or template base.

### Key Directories

- [app](../app)
- [app/Http/Controllers/Frontend](../app/Http/Controllers/Frontend)
- [resources/views/Pages](../resources/views/Pages)
- [routes](../routes)
- [config](../config)
- [database](../database)
- [public](../public)
- [composer.json](../composer.json)
- [package.json](../package.json)

### Reading Guide

Recommended reading order:

1. Start with the project overview to understand positioning and structure
2. Review the frontend page guide to understand page organization and data flow
3. Review the backend architecture to understand controllers, models, and permission design
4. Refer to the deployment guide to prepare the development and deployment environment

### Notes

The project has reached a state that is displayable, extensible, and ready for ongoing development. It can be used for:

- enterprise website construction
- brand site presentation
- lightweight CMS
- internal admin template foundations
- rapid startup of SaaS frontend + backend integrated projects
