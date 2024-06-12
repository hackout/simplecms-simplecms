<template>
    <DefaultLayout>
        <div class="SimpleCMS-system">
            <VCard>
                <div class="SimpleCMS-system-extra">
                    <el-form v-if="tab == 'list'" :inline="true" class="SimpleCMS-system-extra-form"
                        label-position="left" @submit.native.prevent="searchData">
                        <el-form-item>
                            <v-dialog header="新增系统参数" ref="addFormRef" confirmText="保存参数" :onConfirm="saveForm"
                                @show="addItem">
                                <template #button>
                                    <el-button type="primary">新增参数</el-button>
                                </template>
                                <el-form @submit.native.prevent="saveForm" :model="form" :rules="rules"
                                    label-position="top">
                                    <el-form-item label="参数类型" prop="type">
                                        <el-select placeholder="参数类型" :teleported="false" v-model="form.type" clearable
                                            style="width:100%;">
                                            <el-option v-for="(type, index) in typeList" :key="index" :label="type.name"
                                                :value="type.value"></el-option>
                                        </el-select>
                                    </el-form-item>
                                    <el-form-item label="名称" prop="name">
                                        <el-input placeholder="请输入名称" v-model="form.name"></el-input>
                                    </el-form-item>
                                    <el-form-item label="标识" prop="code">
                                        <el-input placeholder="请输入标识" v-model="form.code"></el-input>
                                    </el-form-item>
                                    <el-form-item label="排序" prop="sort_order">
                                        <el-input type="number" min="0" placeholder="请输入排序"
                                            v-model="form.sort_order"></el-input>
                                    </el-form-item>
                                    <el-form-item label="可选列表"
                                        v-if="form.type == 'radio' || form.type == 'checkbox' || form.type == 'select'"
                                        prop="options">
                                        <el-select v-model="form.options" multiple filterable allow-create
                                            default-first-option :reserve-keyword="false" placeholder="手动输入,回车确认"
                                            style="width: 100%">
                                        </el-select>
                                    </el-form-item>
                                    <el-form-item label="描述" prop="description">
                                        <el-input type="textarea" maxlength="250" show-word-limit placeholder="请输入描述"
                                            v-model="form.description"></el-input>
                                    </el-form-item>
                                </el-form>
                            </v-dialog>
                        </el-form-item>
                        <el-form-item>
                            <el-select placeholder="参数类型" v-model="queryParam.type" @change="searchData" clearable
                                style="width:120px;">
                                <el-option v-for="(type, index) in typeList" :key="index" :label="type.name"
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
                    </el-form>
                </div>
                <el-tabs v-model="tab" class="SimpleCMS-system-tabs">
                    <el-tab-pane label="系统设置" name="basic">
                        <el-empty v-if="!sys || sys.length == 0" image="/assets/images/no_data.png"
                            description="暂无系统设置参数" :image-size="168">
                            <el-button type="primary" @click="tab = 'list'">去参数列表添加</el-button>
                        </el-empty>
                        <el-form class="SimpleCMS-system-form" :model="sysForm" :rules="sysRules" label-width="100px"
                            label-position="right" ref="systemFormRef">
                            <el-form-item class="SimpleCMS-system-form-item" v-for="(el, index) in sys" :key="index"
                                :prop="el.code">
                                <el-input size="large" v-if="el.type == 'input' || el.type == 'textarea'"
                                    :placeholder="`请输入${el.name}`" clearable v-model="sysForm[el.code]"></el-input>
                                <el-switch v-if="el.type == 'switch'" class="SimpleCMS-dialog-switch"
                                    v-model="sysForm[el.code]" size="large" :active-value="1" :inactive-value="0">
                                    <template #active-action>
                                        <span class="SimpleCMS-dialog-switch-active">是</span>
                                    </template>
                                    <template #inactive-action>
                                        <span class="SimpleCMS-dialog-switch-inactive">否</span>
                                    </template>
                                </el-switch>

                                <el-checkbox-group v-if="el.type == 'checkbox'" v-model="sysForm[el.code]">
                                    <el-checkbox v-for="(opt, index2) in el.options" :key="index2" :label="index2"
                                        :value="index2">
                                        {{ opt }}
                                    </el-checkbox>
                                </el-checkbox-group>
                                <el-radio-group v-if="el.type == 'radio'" v-model="sysForm[el.code]">
                                    <el-radio v-for="(opt, index2) in el.options" :key="index2" :label="index2"
                                        :value="index2">
                                        {{ opt }}
                                    </el-radio>
                                </el-radio-group>
                                <el-select v-if="el.type == 'list'" :teleported="false" v-model="sysForm[el.code]"
                                    multiple filterable allow-create default-first-option :reserve-keyword="false"
                                    placeholder="手动输入,回车确认" style="width: 100%">
                                    <el-option v-for="(opt, i) in sysForm[el.code]" :key="i" :label="opt"
                                        :value="opt" />
                                </el-select>
                                <el-select :teleported="false" v-if="el.type == 'select'" v-model="sysForm[el.code]"
                                    :placeholder="`请输入${el.name}`" autocomplete="off">
                                    <el-option v-for="(opt, index2) in el.options" :key="index2" :label="index2"
                                        :value="index2"></el-option>
                                </el-select>
                                <VUploadFile v-if="el.type == 'image' || el.type == 'file'"
                                    :type="el.type == 'image' ? 'image' : 'file'" v-model="sysForm[el.code]"
                                    :placeholder="`请选择${el.name}`" :src="el.value"></VUploadFile>
                                <VEditor v-if="el.type == 'editor'" v-model="sysForm[el.code]"
                                    :placeholder="`请输入${el.name}`">
                                </VEditor>
                                <template #label>
                                    <span>{{ el.name }}</span>
                                    <el-tooltip v-if="el.description && el.description.length > 0" effect="dark"
                                        :content="el.description" placement="right">
                                        <SimpleCMSIconHelpOctagon size="12px"></SimpleCMSIconHelpOctagon>
                                    </el-tooltip>
                                </template>
                            </el-form-item>
                        </el-form>
                    </el-tab-pane>
                    <el-tab-pane label="参数列表" name="list">
                        <VTable action="backend.system_config_list" rowKey="code" :params="queryParam"
                            @search="searchData" ref="tableRef" :padding="false">
                            <el-table-column label="标识" width="200px" prop="code" align="left"></el-table-column>
                            <el-table-column label="名称" width="100px" prop="name" align="center"> </el-table-column>
                            <el-table-column label="说明" prop="description" align="center"></el-table-column>
                            <el-table-column label="类型" width="100px" prop="type" align="center">
                                <template #default="scope">
                                    <el-tag effect="dark">{{ selectValue(scope.row.type) }}</el-tag>
                                </template>
                            </el-table-column>
                            <el-table-column label="排序" width="100px" prop="sort_order" sortable align="center">
                            </el-table-column>
                            <el-table-column label="操作" width="105" align="right">
                                <template #default="scope">
                                    <v-dialog header="编辑系统参数" :ref="`editForm${scope.row.code}Ref`" confirmText="保存参数"
                                        :onConfirm="saveForm" @show="editItem(scope.row)">
                                        <template #button>
                                            <el-button title="修改" circle class="el-button--dark">
                                                <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                                            </el-button>
                                        </template>
                                        <el-form @submit.native.prevent="saveForm" :model="form" :rules="rules"
                                            label-position="top">
                                            <el-form-item label="参数类型" prop="type">
                                                <el-select placeholder="参数类型" :teleported="false" v-model="form.type"
                                                    clearable style="width:100%;">
                                                    <el-option v-for="(type, index) in typeList" :key="index"
                                                        :label="type.name" :value="type.value"></el-option>
                                                </el-select>
                                            </el-form-item>
                                            <el-form-item label="名称" prop="name">
                                                <el-input placeholder="请输入名称" v-model="form.name"></el-input>
                                            </el-form-item>
                                            <el-form-item label="标识" prop="code">
                                                <el-input placeholder="请输入标识" disabled v-model="form.code"></el-input>
                                            </el-form-item>
                                            <el-form-item label="排序" prop="sort_order">
                                                <el-input type="number" min="0" placeholder="请输入排序"
                                                    v-model="form.sort_order"></el-input>
                                            </el-form-item>
                                            <el-form-item label="可选列表"
                                                v-if="form.type == 'radio' || form.type == 'checkbox' || form.type == 'select'"
                                                prop="options">
                                                <el-select v-model="form.options" multiple filterable allow-create
                                                    default-first-option :reserve-keyword="false"
                                                    placeholder="手动输入,回车确认" style="width: 100%">
                                                    <el-option v-for="(opt, i) in form.options" :key="i" :label="opt"
                                                        :value="opt" />
                                                </el-select>
                                            </el-form-item>
                                            <el-form-item label="描述" prop="description">
                                                <el-input type="textarea" maxlength="250" show-word-limit
                                                    placeholder="请输入描述" v-model="form.description"></el-input>
                                            </el-form-item>
                                        </el-form>
                                    </v-dialog>
                                    <v-dialog header="系统提示" :name="`removeDialogRef${scope.row.code}`"
                                        :ref="`removeDialogRef${scope.row.code}`" content="确定删除此参数？" type="confirm"
                                        @confirm="deleteItem(scope.row, `removeDialogRef${scope.row.code}`)">
                                        <template #button>
                                            <el-button title="删除" circle class="el-button--dark">
                                                <SimpleCMSIconTrash size="16px"></SimpleCMSIconTrash>
                                            </el-button>
                                        </template>
                                    </v-dialog>
                                </template>
                            </el-table-column>
                        </VTable>
                    </el-tab-pane>
                </el-tabs>
                <template #footer v-if="tab == 'basic' && sys && sys.length > 0">
                    <div class="SimpleCMS-system-footer">
                        <el-button type="primary" :loading="saving" @click="onSubmit">保存设置</el-button>
                    </div>
                </template>
            </VCard>
        </div>
    </DefaultLayout>
</template>
<script>
export default {
    props: {
        systemConfig: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            sys: this.systemConfig,
            tab: 'basic',
            queryParam: {
                page: 1,
                limit: 15,
                keyword: '',
                type: ''
            },
            typeList: [
                { name: '单行文本', value: 'input' },
                { name: '多行文本', value: 'textarea' },
                { name: '编辑器', value: 'editor' },
                { name: '文件输入', value: 'file' },
                { name: '图片输入', value: 'image' },
                { name: '单选项', value: 'radio' },
                { name: '开关', value: 'switch' },
                { name: '多选项', value: 'checkbox' },
                { name: '列表', value: 'list' },
                { name: '下拉选项', value: 'select' }
            ],
            mode: 'create',
            refName: 'addFormRef',
            saving: false,
            form: {
                name: '',
                code: '',
                type: 'input',
                description: '',
                options: [],
                sort_order: 0
            },
            rules: {
                type: [
                    { required: true, message: '参数类型不能为空', trigger: 'change' }
                ],
                name: [
                    { required: true, message: '名称不能为空', trigger: 'blur' },
                    { min: 2, max: 50, message: '名称仅支持2-50个字符' },
                ],
                code: [
                    { required: true, message: '标识不能为空', trigger: 'blur' },
                    {
                        validator: (rule, value, callback) => {
                            if (value && !/^[a-z]/.test(value.charAt(0))) {
                                callback(new Error('首字母必须为小写字母'));
                            } else {
                                callback();
                            }
                        }
                    },
                    {
                        pattern: /^([0-9a-z\_]){3,50}$/,
                        message: '请填写使用小写字母、数字、下划线的3-50位的字符串'
                    }
                ]
            },
            sysForm: {},
            sysRules: {}
        }
    },
    watch: {
        '$page.props.systemConfig': {
            handler(val) {
                this.sys = val
                this.convertForm()
            },
            deep: true
        }
    },
    created() {
        this.$nextTick(() => {
            this.sys = this.$page.props.systemConfig
            this.convertForm()
        })
    },
    methods: {
        convertForm() {
            this.sysForm = {}
            this.sysRules = {}
            this.sys.forEach(n => {
                this.sysForm[n.code] = n.type == 'file' || n.type == 'image' ? '' : n.value
                if (n.type == 'switch') {
                    this.sysForm[n.code] = n.value ? 1 : 0;
                }
                if (n.type == 'input' || n.type == 'textarea' || n.type == 'editor') {
                    this.sysRules[n.code] = [
                        {
                            required: true,
                            message: `${n.name}不能为空`,
                            trigger: 'blur'
                        }
                    ];
                }
                if (n.type == 'radio' || n.type == 'checkbox' || n.type == 'select' || n.type == 'list') {
                    this.sysRules[n.code] = [
                        {
                            required: true,
                            message: `${n.name}不能为空`,
                            trigger: 'change'
                        }
                    ];
                }
            })
        },
        addItem() {
            this.mode = 'create'
            this.refName = 'addFormRef'
            this.form = {
                name: '',
                code: '',
                type: 'input',
                description: '',
                options: [],
                sort_order: 0
            }
        },
        editItem(item) {
            this.mode = 'update'
            this.refName = `editForm${item.code}Ref`
            this.form = {
                name: item.name,
                code: item.code,
                type: item.type,
                description: item.description,
                options: item.options,
                sort_order: item.sort_order
            }
        },
        selectValue(key) {
            let v = this.typeList.filter(n => n.value == key)
            if (v.length == 0) return 'Unknown'
            return v[0].name
        },
        loadAfter() {
            this.$reload()
            this.refreshData()
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
        async saveForm() {
            if (!this.saving) {
                this.saving = true
                let method = this.mode == 'create' ? 'post' : 'put'
                let url = this.$route('backend.system_config_' + this.mode, this.mode == 'create' ? {} : { slug: this.form.code })
                let res = await this.$axios[method](url, this.form)
                this.saving = false
                if (res.code == this.$config.successCode) {
                    this.$message.success('保存参数成功')
                    this.$refs[this.refName].closeDialog()
                    this.loadAfter()

                } else {
                    this.$message.error(res.message)
                }
            }
        },
        onSubmit() {
            if (!this.saving) {
                this.saving = true
                this.$refs.systemFormRef.validate().then(async () => {
                    let form = new FormData()
                    Object.keys(this.sysForm).forEach(n => {
                        form.append(n, this.sysForm[n])
                    })
                    let res = await this.$axios.post(this.$route('backend.system_save'), form)
                    this.saving = false
                    if (res.code == this.$config.successCode) {
                        this.$message.success("保存信息成功");
                        this.$closeDialog(refName)
                        this.loadAfter()
                    } else {
                        this.$message.error(res.message)
                    }
                }).catch(() => {
                    this.saving = false
                })
            }
        },
        async deleteItem(item, refName) {
            let res = await this.$axios.delete(this.$route('backend.system_config_delete', { slug: item.code }))
            if (res.code == this.$config.successCode) {
                this.$message.success("删除参数成功");
                this.$closeDialog(refName)
                this.loadAfter()
            } else {
                this.$message.error(res.message)
            }
        }
    }
}
</script>
<style lang="scss" scoped>
@import '@scss/system/index.scss';
</style>