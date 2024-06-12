<template>
    <DefaultLayout>
        <div class="SimpleCMS-dict">
            <div class="SimpleCMS-dict-box">
                <VTable action="backend.dict_list" :params="queryParam" @search="searchData" ref="tableRef">
                    <template #header_left>
                        <el-form-item>
                            <v-dialog-form button="添加字典" header="增加新字典" :action="$route('backend.dict_create')"
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
                    <el-table-column label="ID" width="100px" prop="id"></el-table-column>
                    <el-table-column label="名称" width="200px" prop="name"></el-table-column>
                    <el-table-column label="标识" prop="code"></el-table-column>
                    <el-table-column label="排序" width="100px" prop="sort_order" sortable></el-table-column>
                    <el-table-column label="操作" fixed="right" width="165">
                        <template #default="scope">
                            <v-dialog-form header="修改字典"
                                :action="$route('backend.dict_update', { id: scope.row.id })" method="put"
                                :options="formItem('edit', scope.row)" @saved="refreshData()">

                                <el-button title="修改" circle class="el-button--dark">
                                    <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                                </el-button>
                            </v-dialog-form>
                            <el-button circle @click="viewItem(scope.row)" class="el-button--dark">
                                <SimpleCMSIconEye size="16px"></SimpleCMSIconEye>
                            </el-button>
                            <v-dialog header="系统提示" :name="`removeDialogRef${scope.row.id}`"
                                :ref="`removeDialogRef${scope.row.id}`" content="确定删除此信息？" type="confirm"
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
        <DictItemDrawer v-if="drawerVisit" ref="DictItemDrawerRef" @closed="drawerVisit = false"></DictItemDrawer>
    </DefaultLayout>
</template>
<script>
import DictItemDrawer from './Addons/DictItemDrawer.vue';
export default {
    components: {
        DictItemDrawer
    },
    props: {
        query: {
            type: Object,
            default: {}
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
            return [
                {
                    name: '名称',
                    key: 'name',
                    placeholder: '请输入名称',
                    rules: [
                        { required: true, message: '名称不能为空', trigger: 'blur' },
                        { min: 2, max: 50, message: '名称仅支持2-50个字符' },
                    ],
                    clearable: true,
                    maxlength: 50,
                    value: mode == 'edit' && item ? item.name : ''
                },
                {
                    name: '标识',
                    key: 'code',
                    placeholder: '请输入标识',
                    rules: [
                        { required: true, message: '标识不能为空', trigger: 'blur' },
                        { validator: this.$validation.ucFirst },
                        { validator: this.$validation.slug }
                    ],
                    clearable: true,
                    value: mode == 'edit' && item ? item.code : ''
                },
                {
                    name: '排序',
                    type: 'number',
                    key: 'sort_order',
                    placeholder: '请输入排序',
                    clearable: true,
                    value: mode == 'edit' && item ? item.sort_order : 0
                }
            ]
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
            let res = await this.$axios.delete(this.$route('backend.dict_delete', { id: item.id }))
            if (res.code == this.$config.successCode) {
                this.$message.success("删除字典成功");
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
@import '@scss/system/dict.scss';
</style>