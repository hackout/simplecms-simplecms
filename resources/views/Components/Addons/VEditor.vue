<template>
    <div class="SimpleCMS-editor">
        <div class="quill-editor">
            <div :id="`toolbar-${elementId}`">
                <template v-for="(opt, index) in options" :key="index">
                    <select v-if="opt === 'size'" class="ql-size">
                        <option value="small"></option>
                        <option selected></option>
                        <option value="large"></option>
                        <option value="huge"></option>
                    </select>
                    <button v-if="opt === 'bold'" class="ql-bold"></button>
                    <button v-if="opt === 'italic'" class="ql-italic"></button>
                    <button v-if="opt === 'underline'" class="ql-underline"></button>
                    <button v-if="opt === 'sub'" class="ql-script" value="sub"></button>
                    <button v-if="opt === 'super'" class="ql-script" value="super"></button>
                    <button v-if="opt === 'link'" class="ql-link"></button>
                    <button v-if="opt === 'image'" class="ql-image"></button>
                    <button v-if="opt === 'blockquote'" class="ql-blockquote"></button>
                    <button v-if="opt === 'video'" class="ql-video"></button>
                    <button v-if="opt === 'code-block'" class="ql-code-block"></button>
                    <button v-if="opt === 'formula'" class="ql-formula"></button>
                    <button v-if="opt === 'clean'" class="ql-clean"></button>
                    <button v-if="opt === 'ordered'" class="ql-list" value="ordered"></button>
                    <button v-if="opt === 'bullet'" class="ql-list" value="bullet"></button>
                    <button v-if="opt === 'check'" class="ql-list" value="check"></button>
                    <select v-if="opt === 'header'" class="ql-header">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"></option>
                        <option value="5"></option>
                        <option value="6"></option>
                        <option selected></option>
                    </select>
                    <button v-if="opt === 'indent-out'" class="ql-indent" value="-1"></button>
                    <button v-if="opt === 'indent-in'" class="ql-indent" value="+1"></button>
                    <select v-if="opt === 'color'" class="ql-color">
                        <option :value="color" v-for="(color, index2) in $config.defaultColors" :key="index2"></option>
                    </select>
                    <select v-if="opt === 'background'" class="ql-background">
                        <option :value="color" v-for="(color, index2) in $config.defaultColors" :key="index2"></option>
                    </select>
                    <button v-if="opt === 'strike'" class="ql-strike"></button>
                    <select v-if="opt === 'font'" class="ql-font">
                        <option value="HarmonyOS"></option>
                        <option value="AdobeClean"></option>
                        <option value="Helvetica"></option>
                        <option value="PingFang-SC"></option>
                        <option value="Arial"></option>
                        <option value="serif"></option>
                        <option value="monospace"></option>
                        <option value="SimSun"></option>
                        <option value="SimHei"></option>
                        <option value="Microsoft-YaHei"></option>
                        <option value="KaiTi"></option>
                        <option value="FangSong"></option>
                    </select>
                    <select v-if="opt === 'align'" class="ql-align">
                        <option value="justify"></option>
                        <option value="right"></option>
                        <option value="center"></option>
                        <option selected></option>
                    </select>
                    <button v-if="opt === 'ai'" class="SimpleCMS-editor-custom-button" style="width:auto" @click="aiButton"><span>AI</span></button>
                </template>
            </div>
            <div ref="editor"></div>
        </div>
    </div>
</template>

<script>
import _Quill from 'quill'
const Quill = window.Quill || _Quill
export default {
    name: 'VEditor',
    props: {
        modelValue: {
            type: String,
            default: null
        },
        placeholder: {
            type: String,
            default: null
        },
        readonly: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        },
        toolbar: {
            type: Array,
            default: [
                'size',
                'header',
                'bold',
                'italic',
                'underline',
                'strike',
                'blockquote',
                'code-block',
                'link',
                'image',
                'video',
                'formula',
                'font',
                'align',
                'sub',
                'super',
                'ordered',
                'bullet',
                'check',
                'indent-in',
                'indent-out',
                'color',
                'background',
                'ai',
                'clean',
            ]
        }
    },
    mounted() {
        this.initialize()
    },
    beforeDestroy() {
        this.quill = null
        delete this.quill
    },
    emits: ['blur', 'focus', 'input', 'change', 'ready', 'update:modelValue'],
    data() {
        return {
            editorOption: {
                boundary: document.body,
                placeholder: this.placeholder,
                readOnly: this.readonly,
                theme: 'snow',
                modules: {
                    toolbar: `#toolbar-${this.elementId}`,
                },
            },
            elementId: (new Date).getTime() + '-' + (Math.floor(Math.random() * 1000) + 1),
            quill: null,
            options: this.toolbar,
            editor: {},
        }
    },
    watch: {
        placeholder(val) {
            this.editorOption.placeholder = val
        },
        readonly(val) {
            this.editorOption.readOnly = val
        },
        toolbar: {
            handler(val) {
                this.options = val
            },
            deep: true
        },
        modelValue(newVal) {
            if (this.quill) {
                if (newVal) {
                    this.editContent = newVal
                    this.quill.root.innerHTML = newVal
                } else if (!newVal) {
                    this.quill.setText('')
                }
            }
        },
        disabled(newVal) {
            if (this.quill) {
                this.quill.enable(!newVal)
            }
        }
    },
    computed: {
        editContent: {
            get() {
                return this.modelValue
            },
            set(val) {
                this.$emit('update:modelValue', val)
            }
        }
    },
    methods: {
        initialize() {
            this.editorOption.modules.toolbar = `#toolbar-${this.elementId}` 
            if (this.$el) {
                this.quill = new Quill(this.$refs.editor, this.editorOption)
                this.quill.enable(false)
                if (this.editContent) {
                    this.quill.root.innerHTML = this.editContent
                }
                if (!this.disabled) {
                    this.quill.enable(true)
                }
                this.quill.on('selection-change', range => {
                    if (!range) {
                        this.$emit('blur', this.quill)
                    } else {
                        this.$emit('focus', this.quill)
                    }
                })
                this.quill.on('text-change', (delta, oldDelta, source) => {
                    this.$emit('text-change', this._content, delta, source)
                    this.$emit('input', this.output !== 'delta' ? this.quill.root.innerHTML : this.quill.getContents())
                    const html = this.quill.root.innerHTML
                    const text = this.quill.getText()
                    this.$emit('change', { html, text, quill: this.quill })
                })
                this.$emit('ready', this.quill)
            }
        },
        aiButton() {
            this.$message.error('AI助手接入中')
        }
    }
}
</script>

<style lang="scss">
@import '@scss/addons/editor.scss';
</style>