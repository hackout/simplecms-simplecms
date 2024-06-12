<template>
    <EmptyLayout>
        <div class="login">
            <div class="login-block">
                <div class="login-top">
                    <svg width="239" height="234" viewBox="0 0 239 234" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="88.5605" y="0.700195" width="149" height="149" rx="19.5" stroke="currentColor"
                            stroke-opacity="0.16" />
                        <rect x="0.621094" y="33.761" width="200" height="200" rx="10" fill="currentColor"
                            fill-opacity="0.08" />
                    </svg>
                </div>
                <div class="login-bottom">
                    <svg width="238" height="238" viewBox="0 0 181 181" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1.30469" y="1.44312" width="178" height="178" rx="19" stroke="currentColor"
                            stroke-opacity="0.16" stroke-width="2" stroke-dasharray="8 8" />
                        <rect x="22.8047" y="22.9431" width="135" height="135" rx="10" fill="currentColor"
                            fill-opacity="0.08" />
                    </svg>
                </div>
                <el-card class="login-card">
                    <div class="login-card-title">
                        <img src="/assets/logo_load.png" />
                        <span>SimpleCMS</span>
                    </div>
                    <div class="login-card-body">
                        <div class="login-card-body-title">
                            <span>欢迎使用 SimpleCMS 👋🏻 </span>
                            <span> 请登录账户开始体验 </span>
                        </div>
                        <el-form ref="form" style="width: 100%" :rules="rules" :model="form" label-width="auto"
                            label-position="top" size="large" @submit.native.prevent="onLogin">
                            <el-form-item label="登录账号" prop="account">
                                <el-input v-model="form.account" placeholder="请输入登录账号" clearable autocomplete="off" />
                            </el-form-item>
                            <el-form-item label="登录密码" prop="password">
                                <el-input type="password" v-model="form.password" placeholder="请输入登录密码" clearable autocomplete="off" />
                            </el-form-item>
                            <el-form-item v-if="captcha_disabled"
                                :rules="[{ required: true, message: '请输入验证码', trigger: 'blur' }]" label="验证码" prop="code">
                                <el-input v-model="form.code" placeholder="请输入验证码">
                                    <template #suffix>
                                        <img @click="refreshCaptcha" :src="captchaUrl" alt="">
                                    </template>
                                </el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-checkbox :checked="form.remember != 0"
                                    @change="form.remember = !form.remember">记住我</el-checkbox>
                                <Link :href="$route('backend.forget')">忘记密码?</Link>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" v-loading="loading" class="fullWidth" @click="onLogin">登录</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                </el-card>
            </div>
        </div>
    </EmptyLayout>
</template>
<script>
export default {
    props: {
        captcha_disabled: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            form: {
                account: '',
                password: '',
                remember: 0,
                code: ''
            },
            captchaUrl: '/captcha',
            rules: {
                account: [
                    { required: true, message: '请输入登录账号', trigger: 'blur' }
                ],
                password: [
                    { required: true, message: '请输入登录密码', trigger: 'blur' },
                ]
            },
            loading: false
        }
    },
    methods: {
        onLogin() {
            if(!this.loading)
            {
                this.loading = true
                this.$ajax.post(this.$route('backend.login.auth'),this.form,{
                    forceFormData: true,
                    onFinish: ()=>{
                        this.loading = false
                    },
                    onError: ()=>{
                        this.refreshCaptcha()
                    }
                })
            }
        },
        refreshCaptcha() {
            this.captchaUrl = '/captcha?_t=' + (new Date()).getTime()
        }
    }

}
</script>
<style lang="scss">
@import '@scss/auth/login.scss';
</style>