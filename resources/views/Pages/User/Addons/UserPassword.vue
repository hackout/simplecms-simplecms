<template>

    <el-form size="large" label-position="top" ref="formRef" :rules="rules" :model="form"
        @submit.native.prevent="onSubmit">
        <el-form-item label="新的登录密码" prop="password">
            <el-input type="password" v-model="form.password" placeholder="新的登录密码" autocomplete="off" />
        </el-form-item>
        <el-form-item label="重复新的密码" prop="password_confirmation">
            <el-input type="password" v-model="form.password_confirmation" placeholder="重复新的密码" autocomplete="off" />
        </el-form-item>
        <el-divider></el-divider>
        <el-form-item>
            <el-button type="primary" @click="onSubmit">保存更改</el-button>
            <el-button>重置</el-button>
        </el-form-item>
    </el-form>
</template>
<script>
export default {
    props: {
        item: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            loading: false,
            form: {
                password: '',
                password_confirmation: ''
            },
            rules: {
                password: [
                    { required: true, message: '新的登录密码不能为空', trigger: 'blur' },
                    { min: 6, max: 30, message: '新的登录密码仅支持6-30位字符串' }
                ],
                password_confirmation: [
                    { required: true, message: '重复新的密码不能为空', trigger: 'blur' },
                    { min: 6, max: 30, message: '重复新的密码仅支持6-30位字符串' },
                    {
                        validator: (rules, value, callback) => {
                            if (value != '' && value != this.form.password) {
                                return callback(new Error('两次输入的密码不相同'))
                            } else {
                                return callback()
                            }
                        }
                    }
                ],
            }
        }
    },
    methods: {
        onSubmit() {
            if (!this.loading) {
                this.loading = true
                this.$refs.formRef.validate().then(async () => {
                    let res = await this.$axios.post(this.$route('backend.user.password', { id: this.item.id }))
                    this.loading = false
                    if (res.code == this.$config.successCode) {
                        this.$message.success('修改用户密码成功')
                    } else {
                        this.$message.error(res.message)
                    }
                }).catch(() => {
                    this.loading = false
                })
            }
        }
    }
}
</script>
<style lang="scss" scoped></style>