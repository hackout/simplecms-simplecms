<template>
    <DefaultLayout>
        <div class="SimpleCMS-user">
            <div class="SimpleCMS-user-box">
                <VTable action="backend.user.list" :params="queryParam" @search="searchData" ref="tableRef">
                    <template #header_left>
                        <el-form-item v-if="default_password">
                            <el-alert type="success" :closable="false" size="small"
                                :title="`默认密码:${default_password}`"></el-alert>
                        </el-form-item>
                    </template>
                    <template #header_right>
                        <el-form-item>
                            <el-select placeholder="会员组" v-model="queryParam.group_id" @change="searchData" clearable
                                style="width:120px;">
                                <el-option v-for="(group, index) in user_groups" :key="index" :label="group.name"
                                    :value="group.value"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item>
                            <el-input v-model="queryParam.keyword" clearable @clear="searchData"
                                placeholder="关键词"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" native-type="submit">查询</el-button>
                        </el-form-item>
                    </template>
                    <el-table-column label="序号" width="70px" prop="name" align="center">
                        <template #default="scope">
                            <span>{{ scope.$index + 1 }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="昵称" width="200px" prop="name">
                        <template #default="scope">
                            <div class="SimpleCMS-user-userInfo">
                                <div class="SimpleCMS-user-userInfo-avatar">
                                    <el-avatar :src="scope.row.avatar">{{ scope.row.nickname }}</el-avatar>
                                </div>
                                <div class="SimpleCMS-user-userInfo-content">
                                    <span>昵称:{{ scope.row.nickname }}</span><br />
                                    <span>姓名:{{ scope.row.name }}</span><br />
                                    <span>UID:{{ scope.row.uid }}</span>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column label="账号" min-width="200px" prop="account">
                        <template #default="scope">
                            <div class="SimpleCMS-user-account">
                                <span>登录账号:{{ scope.row.account }}</span><br />
                                <span>手机号码:{{ scope.row.mobile }}</span><br />
                                <span>EMAIL:{{ scope.row.email }}</span>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column label="会员组" width="200px" prop="group">
                        <template #default="scope">
                            <el-tag size="small" style="margin-bottom:3px;margin-left:3px;" effect="dark"
                                v-for="(g, i) in scope.row.groups" :key="i">{{ g.name }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="状态" prop="is_valid" align="center">
                        <template #default="scope">
                            <el-tag type="primary" :class="{ 'el-tag--grey': !scope.row.is_valid }" effect="dark">{{
                                scope.row.is_valid ? '启用' :
                                    '禁用' }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="最后登录" width="175px" prop="last_login" align="center">
                        <template #default="scope">
                            <el-tooltip effect="dark"
                                :content="`登录IP:${scope.row.last_ip}<br />最后登录:${$tool.dateFormat(scope.row.last_login)}<br />创建时间:${$tool.dateFormat(scope.row.created_at)}`"
                                raw-content placement="top">
                                <span>{{ $tool.dateFormat(scope.row.last_login) }}</span>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                    <el-table-column label="注册时间" width="175px" prop="created_at" align="center">
                        <template #default="scope">
                            <el-tooltip effect="dark"
                                :content="`登录IP:${scope.row.register_ip}<br />设备指纹:${scope.row.register_finger}<br />注册时间:${$tool.dateFormat(scope.row.created_at)}`"
                                raw-content placement="top">
                                <span>{{ $tool.dateFormat(scope.row.created_at) }}</span>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作" fixed="right" width="135" align="right">
                        <template #default="scope">

                            <el-button title="查看用户信息" @click="$goTo('backend.user.detail', { id: scope.row.id })" circle
                                class="el-button--dark">
                                <SimpleCMSIconEye size="16px"></SimpleCMSIconEye>
                            </el-button>
                            <v-dialog-form header="修改会员密码"
                                :action="$route('backend.user.password', { id: scope.row.id })" method="put"
                                :options="formItem()" @saved="refreshData()">
                                <el-button title="修改密码" circle class="el-button--dark">
                                    <SimpleCMSIconKey size="16px"></SimpleCMSIconKey>
                                </el-button>
                            </v-dialog-form>
                            <v-dialog header="系统提示" v-if="!scope.row.is_super" :name="`removeDialogRef${scope.row.id}`"
                                :ref="`removeDialogRef${scope.row.id}`" content="确定删除此会员？" type="confirm"
                                @confirm="deleteItem(scope.row, `removeDialogRef${scope.row.id}`)">
                                <template #button>
                                    <el-button circle class="el-button--dark">
                                        <SimpleCMSIconTrash size="16px"></SimpleCMSIconTrash>
                                    </el-button>
                                </template>
                            </v-dialog>
                        </template>
                    </el-table-column>
                </VTable>
            </div>
        </div>
    </DefaultLayout>
</template>
<script>
export default {
    components: {
    },
    props: {
        query: {
            type: Object,
            default: {}
        },
        userGroup: {
            type: Array,
            default: []
        },
        defaultPassword: {
            type: String,
            default: null
        }
    },
    data() {
        return {
            queryParam: this.query,
            user_groups: this.userGroup,
            default_password: this.defaultPassword
        }
    },
    created() {
        this.$nextTick(() => {
            this.user_groups = this.$page.props.userGroup
            this.default_password = this.$page.props.defaultPassword
        })
    },
    methods: {
        formItem() {
            let result = [
                {
                    name: '登录密码',
                    type: 'password',
                    key: 'password',
                    rules: [
                        { required: true, message: '登录密码不能为空', trigger: 'blur' },
                    ]
                },
                {
                    name: '重复密码',
                    type: 'password',
                    key: 'password_confirmation',
                    rules: [
                        { required: true, message: '重复密码不能为空', trigger: 'blur' },
                    ]
                },
            ]
            return result;
        },
        searchData() {
            this.queryParam.page = 1;
            this.refreshData();
        },
        refreshData() {
            this.$nextTick(() => {
                this.$refs.tableRef.refreshData()
            })
        },
        async deleteItem(item, refName) {
            let res = await this.$axios.delete(this.$route('backend.user.delete', { id: item.id }))
            if (res.code == this.$config.successCode) {
                this.$message.success("删除会员信息成功");
                this.$closeDialog(refName)
                this.refreshData()
            } else {
                this.$message.error(res.message)
            }
        }
    }
}
</script>
<style lang="scss" scoped>
@import '@scss/user/index.scss';
</style>