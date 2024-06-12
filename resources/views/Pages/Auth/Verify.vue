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
                    <div class="login-card-body" v-if="isValid">
                        <div class="login-card-body-title">
                            <span>验证密保邮箱 ✔ </span>
                            <span>密保邮件：{{ account.email }} </span>
                        </div>
                        <el-form ref="form" style="width: 100%" :rules="rules" :model="form" label-width="auto"
                            label-position="top" size="large">
                            <el-text tag="p" style="margin-bottom: 10px;" size="large">验证密保邮箱成功!</el-text>
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
                    <div class="login-card-body" v-else>
                        <div class="login-card-body-title">
                            <span>验证密保邮箱 ❌ </span>
                        </div>
                        <el-form ref="form" style="width: 100%" label-width="auto" label-position="top" size="large">
                            <el-text tag="p" style="margin-bottom: 10px;" size="large">验证密保邮箱失败!</el-text>
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
        },
        account: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
        }
    },
    computed: {
        isValid() {
            return Object.keys(this.account).length > 0
        }
    },
    methods: {
        closeWin() {
            window.close()
        }
    }

}
</script>
<style lang="scss">
@import '@scss/auth/login.scss';
</style>