<template>

    <v-dialog :header="headerText" name="dialogFormRef" ref="dialogFormRef" :confirmText="confirmText"
        @show="convertOptions" :onConfirm="onSubmit" :loading="saving">
        <template #button>
            <slot v-if="$slots.default"></slot>
            <el-button v-else type="primary">{{ buttonText }}</el-button>
        </template>
        <el-form style="width: 100%" :rules="rules" :model="form" label-width="auto" label-position="top"
            ref="dialogFormRefForm">
            <el-skeleton :rows="5" animated v-if="!builded">
            </el-skeleton>
            <el-row :gutter="10" v-else>
                <template v-for="(col, index) in items" :key="index">
                    <el-col v-if="col.element != 'hidden'" :data-key="index" :span="col.span">
                        <el-form-item :prop="col.key">
                            <template #label>
                                <div class="SimpleCMS-dialog-form-label">
                                    <span>{{ col.name }}</span>
                                    <el-link style="margin-right:-30px" v-if="extra[col.key]" :underline="false"
                                        :href="extra[col.key].url" target="_blank">
                                        <SimpleCMSIconLink size="14px"></SimpleCMSIconLink>
                                        <span class="span">{{ extra[col.key].name }}</span>
                                    </el-link>
                                </div>
                            </template>
                            <el-input v-if="col.element == 'input'" v-model="form[col.key]" :type="col.type"
                                :maxlength="col.maxlength" :max="col.max" :min="col.min" :step="col.step"
                                :placeholder="col.placeholder" :clearable="col.clearable" :disabled="col.disabled"
                                :readonly="col.readonly" :tabindex="col.tabindex" autocomplete="off"
                                @change="onChange(col.key, col.change)">
                                <template #prefix v-if="col.prefix">
                                    <component :is="`SimpleCMS${col.prefix}`" size="18px"></component>
                                </template>
                                <template #suffix v-if="col.suffix">
                                    <component :is="`SimpleCMS${col.suffix}`" size="18px"></component>
                                </template>
                            </el-input>
                            <el-switch v-if="col.element == 'switch'" class="SimpleCMS-dialog-switch"
                                v-model="form[col.key]" size="large" :active-value="col.activeValue"
                                :inactive-value="col.inactiveValue" :tabindex="col.tabindex" :disabled="col.disabled"
                                :readonly="col.readonly" @change="onChange(col.key, col.change)">
                                <template #active-action>
                                    <span class="SimpleCMS-dialog-switch-active">{{ col.activeText }}</span>
                                </template>
                                <template #inactive-action>
                                    <span class="SimpleCMS-dialog-switch-inactive">{{ col.inactiveText }}</span>
                                </template>
                            </el-switch>
                            <el-date-picker v-if="col.element == 'date'" v-model="form[col.key]"
                                :type="col.type ? col.type : 'date'" :placeholder="col.placeholder"
                                :start-placeholder="col.startPlaceholder" :end-placeholder="col.endPlaceholder"
                                :range-separator="col.separator" :clearable="col.clearable" :disabled="col.disabled"
                                :readonly="col.readonly" :editable="col.editable" :format="col.format"
                                :tabindex="col.tabindex" @change="onChange(col.key, col.change)"></el-date-picker>
                            <el-color-picker v-if="col.element == 'color'" v-model="form[col.key]" :show-alpha="false"
                                :type="col.type ? col.type : 'date'" :placeholder="col.placeholder" color-format="hex"
                                :predefine="col.predefine" :tabindex="col.tabindex" :disabled="col.disabled"
                                @change="onChange(col.key, col.change)"></el-color-picker>
                            <el-color-picker v-if="col.element == 'color'" v-model="form[col.key]" :show-alpha="false"
                                :type="col.type ? col.type : 'date'" :placeholder="col.placeholder" color-format="hex"
                                :predefine="col.predefine" :tabindex="col.tabindex" :disabled="col.disabled"
                                @change="onChange(col.key, col.change)"></el-color-picker>
                            <el-checkbox-group v-if="col.element == 'checkbox'" v-model="form[col.key]" :min="col.min"
                                :max="col.max" :disabled="col.disabled" @change="onChange(col.key, col.change)">
                                <el-checkbox v-for="(column, index2) in option[col.key]" :tabindex="col.tabindex"
                                    :key="index2" :label="column.value" :value="column.value">
                                    {{ column.name }}
                                </el-checkbox>
                            </el-checkbox-group>
                            <el-radio-group v-if="col.element == 'radio'" v-model="form[col.key]" :min="col.min"
                                :max="col.max" :disabled="col.disabled" @change="onChange(col.key, col.change)">
                                <el-radio v-for="(column, index2) in option[col.key]" :tabindex="col.tabindex"
                                    :key="index2" :label="column.value" :value="column.value">
                                    {{ column.name }}
                                </el-radio>
                            </el-radio-group>
                            <el-input-number v-if="col.element == 'number'" v-model="form[col.key]" :max="col.max"
                                :min="col.min" :step="col.step" :placeholder="col.placeholder"
                                :clearable="col.clearable" :disabled="col.disabled" :readonly="col.readonly"
                                :tabindex="col.tabindex" @change="onChange(col.key, col.change)"></el-input-number>
                            <el-select :teleported="false" v-if="col.element == 'select'" v-model="form[col.key]"
                                :multiple-limit="col.limit" :multiple="col.multiple" :clearable="col.clearable"
                                :filterable="col.filterable" :disabled="col.disabled" :readonly="col.readonly"
                                :placeholder="col.placeholder" autocomplete="off"
                                @change="onChange(col.key, col.change)">
                                <el-option v-for="(column, index2) in option[col.key]" :tabindex="col.tabindex"
                                    :key="index2" :label="column.name" :value="column.value"></el-option>
                            </el-select>
                            <VUploadFile v-if="col.element == 'image'" v-model="form[col.key]"
                                :placeholder="col.placeholder" :src="col.preview"></VUploadFile>
                            <VEditor v-if="col.element == 'editor'" v-model="form[col.key]"
                                :placeholder="col.placeholder" :readonly="col.readonly" :disabled="col.disabled"
                                :toolbar="editor[col.key]" @change="onChange(col.key, col.change)"></VEditor>
                        </el-form-item>
                    </el-col>
                </template>
            </el-row>
        </el-form>
    </v-dialog>
</template>
<script>
export default {
    props: {
        /**
         * 按钮文本
         * @type {String}
         * @default '添加'
         */
        button: {
            type: String,
            default: '添加'
        },
        /**
         * 头部标题
         * @type {String}
         * @default '添加信息'
         */
        header: {
            type: String,
            default: '添加信息'
        },
        /**
         * 确认按钮文本
         * @type {String}
         * @default '提交保存'
         */
        confirm: {
            type: String,
            default: '提交保存'
        },
        /**
         * 选项数组
         * @type {Array}
         * @default []
         */
        options: {
            type: Array,
            default: () => []
        },
        /**
         * 请求地址
         * @type {String}
         * @default ''
         */
        action: {
            type: String,
            default: ''
        },
        /**
         * 请求方法
         * @type {String}
         * @default 'post'
         */
        method: {
            type: String,
            default: 'post'
        },
        /**
         * 成功消息
         * @type {String}
         * @default '信息提交成功'
         */
        success: {
            type: String,
            default: '信息提交成功'
        }
    },
    emits: ['saved'],
    data() {
        return {
            saving: false,
            rules: {},
            form: {},
            extra: {},
            editor: {},
            buttonText: this.button,
            headerText: this.header,
            confirmText: this.confirm,
            successText: this.success,
            actionUrl: this.action,
            actionMethod: this.method,
            optionList: this.options,
            option: {},
            itemData: this.item,
            items: {},
            builded: false
        }
    },
    created() {
        this.$nextTick(() => {
        })
    },
    watch: {
        button(val) {
            this.buttonText = val
        },
        header(val) {
            this.headerText = val
        },
        confirm(val) {
            this.confirmText = val
        },
        success(val) {
            this.successText = val
        },
        action(val) {
            this.actionUrl = val
        },
        method(val) {
            this.actionMethod = val
        },
        options: {
            handler(val) {
                this.optionList = val
            },
            deep: true
        },
        item: {
            handler(val) {
                this.itemData = val
            },
            deep: true
        }
    },
    methods: {
        convertOptions() {
            this.builded = false
            this.rules = {}
            this.form = {}
            this.extra = {}
            this.option = {}
            this.editor = {}
            this.items = []
            this.optionList.forEach((n, index) => {
                if (n.rules) {
                    this.rules[n.key] = n.rules
                }
                if (n.extra) {
                    this.extra[n.key] = n.extra
                }
                if (n.option) {
                    this.option[n.key] = n.option
                }
                if (n.editor) {
                    this.editor[n.key] = n.editor
                }
                this.form[n.key] = typeof n.value != 'undefined' ? n.value : ''
                let item = {
                    key: n.key,
                    span: 24,
                    element: 'input',
                    type: '',
                    label: '',
                    placeholder: '',
                    startPlaceholder: '',
                    endPlaceholder: '',
                    editable: false,
                    clearable: false,
                    filterable: false,
                    preview: '',
                    maxlength: 200,
                    min: 0,
                    max: 10000,
                    limit: 1,
                    multiple: false,
                    disabled: false,
                    readonly: false,
                    tabindex: index + 1,
                    prefix: null,
                    suffix: null,
                    step: 1,
                    name: '',
                    activeText: '是',
                    activeValue: 1,
                    inactiveText: '否',
                    inactiveValue: 0,
                    separator: '-',
                    format: 'YYYY-MM-DD',
                    predefine: this.$config.defaultColors,
                    change: () => { }
                }
                Object.keys(item).forEach(x => {
                    if (n[x]) {
                        item[x] = n[x]
                    }
                })
                this.items.push(item)
            })
            this.builded = true
            this.$nextTick(() => {

                this.$refs.dialogFormRefForm.resetFields()
            })
        },
        onChange(KeyName, callback) {
            if (!this.$tool.isFunctionEmpty(callback)) {
                callback(
                    KeyName,
                    this.form,
                    this.option,
                    this.itemData
                );
            }
        },
        onSubmit(refName) {
            if (!this.saving) {
                this.saving = true
                this.$refs[refName + 'Form'].validate().then(async () => {
                    let form = this.form
                    if (this.actionMethod == 'post') {
                        form = new FormData()
                        Object.keys(this.form).forEach(key => {
                            if (this.form[key] !== undefined) {
                                form.append(key, this.form[key] ?? '')
                            }
                        })
                    }
                    let res = await this.$axios[this.actionMethod](this.actionUrl, form)
                    this.saving = false
                    if (res.code == this.$config.successCode) {
                        this.$message.success(this.successText)
                        this.$closeDialog(refName)
                        this.$emit('saved')
                    } else {
                        this.$message.error(res.message)
                    }
                }).catch(() => {
                    this.saving = false
                })
            }
        }
    }
}
</script>
<style lang="scss" scope>
@import '@scss/addons/dialog_form.scss';
</style>