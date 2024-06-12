<template>
    <DefaultLayout>
        <div class="SimpleCMS-dict">
            <div class="SimpleCMS-dict-box">
                <VTable action="backend.role_list" :params="queryParam" @search="searchData" ref="tableRef">
                    <template #header_left>
                        <el-form-item>
                            <v-dialog-form button="添加角色" header="新增角色" :action="$route('backend.role_create')"
                                method="post" :options="formItem('create')" @saved="refreshData()"></v-dialog-form>
                        </el-form-item>
                    </template>
                    <template #header_right>
                        <el-form-item>
                            <el-select placeholder="角色类型" v-model="queryParam.type" @change="searchData" clearable
                                style="width:120px;">
                                <el-option v-for="(role, index) in roles" :key="index" :label="role.name"
                                    :value="role.value"></el-option>
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
                    <el-table-column label="序号" width="70px" prop="name">
                        <template #default="scope">
                            <span>{{ scope.$index + 1 }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="角色名称" width="200px" prop="name"></el-table-column>
                    <el-table-column label="角色类型" width="150" prop="type">
                        <template #default="scope">
                            <el-tag size="small" effect="dark">{{ $status('roleType', scope.row.type) }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="角色说明" prop="description">
                        <template #default="scope">
                            <el-tooltip effect="dark" placement="top">
                                <template #content>
                                    <el-tag v-for="(c,i) in scope.row.routes" effect="dark" size="small" style="margin-right:2px;margin-bottom:2px;" :key="i">{{ getStatus(c) }}</el-tag>
                                </template>
                                <span>{{ scope.row.description }}</span>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                    <el-table-column label="排序" width="100px" prop="sort_order" sortable></el-table-column>
                    <el-table-column label="操作" fixed="right" width="135">
                        <template #default="scope">
                            <v-dialog-form header="修改角色信息" :action="$route('backend.role_update', { id: scope.row.id })"
                                method="put" :options="formItem('update', scope.row)" @saved="refreshData()">
                                <el-button title="编辑资料" circle class="el-button--dark">
                                    <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                                </el-button>
                            </v-dialog-form>
                            <v-dialog header="系统提示" v-if="!scope.row.is_super" :name="`removeDialogRef${scope.row.id}`"
                                :ref="`removeDialogRef${scope.row.id}`" content="确定删除此角色？" type="confirm"
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
        roleType: {
            type: Array,
            default: []
        },
        routeList: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            queryParam: this.query,
            roles: this.roleType,
            routes: this.routeList
        }
    },
    watch: {
        '$page.props.roleType': {
            handler(val) {
                this.roles = val
            },
            deep: true
        },
        '$page.props.routeList': {
            handler(val) {
                this.routes = val
            },
            deep: true
        }
    },
    created() {
        this.$nextTick(() => {
            this.roles = this.$page.props.roleType
            this.routes = this.$page.props.routeList
        })
    },
    methods: {
        getStatus(k){
            let res = this.routes.filter(n=>n.value == k)
            if(!res || res.length == 0) return 'Unknown';
            return res[0].name
        },
        formItem(mode, item) {
            let result = [{
                name: '角色名称',
                key: 'name',
                placeholder: '请输入角色名称',
                rules: [
                    { min: 2, max: 50, message: '角色名称仅支持2-50个字符' },
                ],
                clearable: true,
                maxlength: 50,
                value: mode == 'update' && item ? item.name : ''
            }, {
                name: '角色说明',
                key: 'description',
                type: 'textarea',
                placeholder: '请输入角色说明',
                clearable: true,
                maxlength: 250,
                value: mode == 'update' && item ? item.description : ''
            }, {
                name: '角色类型',
                key: 'type',
                element: 'radio',
                option: this.roles,
                placeholder: '请输入角色类型',
                rules: [
                    { required: true, message: '角色类型不能为空', trigger: 'change' },
                ],
                clearable: true,
                value: mode == 'update' && item ? item.type : 1
            }, {
                name: '角色权限',
                key: 'routes',
                element: 'select',
                placeholder: '请输入角色权限',
                option: this.routes,
                limit: 99,
                multiple: true,
                clearable: true,
                value: mode == 'update' && item ? item.routes : []
            },
            {
                name: '排序',
                type: 'number',
                key: 'sort_order',
                placeholder: '请输入排序',
                clearable: true,
                value: mode == 'update' && item ? item.sort_order : 0
            }
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
            let res = await this.$axios.delete(this.$route('backend.role_delete', { id: item.id }))
            if (res.code == this.$config.successCode) {
                this.$message.success("删除角色成功");
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