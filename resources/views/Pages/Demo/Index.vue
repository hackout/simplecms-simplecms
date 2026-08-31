<template>
    <div class="SimpleCMS-demo-index">
        <VPageHeader title="演示中心" subtitle="后台页面模板组合示例" icon="LayoutDashboard" />

        <VAdminDashboard>
            <template #header>
                <VPagePanel title="演示入口">
                    <div class="SimpleCMS-demo-hero">
                        <div>
                            <h3>后台模板组合演示</h3>
                            <p>这里展示 CRUD / 详情 / 表单 / 看板四种常见后台页面模板的组合方式。</p>
                        </div>
                        <div class="SimpleCMS-demo-actions">
                            <el-button type="primary" @click="goCrud">CRUD 示例</el-button>
                            <el-button @click="goDetail">详情示例</el-button>
                            <el-button @click="goForm">表单示例</el-button>
                            <el-button @click="goDashboard">看板示例</el-button>
                        </div>
                    </div>
                </VPagePanel>
            </template>

            <template #stats>
                <VStatCard label="页面模板" :value="4" meta="CRUD / 详情 / 表单 / 看板" icon="LayoutDashboard" icon-color="#409EFF" />
                <VStatCard label="组件数量" :value="22" meta="已封装通用后台组件" icon="Components" icon-color="#67C23A" />
                <VStatCard label="管理模块" :value="8" meta="覆盖常见后台场景" icon="Folders" icon-color="#E6A23C" />
                <VStatCard label="设计状态" :value="'100%'" meta="适合快速扩展" icon="Check" icon-color="#F56C6C" />
            </template>

            <template #main>
                <VPagePanel title="模板导航">
                    <el-row :gutter="16">
                        <el-col :span="12" v-for="item in demoLinks" :key="item.key">
                            <div class="SimpleCMS-demo-card" @click="goTo(item.route)">
                                <div class="SimpleCMS-demo-card-icon">
                                    <component :is="item.icon" size="20" />
                                </div>
                                <div>
                                    <strong>{{ item.title }}</strong>
                                    <p>{{ item.desc }}</p>
                                </div>
                            </div>
                        </el-col>
                    </el-row>
                </VPagePanel>
            </template>

            <template #side>
                <VPagePanel title="模板说明">
                    <ul class="SimpleCMS-demo-list">
                        <li>CRUD：列表 + 搜索 + 批量操作 + 分页</li>
                        <li>详情：字段摘要 + 关联信息 + 操作栏</li>
                        <li>表单：编辑区 + 校验 + 提交按钮</li>
                        <li>看板：统计卡片 + 主副内容布局</li>
                    </ul>
                </VPagePanel>
            </template>
        </VAdminDashboard>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const demoLinks = computed(() => [
    { key: 'crud', title: 'CRUD 页面', desc: '列表、筛选、分页、操作列', route: '/demo/crud', icon: 'Files' },
    { key: 'detail', title: '详情页面', desc: '基本信息、关联状态、操作详情', route: '/demo/detail', icon: 'ListDetails' },
    { key: 'form', title: '表单页面', desc: '表单分组、校验、保存与取消', route: '/demo/form', icon: 'Form' },
    { key: 'dashboard', title: '看板页面', desc: '数据总览、指标卡片、概览布局', route: '/demo/dashboard', icon: 'LayoutDashboard' }
])

const goCrud = () => window.location.href = '/demo/crud'
const goDetail = () => window.location.href = '/demo/detail'
const goForm = () => window.location.href = '/demo/form'
const goDashboard = () => window.location.href = '/demo/dashboard'
const goTo = (route) => window.location.href = route
</script>

<style lang="scss" scoped>
@import '@scss/demo/crud_example.scss';

.SimpleCMS-demo-index {
    width: 100%;
}

.SimpleCMS-demo-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    min-height: 110px;

    h3 {
        margin: 0 0 6px;
        font-size: 22px;
        color: #1f2937;
    }

    p {
        margin: 0;
        color: #6b7280;
    }
}

.SimpleCMS-demo-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.SimpleCMS-demo-card {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f8fafc;
    border: 1px solid #eef2f7;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 14px;
    cursor: pointer;
    transition: all .2s ease;

    &:hover {
        transform: translateY(-1px);
        border-color: #dfeafc;
        box-shadow: 0 8px 18px rgba(64, 158, 255, 0.08);
    }

    strong {
        display: block;
        margin-bottom: 4px;
        color: #1f2937;
    }

    p {
        margin: 0;
        color: #6b7280;
        font-size: 13px;
    }
}

.SimpleCMS-demo-card-icon {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #eef5ff;
    color: #409eff;
}

.SimpleCMS-demo-list {
    margin: 0;
    padding-left: 18px;
    color: #4b5563;
    line-height: 2;
}
</style>
