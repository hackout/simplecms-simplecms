<template>
    <DefaultLayout>
        <div class="SimpleCMS-userDetail">
            <el-tabs v-model="tab">
                <el-tab-pane name="basic">
                    <template #label>
                        <SimpleCMSIconBackground size="24px"></SimpleCMSIconBackground>
                        <span>基础信息</span>
                    </template>
                    <UserBasic :item="itemInfo"></UserBasic>
                </el-tab-pane>
                <el-tab-pane name="detail">
                    <template #label>
                        <SimpleCMSIconId size="24px"></SimpleCMSIconId>
                        <span>详细资料</span>
                    </template>
                    <UserDetail :item="itemInfo"></UserDetail>
                </el-tab-pane>
                <el-tab-pane name="account">
                    <template #label>
                        <SimpleCMSIconUserCheck size="24px"></SimpleCMSIconUserCheck>
                        <span>账号管理</span>
                    </template>
                    <UserAccount :item="itemInfo"></UserAccount>
                </el-tab-pane>
                <el-tab-pane name="password">
                    <template #label>
                        <SimpleCMSIconKey size="24px"></SimpleCMSIconKey>
                        <span>密码安全</span>
                    </template>
                    <UserPassword :item="itemInfo"></UserPassword>
                </el-tab-pane>
                <el-tab-pane name="log">
                    <template #label>
                        <SimpleCMSIconLogs size="24px"></SimpleCMSIconLogs>
                        <span>请求日志</span>
                    </template>
                    <UserLog :item="itemInfo"></UserLog>
                </el-tab-pane>
            </el-tabs>
        </div>
    </DefaultLayout>
</template>
<script>
import UserBasic from './Addons/UserBasic.vue';
import UserDetail from './Addons/UserDetail.vue';
import UserAccount from './Addons/UserAccount.vue';
import UserPassword from './Addons/UserPassword.vue';
import UserLog from './Addons/UserLog.vue';
export default {
    components: {
        UserBasic,
        UserDetail,
        UserAccount,
        UserPassword,
        UserLog
    },
    props: {
        item: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            itemInfo: this.item,
            tab: 'basic'
        }
    },
    created() {
        this.$nextTick(() => {
            this.itemInfo = this.$page.props.item
        })
    },
    methods: {

    }
}
</script>
<style lang="scss" scoped>
@import '@scss/user/detail.scss';
</style>