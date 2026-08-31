<template>
    <VCrudPage title="用户管理" subtitle="后台管理示例页" icon="User" panel-title="用户列表">
        <template #header-actions>
            <el-button type="primary">新增用户</el-button>
        </template>

        <template #filter-content>
            <VSearchForm :model="searchForm" @submit="onSearch" @reset="onReset">
                <VFormItem label="用户名">
                    <el-input v-model="searchForm.username" placeholder="请输入用户名" clearable />
                </VFormItem>
                <VFormItem label="状态">
                    <el-select v-model="searchForm.status" placeholder="请选择状态" clearable>
                        <el-option label="启用" value="1" />
                        <el-option label="停用" value="0" />
                    </el-select>
                </VFormItem>
                <VFormItem label="角色">
                    <el-select v-model="searchForm.role" placeholder="请选择角色" clearable>
                        <el-option label="管理员" value="admin" />
                        <el-option label="编辑" value="editor" />
                    </el-select>
                </VFormItem>
            </VSearchForm>
        </template>

        <template #filter-actions>
            <el-button>导出</el-button>
            <el-button type="primary">批量操作</el-button>
        </template>

        <template #panel-actions>
            <el-button>同步</el-button>
        </template>

        <VTable :data="tableData" :show-pagination="true" @change="handleTableChange">
            <el-table-column type="selection" width="50" />
            <el-table-column prop="id" label="ID" width="80" />
            <el-table-column prop="username" label="用户名" />
            <el-table-column prop="email" label="邮箱" />
            <el-table-column prop="role" label="角色" />
            <el-table-column prop="status" label="状态">
                <template #default="scope">
                    <el-tag :type="scope.row.status === 1 ? 'success' : 'info'">
                        {{ scope.row.status === 1 ? '启用' : '停用' }}
                    </el-tag>
                </template>
            </el-table-column>
            <el-table-column prop="created_at" label="创建时间" />
            <el-table-column label="操作" width="180" fixed="right">
                <template #default="scope">
                    <el-button size="small" type="primary" link @click="openDetail(scope.row)">查看</el-button>
                    <el-button size="small" type="warning" link @click="openEdit(scope.row)">编辑</el-button>
                    <el-button size="small" type="danger" link @click="removeRow(scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </VTable>
    </VCrudPage>
</template>

<script setup>
import { ref } from 'vue'

const searchForm = ref({
    username: '',
    status: '',
    role: ''
})

const tableData = ref([
    { id: 1, username: 'admin', email: 'admin@example.com', role: '管理员', status: 1, created_at: '2026-01-01 10:00:00' },
    { id: 2, username: 'editor1', email: 'editor1@example.com', role: '编辑', status: 1, created_at: '2026-01-02 10:00:00' },
    { id: 3, username: 'demo', email: 'demo@example.com', role: '编辑', status: 0, created_at: '2026-01-03 10:00:00' },
    { id: 4, username: 'guest', email: 'guest@example.com', role: '访客', status: 0, created_at: '2026-01-04 10:00:00' }
])

const onSearch = (payload) => {
    console.log('search:', payload)
}

const onReset = () => {
    searchForm.value = { username: '', status: '', role: '' }
}

const handleTableChange = (rows) => {
    console.log('table change:', rows)
}

const openDetail = (row) => {
    console.log('detail', row)
}

const openEdit = (row) => {
    console.log('edit', row)
}

const removeRow = (row) => {
    tableData.value = tableData.value.filter(item => item.id !== row.id)
}
</script>

<style lang="scss" scoped>
@import '@scss/system/index.scss';
</style>
