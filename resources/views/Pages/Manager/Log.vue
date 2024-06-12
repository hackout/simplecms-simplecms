<template>
    <DefaultLayout>
        <div class="SimpleCMS-dict">
            <div class="SimpleCMS-dict-box">
                <VTable action="backend.manager_log_list" :params="queryParam" @search="searchData" ref="tableRef">
                    <template #header_left>
                        <el-button :loading="cleaning" type="danger" @click="clean">清空记录</el-button>
                    </template>
                    <template #header_right>
                        <el-form-item>
                            <el-select placeholder="管理员" v-model="queryParam.manager_id" @change="searchData" clearable
                                style="width:120px;">
                                <el-option v-for="(manager, index) in managers" :key="index" :label="manager.name"
                                    :value="manager.value"></el-option>
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
                    <el-table-column label="ID" width="160px" prop="id" show-overflow-tooltip>
                        <template #default="scope">
                            <small>{{ scope.row.id }}</small>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作说明" width="200px" prop="name"></el-table-column>
                    <el-table-column label="访问地址" min-width="200px" prop="account">
                        <template #default="scope">
                            <el-tooltip effect="dark"
                                :content="`路由:${scope.row.route_name}<br />参数:${scope.row.parameters}<br />UserAgent:${scope.row.user_agent}`"
                                raw-content placement="top">
                                <el-tag type="primary" effect="dark" size="small">
                                    <span v-if="scope.row.method == 1">GET</span>
                                    <span v-if="scope.row.method == 2">POST</span>
                                    <span v-if="scope.row.method == 3">PUT</span>
                                    <span v-if="scope.row.method == 4">PATCH</span>
                                    <span v-if="scope.row.method == 5">DELETE</span>
                                </el-tag>
                            </el-tooltip>
                            <code style="margin-left:6px;">{{ scope.row.url }}</code>
                        </template>
                    </el-table-column>
                    <el-table-column label="状态" prop="status">
                        <template #default="scope">
                            <el-tag :type="scope.row.status ? 'primary' : 'danger'" effect="dark">{{
                                scope.row.status ? '失败' :
                                    '成功' }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="最后登录" prop="created_at">
                        <template #default="scope">
                            <span>{{ $tool.dateFormat(scope.row.created_at) }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作" fixed="right" width="70" align="center">
                        <template #default="scope">
                            <v-dialog header="系统提示" :name="`removeDialogRef${scope.row.id}`"
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
    components: {
    },
    props: {
        query: {
            type: Object,
            default: {}
        },
        managerList: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            queryParam: this.query,
            drawerVisit: false,
            managers: this.managerList,
            cleaning: false
        }
    },
    created() {
        this.$nextTick(() => {
            this.managers = this.$page.props.managerList
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
            let res = await this.$axios.delete(this.$route('backend.manager_log_delete', { id: item.id }))
            if (res.code == this.$config.successCode) {
                this.$message.success("删除字典成功");
                this.$closeDialog(refName)
                this.refreshData()
            } else {
                this.$message.error(res.message)
            }
        },
        async clean() {
            if (!this.cleaning) {
                this.cleaning = true
                let res = await this.$axios.post(this.$route('backend.manager_log_clean'))
                this.cleaning = false
                if (res.code == this.$config.successCode)
                    this.$message.success("清空日志成功");
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