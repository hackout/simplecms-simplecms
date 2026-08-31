<template>
    <VDetailPage title="用户详情" subtitle="查看用户资料与状态" icon="User">
        <template #header-actions>
            <el-button type="primary">编辑用户</el-button>
            <el-button>返回列表</el-button>
        </template>

        <template #overview>
            <VDescriptionList :items="detailItems" />
        </template>

        <template #overview-actions>
            <el-tag type="success">已启用</el-tag>
        </template>

        <VPagePanel title="账户信息">
            <el-descriptions :column="3" border>
                <el-descriptions-item label="用户名">admin</el-descriptions-item>
                <el-descriptions-item label="邮箱">admin@example.com</el-descriptions-item>
                <el-descriptions-item label="角色">管理员</el-descriptions-item>
                <el-descriptions-item label="手机号">13800000000</el-descriptions-item>
                <el-descriptions-item label="当前状态">启用</el-descriptions-item>
                <el-descriptions-item label="最近登录">2026-08-31 12:20:00</el-descriptions-item>
            </el-descriptions>
        </VPagePanel>

        <VPagePanel title="关联信息">
            <el-row :gutter="16">
                <el-col :span="12">
                    <div class="SimpleCMS-demo-info-block">
                        <h4>所属部门</h4>
                        <p>运营中心 / 产品部</p>
                    </div>
                </el-col>
                <el-col :span="12">
                    <div class="SimpleCMS-demo-info-block">
                        <h4>权限范围</h4>
                        <p>用户管理、系统配置、内容审核</p>
                    </div>
                </el-col>
            </el-row>
        </VPagePanel>
    </VDetailPage>
</template>

<script setup>
const detailItems = [
    { label: '用户名', value: 'admin' },
    { label: '昵称', value: '系统管理员' },
    { label: '邮箱', value: 'admin@example.com' },
    { label: '角色', value: '管理员' },
    { label: '状态', value: '正常' },
    { label: '创建时间', value: '2026-01-01 10:00:00' }
]
</script>

<style lang="scss" scoped>
@import '@scss/demo/crud_example.scss';

.SimpleCMS-demo-info-block {
    padding: 18px;
    border: 1px solid #eef2f7;
    border-radius: 12px;
    background: #f9fafb;

    h4 {
        margin: 0 0 6px;
        color: #303133;
    }

    p {
        margin: 0;
        color: #606266;
    }
}
</style>
