<template>
    <DefaultLayout>
        <div class="SimpleCMS-role">
            <div class="SimpleCMS-role-box">
                <VTable action="backend.user_group.list" :params="queryParam" @search="searchData" ref="tableRef">
                    <template #header_left>
                        <el-form-item>
                            <v-dialog-form button="添加会员组" header="新增会员组" :action="$route('backend.user_group.create')"
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
                    <el-table-column label="名称" width="200px" prop="name"></el-table-column>
                    <el-table-column label="默认" width="150" prop="is_default">
                        <template #default="scope">
                            <el-tag size="small" :type="scope.row.is_default ? 'primary' : ''" class="el-tag--dark"
                                effect="dark">{{ scope.row.is_default ? '是' : '否' }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="说明" prop="description"></el-table-column>
                    <el-table-column label="排序" width="100px" prop="sort_order" sortable></el-table-column>
                    <el-table-column label="操作" fixed="right" width="135">
                        <template #default="scope">
                            <v-dialog-form header="修改会员组信息"
                                :action="$route('backend.user_group.update', { id: scope.row.id })" method="put"
                                :options="formItem('update', scope.row)" @saved="refreshData()">
                                <el-button title="编辑资料" circle class="el-button--dark">
                                    <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                                </el-button>
                            </v-dialog-form>
                            <v-dialog header="系统提示" v-if="!scope.row.is_super" :name="`removeDialogRef${scope.row.id}`"
                                :ref="`removeDialogRef${scope.row.id}`" content="确定删除此会员组？" type="confirm"
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
        }
    },
    data() {
        return {
            queryParam: this.query,
        }
    },
    methods: {
        formItem(mode, item) {
            let result = [{
                name: '会员组名称',
                key: 'name',
                placeholder: '请输入会员组名称',
                rules: [
                    { required: true, message: '会员组名称不能为空', trigger: 'blur' },
                    { min: 2, max: 50, message: '会员组名称仅支持2-50个字符' }
                ],
                clearable: true,
                maxlength: 50,
                value: mode == 'update' && item ? item.name : ''
            }, {
                name: '会员组说明',
                key: 'description',
                type: 'textarea',
                placeholder: '请输入会员组说明',
                clearable: true,
                maxlength: 250,
                value: mode == 'update' && item ? item.description : ''
            }, {
                name: '是否默认',
                key: 'is_default',
                element: 'switch',
                clearable: true,
                value: mode == 'update' && item && item.is_default ? 1 : 0
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
            let res = await this.$axios.delete(this.$route('backend.user_group.delete', { id: item.id }))
            if (res.code == this.$config.successCode) {
                this.$message.success("删除会员组成功");
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
@import '@scss/user/group.scss';
</style>