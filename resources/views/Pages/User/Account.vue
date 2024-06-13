<template>
    <DefaultLayout>
        <div class="SimpleCMS-userAccount">
            <div class="SimpleCMS-userAccount-box">
                <VTable action="backend.account.list" :params="queryParam" @search="searchData" ref="tableRef">
                    <template #header_left>
                        
                    </template>
                    <template #header_right>
                        <el-form-item>
                            <el-select placeholder="账号类型" v-model="queryParam.type" @change="searchData" clearable
                                style="width:120px;">
                                <el-option v-for="(type, index) in account_types" :key="index" :label="type.name"
                                    :value="type.value"></el-option>
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
                    <el-table-column label="账号" min-width="200px" prop="account">
                    </el-table-column>
                    <el-table-column label="类型" width="200px" prop="type">
                        <template #default="scope">
                            <el-tag effect="dark">{{ $status('accountType',scope.row.type) }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="OAuth ID" width="200px" prop="oauth_id"></el-table-column>
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
                    <el-table-column label="操作" fixed="right" width="75" align="right">
                        <template #default="scope">
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
        accountType: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            queryParam: this.query,
            account_types: this.$page.props.accountType
        }
    },
    created() {
        this.$nextTick(() => {
            this.account_types = this.$page.props.accountType
        })
    },
    methods: {
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
            let res = await this.$axios.delete(this.$route('backend.account.delete', { id: item.id,type:item.type }))
            if (res.code == this.$config.successCode) {
                this.$message.success("删除账号信息成功");
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
@import '@scss/user/account.scss';
</style>