<template>
    <DefaultLayout>
        <div class="SimpleCMS-manager">
            <div class="SimpleCMS-manager-box">
                <VTable action="backend.manager_list" :params="queryParam" @search="searchData" ref="tableRef">
                    <template #header_left>
                        <el-form-item>
                            <v-dialog-form button="添加管理员" header="新增管理员" :action="$route('backend.manager_create')"
                                method="post" :options="formItem('create')" @saved="refreshData()"></v-dialog-form>
                        </el-form-item>
                    </template>
                    <template #header_right>
                        <el-form-item>
                            <el-input v-model="queryParam.keyword" clearable @clear="searchData"
                                placeholder="关键词"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" native-type="submit">查询</el-button>
                        </el-form-item>
                    </template>
                    <el-table-column label="序号" width="70px" prop="name">
                        <template #default="scope">
                            <span>{{ scope.$index + 1 }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="姓名" width="200px" prop="name"></el-table-column>
                    <el-table-column label="账号" width="200px" prop="account">
                        <template #default="scope">
                            <span>{{ scope.row.account }}</span>
                            <el-tag type="danger" size="small" style="margin-left:3px;" effect="dark"
                                v-if="scope.row.is_super">超</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="邮箱" prop="email">
                        <template #default="scope">
                            <el-tooltip effect="dark" :content="`校验时间:${$tool.dateFormat(scope.row.email_verified_at)}`"
                                placement="top">
                                <span>{{ scope.row.email }}</span>
                                <el-tag type="success" size="small" style="margin-left:3px;"
                                    v-if="scope.row.email_verified_at">验</el-tag>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                    <el-table-column label="状态" prop="is_valid">
                        <template #default="scope">
                            <el-tag type="primary" :class="{ 'el-tag--grey': !scope.row.is_valid }" effect="dark">{{
                                scope.row.is_valid ? '启用' :
                                '禁用' }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="最后登录" prop="last_login">
                        <template #default="scope">
                            <el-tooltip effect="dark"
                                :content="`登录IP:${scope.row.last_ip}<br />最后登录:${$tool.dateFormat(scope.row.last_login)}<br />创建时间:${$tool.dateFormat(scope.row.created_at)}`"
                                raw-content placement="top">
                                <span>{{ $tool.dateFormat(scope.row.last_login) }}</span>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作" fixed="right" width="135">
                        <template #default="scope">
                            <v-dialog-form header="修改管理员信息"
                                :action="$route('backend.manager_update', { id: scope.row.id })" method="put"
                                :options="formItem('update', scope.row)" @saved="refreshData()">
                                <el-button title="编辑资料" circle class="el-button--dark">
                                    <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                                </el-button>
                            </v-dialog-form>
                            <v-dialog-form header="修改管理员密码"
                                :action="$route('backend.manager_password', { id: scope.row.id })" method="post"
                                :options="formItem('password', scope.row)" @saved="refreshData()">
                                <el-button title="修改密码" circle class="el-button--dark">
                                    <SimpleCMSIconKey size="16px"></SimpleCMSIconKey>
                                </el-button>
                            </v-dialog-form>
                            <v-dialog header="系统提示" v-if="!scope.row.is_super" :name="`removeDialogRef${scope.row.id}`"
                                :ref="`removeDialogRef${scope.row.id}`" content="确定删除此管理员？" type="confirm"
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
    props: {
        query: {
            type: Object,
            default: {}
        },
        roles: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            queryParam: this.query,
            drawerVisit: false
        }
    },
    methods: {
        formItem(mode, item) {
            let result = []
            if (mode == 'create' || mode == 'update') {
                result.push({
                    name: '姓名',
                    key: 'name',
                    placeholder: '请输入姓名',
                    rules: [
                        { min: 2, max: 50, message: '姓名仅支持2-50个字符' },
                    ],
                    clearable: true,
                    maxlength: 50,
                    value: mode == 'update' && item ? item.name : ''
                },
                {
                    name: '登录账号',
                    key: 'account',
                    placeholder: '请输入登录账号',
                    rules: [
                        { required: true, message: '登录账号不能为空', trigger: 'blur' }
                    ],
                    clearable: true,
                    value: mode == 'update' && item ? item.account : ''
                },
                {
                    name: '密保邮箱',
                    key: 'email',
                    placeholder: '请输入密保邮箱',
                    rules: [
                        { required: true, message: '密保邮箱不能为空', trigger: 'blur' },
                        { validator: this.$validation.email }
                    ],
                    clearable: true,
                    value: mode == 'update' && item ? item.email : ''
                },
                {
                    name: '角色管理',
                    element: 'checkbox',
                    key: 'role_ids',
                    value: mode == 'update' && item ? item.role_ids : [],
                    option: this.$page.props.roles
                },
                {
                    name: '账号状态',
                    element: 'switch',
                    key: 'is_valid',
                    value: mode == 'update' && item ? (item.is_valid ? 1 : 0) : 1
                }
            );
            }
            if (mode == 'create' || mode == 'password') {
                result.push({
                    name: '登录密码',
                    key: 'password',
                    value: '',
                    type: 'password',
                    rules: [
                        { required: true, message: '登录密码不能为空', trigger: 'blur' },
                        { validator: this.$validation.password }
                    ]
                }, {
                    name: '重复密码',
                    key: 'password_confirmation',
                    value: '',
                    type: 'password',
                    rules: [
                        { required: true, message: '重复密码不能为空', trigger: 'blur' },
                        { validator: this.$validation.password }
                    ]
                })
            }
            return result;
        },
        viewItem(item) {
            this.drawerVisit = true
            this.$nextTick(() => {
                this.$refs.DictItemDrawerRef.open(item)
            })
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
            let res = await this.$axios.delete(this.$route('backend.manager_delete', { id: item.id }))
            if (res.code == this.$config.successCode) {
                this.$message.success("删除管理员成功");
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
@import '@scss/manager/index.scss';
</style>