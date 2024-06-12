<template>
    <DefaultLayout>
        <div class="SimpleCMS-menu">
            <div class="SimpleCMS-menu-box">
                <VTable action="backend.menu_list" rowKey="id" :params="queryParam" @search="searchData"
                    @change="changeData" @selection-change="onSelectionChange" ref="tableRef">
                    <template #header_left>
                        <el-form-item>
                            <v-dialog-form button="添加菜单" header="新增菜单" :action="$route('backend.menu_create')"
                                method="post" :options="formItem('create')" @saved="loadAfter()"></v-dialog-form>
                        </el-form-item>
                        <el-form-item>
                            <el-button @click="toggleEdit" v-if="!editable" type="success">
                                <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                                <span>编辑</span>
                            </el-button>
                            <el-button @click="toggleEdit" v-else type="danger">
                                <SimpleCMSIconX size="16px"></SimpleCMSIconX>
                                <span>关闭</span>
                            </el-button>
                        </el-form-item>
                        <template v-if="editable">
                            <el-form-item>
                                <el-button :loading="saving" :disabled="quickItems.length == 0" @click="quickSave"
                                    type="primary">
                                    <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                                    <span>保存</span>
                                </el-button>
                            </el-form-item>
                            <el-form-item>
                                <el-button :loading="deleting" :disabled="quickItems.length == 0" @click="batchDelete"
                                    type="danger">
                                    <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                                    <span>删除</span>
                                </el-button>
                            </el-form-item>
                        </template>
                    </template>
                    <template #header_right>
                        <el-form-item>
                            <el-select placeholder="菜单类型" v-model="queryParam.type" @change="searchData" clearable
                                style="width:120px;">
                                <el-option v-for="(dict, index) in menuType" :key="index" :label="dict.name"
                                    :value="dict.value"></el-option>
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
                    <el-table-column type="selection" width="45" v-if="editable" />
                    <el-table-column label="ID" width="100px" prop="id" align="center"></el-table-column>
                    <el-table-column label="场景" width="100px" prop="type" align="center">
                        <template #default="scope">
                            <el-tag type="primary" v-if="scope.row.type == 2" effect="dark">前台</el-tag>
                            <el-tag type="warning" v-else-if="scope.row.type == 1" effect="dark">后台</el-tag>
                            <el-tag type="primary" class="el-tag--grey" v-else effect="dark">未知</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="名称" width="200px" prop="name" align="center"></el-table-column>
                    <el-table-column label="路由" min-width="200px" prop="url.uri">
                        <template #default="scope">
                            <span>{{ scope.row.children && scope.row.children.length > 0 ? '-' : scope.row.url.uri
                                }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="状态" width="100px" prop="is_valid" align="center">
                        <template #default="scope">
                            <el-tag v-if="!editable" type="primary" :class="{ 'el-tag--grey': !scope.row.is_valid }"
                                effect="dark">{{
                                    scope.row.is_valid ? '启用'
                                        : '禁用' }}</el-tag>

                            <el-switch v-else class="SimpleCMS-dialog-switch" v-model="quickForm[scope.row.id].is_valid"
                                size="large" :active-value="1" :inactive-value="0">
                                <template #active-action>
                                    <span class="SimpleCMS-dialog-switch-active">是</span>
                                </template>
                                <template #inactive-action>
                                    <span class="SimpleCMS-dialog-switch-inactive">否</span>
                                </template>
                            </el-switch>
                        </template>
                    </el-table-column>
                    <el-table-column label="显示" width="100px" prop="is_show" align="center">
                        <template #default="scope">
                            <el-tag v-if="!editable" type="primary" :class="{ 'el-tag--grey': !scope.row.is_show }"
                                effect="dark">{{
                                    scope.row.is_show ? '显示' :
                                        '隐藏' }}</el-tag>
                            <el-switch v-else class="SimpleCMS-dialog-switch" v-model="quickForm[scope.row.id].is_show"
                                size="large" :active-value="1" :inactive-value="0">
                                <template #active-action>
                                    <span class="SimpleCMS-dialog-switch-active">是</span>
                                </template>
                                <template #inactive-action>
                                    <span class="SimpleCMS-dialog-switch-inactive">否</span>
                                </template>
                            </el-switch>
                        </template>
                    </el-table-column>
                    <el-table-column label="排序" :width="editable ? '220px' : '100px'" prop="sort_order" sortable
                        align="center">
                        <template #default="scope">
                            <span v-if="!editable">{{ scope.row.sort_order }}</span>
                            <el-input-number :min="0" v-else v-model="quickForm[scope.row.id].sort_order"
                                controls-position="right" />
                        </template>
                    </el-table-column>
                    <el-table-column label="操作" v-if="!editable" width="135" align="right">
                        <template #default="scope">
                                <v-dialog-form header="修改菜单信息"
                                    :action="$route('backend.menu_update', { id: scope.row })" method="put"
                                    :options="formItem('edit', scope.row)" @saved="loadAfter()">
                                    <el-button title="修改" circle class="el-button--dark">
                                        <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                                    </el-button>
                                </v-dialog-form>
                                <v-dialog-form header="增加下级菜单" :action="$route('backend.menu_create')" method="post"
                                    :options="formItem('append', { parent_id: scope.row.id, type: scope.row.type })"
                                    @saved="loadAfter()">
                                    <el-button title="添加下级" circle class="el-button--dark">
                                        <SimpleCMSIconTextPlus size="16px"></SimpleCMSIconTextPlus>
                                    </el-button>
                                </v-dialog-form>
                                <v-dialog header="系统提示" v-if="scope.row.can_delete" :name="`removeDialogRef${scope.row.id}`"
                                    :ref="`removeDialogRef${scope.row.id}`" content="确定删除此菜单？" type="confirm"
                                    @confirm="deleteItem(scope.row, `removeDialogRef${scope.row.id}`)">
                                    <template #button>
                                        <el-button title="删除" circle class="el-button--dark">
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
        menuType: {
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
            editable: false,
            saving: false,
            deleting: false,
            quickForm: {},
            quickItems: []
        }
    },
    created() {
        this.$nextTick(() => {
        })
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
                        { max: 50, message: '名称仅支持2-50个字符' },
                    ],
                    clearable: true,
                    maxlength: 50,
                    span: 24,
                    value: mode == 'edit' && item ? item.name : ''
                },
                {
                    name: '图标',
                    key: 'icon',
                    placeholder: '请输入图标',
                    extra: {
                        url: 'https://tabler.io/icons',
                        name: '查找图标'
                    },
                    clearable: true,
                    span: 12,
                    value: mode == 'edit' && item ? item.icon : ''
                },
                {
                    name: '应用场景',
                    key: 'type',
                    element: 'select',
                    placeholder: '请选择应用场景',
                    clearable: true,
                    disabled: mode == 'append' ? true : false,
                    span: 12,
                    value: mode == 'edit' && item ? item.type : (mode == 'append' ? item.type : 1),
                    option: [
                        { name: '后台', value: 1 },
                        { name: '前台', value: 2 }
                    ]
                },
                {
                    name: '路由地址',
                    element: 'select',
                    key: 'uri',
                    placeholder: '请输入路由地址',
                    rules: [
                        { required: true, message: '名称不能为空', trigger: 'blur' },
                        { max: 50, message: '名称仅支持2-50个字符' },
                    ],
                    filterable: true,
                    clearable: true,
                    maxlength: 50,
                    span: 24,
                    option: this.routeList,
                    value: mode == 'edit' && item ? item.url.uri : ''
                },
                {
                    name: '是否有效',
                    key: 'is_valid',
                    span: 8,
                    element: 'switch',
                    value: mode == 'edit' && item ? (item.is_valid ? 1 : 0) : 1
                },
                {
                    name: '是否显示',
                    key: 'is_show',
                    span: 8,
                    element: 'switch',
                    value: mode == 'edit' && item ? (item.is_show ? 1 : 0) : 1
                },
                {
                    name: '排序',
                    type: 'number',
                    key: 'sort_order',
                    placeholder: '请输入排序',
                    clearable: true,
                    span: 8,
                    value: mode == 'edit' && item ? item.sort_order : 0
                },
                {
                    element: 'hidden',
                    key: 'parent_id',
                    value: mode == 'edit' && item ? item.parent_id : (mode == 'append' ? item.parent_id : 0)
                }
            ]
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
        loadAfter() {
            this.$reload()
            this.refreshData()
        },
        async deleteItem(item, refName) {
            let res = await this.$axios.delete(this.$route('backend.menu_delete', { id: item.id }))
            if (res.code == this.$config.successCode) {
                this.$message.success("删除菜单成功");
                this.$closeDialog(refName)
                this.loadAfter()
            } else {
                this.$message.error(res.message)
            }
        },
        toggleEdit() {
            this.editable = !this.editable
        },
        onSelectionChange(items) {
            this.quickItems = items
        },
        changeData(items) {
            this.quickForm = {}
            items.forEach(n => {
                this.convertQuick(n)
            })
        },
        convertQuick(item) {
            this.quickForm[item.id] = {
                id: item.id,
                is_valid: item.is_valid ? 1 : 0,
                is_show: item.is_show ? 1 : 0,
                sort_order: item.sort_order,
            }
            if (item.children && item.children.length > 0) {
                item.children.forEach(n => {
                    this.convertQuick(n)
                })
            }
        },
        async quickSave() {
            if (!this.saving) {
                this.saving = true
                let form = { items: [] }
                this.quickItems.forEach(n => {
                    if (this.quickForm && this.quickForm[n.id]) {
                        form.items.push(this.quickForm[n.id])
                    }
                })
                let res = await this.$axios.post(this.$route('backend.menu_quick'), form)
                this.saving = false
                if (res.code == this.$config.successCode) {
                    this.$message.success('保存信息成功')
                    this.loadAfter()
                } else {
                    this.$message.error(res.message)
                }
            }
        },
        async batchDelete() {
            if (!this.deleting) {
                this.deleting = true
                let form = { items: [] }
                this.quickItems.forEach(n => {
                    form.items.push(n.id)
                })
                let res = await this.$axios.post(this.$route('backend.menu_batch_delete'), form)
                this.deleting = false
                if (res.code == this.$config.successCode) {
                    this.$message.success('批量删除成功')
                    this.loadAfter()
                } else {
                    this.$message.error(res.message)
                }
            }
        }
    }
}
</script>
<style lang="scss" scoped>
@import '@scss/system/menu.scss';
</style>