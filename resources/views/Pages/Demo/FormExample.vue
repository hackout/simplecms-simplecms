<template>
    <VFormPage title="编辑用户" subtitle="维护用户基本信息" icon="User">
        <template #header-actions>
            <el-button>取消</el-button>
            <el-button type="primary">保存</el-button>
        </template>

        <el-form :model="form" label-width="120px" style="max-width: 960px;">
            <el-row :gutter="20">
                <el-col :span="12">
                    <VFormItem label="用户名" prop="username" :required="true">
                        <el-input v-model="form.username" placeholder="请输入用户名" />
                    </VFormItem>
                </el-col>
                <el-col :span="12">
                    <VFormItem label="邮箱" prop="email" :required="true">
                        <el-input v-model="form.email" placeholder="请输入邮箱" />
                    </VFormItem>
                </el-col>
                <el-col :span="12">
                    <VFormItem label="手机号" prop="phone">
                        <el-input v-model="form.phone" placeholder="请输入手机号" />
                    </VFormItem>
                </el-col>
                <el-col :span="12">
                    <VFormItem label="角色" prop="role">
                        <el-select v-model="form.role" placeholder="请选择角色" style="width:100%">
                            <el-option label="管理员" value="admin" />
                            <el-option label="编辑" value="editor" />
                            <el-option label="访客" value="guest" />
                        </el-select>
                    </VFormItem>
                </el-col>
                <el-col :span="24">
                    <VFormItem label="备注" prop="remark">
                        <el-input v-model="form.remark" type="textarea" :rows="4" placeholder="请输入备注信息" />
                    </VFormItem>
                </el-col>
            </el-row>
        </el-form>

        <template #footer>
            <el-button>取消</el-button>
            <el-button type="primary">保存修改</el-button>
        </template>
    </VFormPage>
</template>

<script setup>
import { ref } from 'vue'

const form = ref({
    username: 'admin',
    email: 'admin@example.com',
    phone: '13800000000',
    role: 'admin',
    remark: '系统管理员，拥有全部后台权限。'
})
</script>

<style lang="scss" scoped>
@import '@scss/demo/crud_example.scss';
</style>
