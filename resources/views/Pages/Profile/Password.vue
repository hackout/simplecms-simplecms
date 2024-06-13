<template>
    <DefaultLayout>
        <div class="SimpleCMS-profile">
            <div class="SimpleCMS-profile-tab">
                <Link :href="$route('backend.dashboard.profile')" class="SimpleCMS-profile-tab-item">
                    <SimpleCMSIconUserScan size="24px"></SimpleCMSIconUserScan>
                    <span>个人资料</span>
                </Link>
                <div class="SimpleCMS-profile-tab-item active">
                <SimpleCMSIconBrandSamsungpass size="24px"></SimpleCMSIconBrandSamsungpass>
                <span>密码安全</span>
                </div>
                <Link :href="$route('backend.dashboard.profile.email')" class="SimpleCMS-profile-tab-item">
                <SimpleCMSIconAt size="24px"></SimpleCMSIconAt>
                <span>密保邮箱</span>
                </Link>
            </div>
            <div class="SimpleCMS-profile-box">
                <el-card>
                    <el-form size="large" label-position="top" :rules="rules" :model="form"
                        @submit.native.prevent="onSubmit">
                        <el-form-item label="当前登录密码" prop="current_password">
                            <el-input type="password" v-model="form.current_password" placeholder="当前登录密码"
                                autocomplete="off" />
                        </el-form-item>
                        <el-form-item label="新的登录密码" prop="password">
                            <el-input type="password" v-model="form.password" placeholder="新的登录密码" autocomplete="off" />
                        </el-form-item>
                        <el-form-item label="重复新的密码" prop="password_confirmation">
                            <el-input type="password" v-model="form.password_confirmation" placeholder="重复新的密码"
                                autocomplete="off" />
                        </el-form-item>
                        <el-divider></el-divider>
                        <el-form-item>
                            <el-button type="primary" @click="onSubmit">保存更改</el-button>
                            <el-button>重置</el-button>
                        </el-form-item>
                    </el-form>
                </el-card>
            </div>
        </div>
    </DefaultLayout>
</template>
<script>
export default {
    props: {
        manager: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            rules: {
                current_password: [
                    { required: true, message: '请输入当前登录密码', trigger: 'blur' }
                ],
                password: [
                    { required: true, message: '请输入新的登录密码', trigger: 'blur' },
                    { validator: this.$validation.password }
                ],
                password_confirmation: [
                    { required: true, message: '请输入重复新的密码', trigger: 'blur' },
                    { validator: this.$validation.password },
                    { validator: (rule,value,callback) => {
                        if(this.form.password != value)
                        {
                            callback(new Error('两次输入的密码不相符'))
                        }else{
                            callback()
                        }
                    }}
                ]
            },
            form: {
                current_password: '',
                password: '',
                password_confirmation: ''
            }
        }
    },
    methods: {
        onSubmit() {
            if (!this.loading) {
                this.loading = true
                this.$ajax.post(this.$route('backend.dashboard.profile.password_update'), this.form, {
                    forceFormData: true,
                    onFinish: () => {
                        this.loading = false
                    },
                    onSuccess: () => {
                        this.form = {
                            current_password: '',
                            password: '',
                            password_confirmation: ''
                        }
                    }
                })
            }
        }
    }
}
</script>
<style lang="scss">
@import '@scss/profile/index.scss';
</style>