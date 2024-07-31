<template>
    <div class="SimpleCMS-header">
        <div class="SimpleCMS-header-box">
            <div class="SimpleCMS-header-box-search">
                <el-button circle size="large">
                    <SimpleCMSIconSearch size="16px"></SimpleCMSIconSearch>
                </el-button>
                <div class="SimpleCMS-header-box-search-text">
                    <span>搜索</span>
                </div>
                <div class="SimpleCMS-header-box-search-tip">
                    <span>Ctrl + K</span>
                </div>
            </div>
            <div class="SimpleCMS-header-box-navbar">
                <span>{{ $tool.dateFormat(current_time, '⏲ YYYY-MM-DD HH:mm:ss') }}</span>
                <el-popover placement="bottom-end" :width="300">
                    <div class="profile">
                        <div class="profile-user">
                            <el-avatar size="large" :src="userInfo.avatar ? userInfo.avatar : '/assets/logo.png'" />
                            <div class="profile-user-text">
                                <span v-if="userInfo.name && userInfo.name.length > 0">{{ userInfo.name }}</span>
                                <span v-else>{{ userInfo.account }}</span>
                                <span v-if="userInfo.is_super">超级管理员</span>
                                <span v-else>管理员</span>
                            </div>
                        </div>
                        <div class="profile-list">
                            <div class="profile-list-item">
                                <Link :href="$route('backend.dashboard.profile')">
                                <SimpleCMSIconUserScan size="24px"></SimpleCMSIconUserScan>
                                <span>个人资料</span>
                                </Link>
                            </div>
                            <div class="profile-list-item">
                                <Link :href="$route('backend.dashboard.profile.password')">
                                <SimpleCMSIconBrandSamsungpass size="24px"></SimpleCMSIconBrandSamsungpass>
                                <span>密码安全</span>
                                </Link>
                            </div>
                            <div class="profile-list-item">
                                <Link :href="$route('backend.dashboard.profile.email')">
                                <SimpleCMSIconAt size="24px"></SimpleCMSIconAt>
                                <span>密保邮箱</span>
                                </Link>
                            </div>
                        </div>
                        <div class="profile-sign-out">
                            <Link :href="$route('backend.logout')" method="POST" as="button">
                            <SimpleCMSIconLogout2 size="24px"></SimpleCMSIconLogout2>
                            <span>退出登录</span>
                            </Link>
                        </div>
                    </div>
                    <template #reference>
                        <el-button circle size="large">
                            <el-avatar :src="manager.avatar ? manager.avatar : '/assets/logo.png'" />
                        </el-button>
                    </template>
                </el-popover>

            </div>
        </div>
    </div>
</template>
<script>
let timer
export default {
    props: {
        manager: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            userInfo: this.$page.props.manager,
            current_time: (new Date).getTime()
        }
    },
    watch: {
        '$page.props.manager': {
            handler(val) {
                this.userInfo = val
            },
            deep: true
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.getDateTime()
        })
    },
    methods: {
        getDateTime() {
            this.current_time = (new Date).getTime()
            timer = setInterval(() => {
                this.current_time = (new Date).getTime()
            }, 1000)
        }
    },
    beforeDestroy() {
        if (timer) {
            clearInterval(timer);
        }
    }
}
</script>
<style lang="scss">
@import '@scss/addons/header.scss';
</style>