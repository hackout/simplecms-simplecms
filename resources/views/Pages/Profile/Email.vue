<template>
    <DefaultLayout :breadcrumb="false">
        <div class="SimpleCMS-profile">
            <div class="SimpleCMS-profile-tab">
                <Link :href="$route('backend.dashboard.profile')" class="SimpleCMS-profile-tab-item">
                    <SimpleCMSIconUserScan size="24px"></SimpleCMSIconUserScan>
                    <span>个人资料</span>
                </Link>
                <Link :href="$route('backend.dashboard.profile.password')" class="SimpleCMS-profile-tab-item">
                <SimpleCMSIconBrandSamsungpass size="24px"></SimpleCMSIconBrandSamsungpass>
                <span>密码安全</span>
                </Link>
                <div class="SimpleCMS-profile-tab-item active">
                <SimpleCMSIconAt size="24px"></SimpleCMSIconAt>
                <span>密保邮箱</span>
                </div>
            </div>
            <div class="SimpleCMS-profile-box">
                <el-card>
                    <el-form size="large" label-position="top" :rules="rules" :model="form"
                        @submit.native.prevent="onSubmit">
                        <el-form-item label="密保邮箱" prop="email">
                            <el-input type="email" v-model="form.email" placeholder="密保邮箱" />
                        </el-form-item>
                        <el-divider content-position="left">校验密码</el-divider>
                        <el-form-item label="登录密码" prop="password">
                            <el-input type="password" v-model="form.password" placeholder="登录密码" autocomplete="off" />
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
                password: [
                    { required: true, message: '请输入登录密码', trigger: 'blur' }
                ],
                email: [
                    { required: true, message: '请输入密保邮箱', trigger: 'blur' }
                ]
            },
            form: {
                email: this.manager.email,
                password: ''
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