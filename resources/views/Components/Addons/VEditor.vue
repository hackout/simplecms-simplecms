<template>
    <div class="SimpleCMS-editor">
        <div class="quill-editor">
            <div :id="`toolbar-${elementId}`">
                <template v-for="(opt, index) in options" :key="index">
                    <select class="ql-size" v-if="opt == 'size'">
                        <option value="small"></option>
                        <option selected></option>
                        <option value="large"></option>
                        <option value="huge"></option>
                    </select>
                    <button class="ql-bold" v-if="opt == 'bold'"></button>
                    <button class="ql-italic" v-if="opt == 'italic'"></button>
                    <button class="ql-underline" v-if="opt == 'underline'"></button>
                    <button class="ql-script" value="sub" v-if="opt == 'sub'"></button>
                    <button class="ql-script" value="super" v-if="opt == 'super'"></button>
                    <button class="ql-link" v-if="opt == 'link'"></button>
                    <button class="ql-image" v-if="opt == 'image'"></button>
                    <button class="ql-blockquote" v-if="opt == 'blockquote'"></button>
                    <button class="ql-video" v-if="opt == 'video'"></button>
                    <button class="ql-code-block" v-if="opt == 'code-block'"></button>
                    <button class="ql-formula" v-if="opt == 'formula'"></button>
                    <button class="ql-clean" v-if="opt == 'clean'"></button>
                    <button class="ql-list" value="ordered" v-if="opt == 'ordered'"></button>
                    <button class="ql-list" value="bullet" v-if="opt == 'bullet'"></button>
                    <button class="ql-list" value="check" v-if="opt == 'check'"></button>
                    <select class="ql-header" v-if="opt == 'header'">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"></option>
                        <option value="5"></option>
                        <option value="6"></option>
                        <option selected></option>
                    </select>
                    <button class="ql-indent" value="-1" v-if="opt == 'indent-out'"></button>
                    <button class="ql-indent" value="+1" v-if="opt == 'indent-in'"></button>
                    <select class="ql-color" v-if="opt == 'color'">
                        <option :value="color" v-for="(color, index2) in $config.defaultColors" :key="index2"></option>
                    </select>
                    <select class="ql-background" v-if="opt == 'background'">
                        <option :value="color" v-for="(color, index2) in $config.defaultColors" :key="index2"></option>
                    </select>
                    <button class="ql-strike" v-if="opt == 'strike'"></button>
                    <select class="ql-font" v-if="opt == 'font'">
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
                    <select class="ql-align" v-if="opt == 'align'">
                        <option value="justify"></option>
                        <option value="right"></option>
                        <option value="center"></option>
                        <option selected></option>
                    </select>
                    <button class="SimpleCMS-editor-custom-button" style="width:auto" @click="aiButton"
                        v-if="opt == 'ai'"><span>AI</span></button>
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
                    toolbar: '#toolbar',
                },
            },
            elementId: (new Date).getTime() + '-' + (Math.floor(Math.random() * 1000) + 1),
            quill: null,
            options: this.toolbar
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
                if (newVal && newVal !== this.editContent) {
                    this.editContent = newVal
                    this.quill.pasteHTML(newVal)
                } else if (!newVal) {
                    this.quill.setText('')
                }
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
        },
        disabled(newVal) {
            if (this.quill) {
                this.quill.enable(!newVal)
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
                    this.quill.pasteHTML(this.editContent)
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
                    let html = this.$refs.editor.children[0].innerHTML
                    const quill = this.quill
                    const text = this.quill.getText()
                    if (html === '<p><br></p>') html = ''
                    this.editContent = html
                    this.$emit('input', this._content)
                    this.$emit('change', { html, text, quill })
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