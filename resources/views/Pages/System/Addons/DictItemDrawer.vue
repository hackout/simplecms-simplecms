<template>
    <VTableDrawer title="字典项列表" action="backend.dict_item_list" width="750px" ref="tableDrawerRef" :params="query"
        @closed="$emit('closed')" @search="searchData">
        <template #header_left>
            <el-form-item>
                <v-dialog-form button="添加字典项" header="增加字典项" :action="$route('backend.dict_item_create')" method="post"
                    :options="formItem('create')" @saved="refreshData()"></v-dialog-form>
            </el-form-item>
        </template>
        <template #header_right>
            <el-form-item>
                <el-input v-model="query.keyword" clearable @clear="searchData" placeholder="关键词"
                   ></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" native-type="submit">查询</el-button>
            </el-form-item>
        </template>
        <el-table-column label="ID" width="100px" prop="id"></el-table-column>
        <el-table-column label="名称" width="200px" prop="name">
            <template #default="scope">
                <el-tooltip placement="top" :disabled="!scope.row.thumbnail || scope.row.thumbnail.length == 0"
                    popper-class="simpleCMS-upload-file-tooltip">
                    <template #content><el-image :src="scope.row.thumbnail"
                            style="width:128px;height:128px;" /></template>
                    <span>{{ scope.row.name }}</span>
                </el-tooltip>
            </template>
        </el-table-column>
        <el-table-column label="标识" prop="value"></el-table-column>
        <el-table-column label="排序" width="100px" prop="sort_order" sortable></el-table-column>
        <el-table-column label="操作" fixed="right" width="115">
            <template #default="scope">
                <v-dialog-form header="编辑字典项" :action="$route('backend.dict_item_update', { id: scope.row.id })"
                    method="post" :options="formItem('edit', scope.row)" @saved="refreshData()">
                    <el-button title="修改" circle class="el-button--dark">
                        <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                    </el-button>
                </v-dialog-form>
                <v-dialog header="系统提示" :name="`removeDialogRef${scope.row.id}`" :ref="`removeDialogRef${scope.row.id}`"
                    content="确定删除此信息？" type="confirm"
                    @confirm="deleteItem(scope.row, `removeDialogRef${scope.row.id}`)">
                    <template #button>
                        <el-button circle class="el-button--dark">
                            <SimpleCMSIconTrash size="16px"></SimpleCMSIconTrash>
                        </el-button>
                    </template>
                </v-dialog>
            </template>
        </el-table-column>
    </VTableDrawer>
</template>
<script>

export default {
    emits: ['closed'],
    data() {
        return {
            item: {},
            visit: false,
            query: {
                dict_id: 0,
                page: 1,
                limit: 15
            },
            viewVisit: false,
            image: null,
            form: {
                id: '',
                dict_id: '',
                name: '',
                content: '',
                sort_order: 0,
                file: ''
            },
            rules: {
                content: [
                    { required: true, message: '键值不能为空', trigger: 'blur' },
                ],
                name: [
                    { required: true, message: '键名不能为空', trigger: 'blur' }
                ]
            },
            saving: false
        }
    },
    created() {
        this.$nextTick(() => {

        })
    },
    methods: {
        open(item) {
            this.item = item
            this.query = {
                dict_id: item.id,
                page: 1,
                limit: 15,
                keyword: ''
            }
            this.$refs.tableDrawerRef.open()
        },
        formItem(mode, item) {
            return [
                {
                    name: '键名',
                    key: 'name',
                    placeholder: '请输入键名',
                    rules: [
                        { required: true, message: '键名不能为空', trigger: 'blur' },
                    ],
                    clearable: true,
                    maxlength: 50,
                    value: mode == 'edit' && item ? item.name : ''
                },
                {
                    name: '键值',
                    key: 'content',
                    placeholder: '请输入键值',
                    rules: [
                        { required: true, message: '键值不能为空', trigger: 'blur' }
                    ],
                    clearable: true,
                    value: mode == 'edit' && item ? item.value : ''
                },
                {
                    name: '排序',
                    type: 'number',
                    key: 'sort_order',
                    placeholder: '请输入排序',
                    clearable: true,
                    value: mode == 'edit' && item ? item.sort_order : 0
                },
                {
                    name: '缩率图',
                    element: 'image',
                    key: 'file',
                    placeholder: '请输入缩率图',
                    clearable: true,
                    preview: mode == 'edit' && item ? item.thumbnail : ''
                },
                {
                    element: 'hidden',
                    key: 'dict_id',
                    value: this.item.id
                }
            ]
        },
        searchData() {
            this.query.page = 1;
            this.refreshData();
        },
        refreshData() {
            this.$nextTick(() => {
                this.$refs.tableDrawerRef.refreshData()
            })
        },
        async deleteItem(item, refName) {
            let res = await this.$axios.delete(this.$route('backend.dict_item_delete', { id: item.id }))
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