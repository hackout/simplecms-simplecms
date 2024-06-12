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
                    <div class="login-card-body" v-if="!hasSuccess">
                        <div class="login-card-body-title">
                            <span>忘记密码？ 🔒  </span>
                            <span>请输入您的安全密保邮件地址，我们将向您发送带有重置密码链接的邮件 </span>
                        </div>
                        <el-form ref="form" style="width: 100%" :rules="rules" :model="form" label-width="auto"
                            label-position="top" size="large" @submit.native.prevent="onSubmit">
                            <el-form-item label="邮箱地址" prop="email">
                                <el-input v-model="form.email" placeholder="请输入邮箱地址" clearable autocomplete="off" />
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
                                <el-button type="primary" v-loading="loading" class="fullWidth" @click="onSubmit">发送链接</el-button>
                            </el-form-item>
                            <el-form-item>
                                <Link :href="$route('backend.login')" class="link">
                                    <SimpleCMSIconChevronLeft size="18px"></SimpleCMSIconChevronLeft>
                                    <span>返回登录页</span>
                                </Link>
                            </el-form-item>
                        </el-form>
                    </div>
                    <div class="login-card-body" v-else>
                        <div class="login-card-body-title">
                            <span>电子邮件验证 ✉️  </span>
                        </div>
                        <el-form ref="form" style="width: 100%" label-width="auto"
                            label-position="top" size="large">
                            <el-text tag="p" style="margin-bottom: 10px;" size="large">重置密码链接已发送到您的电子邮件地址：</el-text>
                            <el-text tag="p" style="margin-bottom: 10px;" size="large">{{form.email}}，请点击邮件中的链接重置密码。</el-text>
                            <el-form-item>
                                <el-button type="primary" class="fullWidth" @click="closeWin">关闭页面</el-button>
                            </el-form-item>
                            <el-form-item>
                                <Link :href="$route('backend.login')" class="link">
                                    <SimpleCMSIconChevronLeft size="18px"></SimpleCMSIconChevronLeft>
                                    <span>返回登录页</span>
                                </Link>
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
                email: '',
                code: ''
            },
            captchaUrl: '/captcha',
            rules: {
                email: [
                    { required: true, message: '请输入邮箱地址', trigger: 'blur' }
                ]
            },
            loading: false,
            hasSuccess: false
        }
    },
    methods: {
        closeWin(){
            window.close()
        },
        onSubmit() {
            if(!this.loading)
            {
                this.loading = true
                this.$ajax.post(this.$route('backend.forget.email'),this.form,{
                    forceFormData: true,
                    onFinish: ()=>{
                        this.loading = false
                    },
                    onSuccess: ()=>{
                        this.hasSuccess = true
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