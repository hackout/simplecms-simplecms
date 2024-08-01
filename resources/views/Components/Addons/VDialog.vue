<template>
    <div class="SimpleCMS-dialog" style="height:auto;">
        <div class="SimpleCMS-dialog-button" ref="dialogButtonRef" @click="openDialog">
            <slot name="button"></slot>
        </div>
        <div v-if="dialogAppend" ref="dialogOverlayRef" v-show="showOverlay" @click.stop="closeDialog"
            class="SimpleCMS-dialog-overlay"></div>
        <div class="SimpleCMS-dialog-box" v-if="dialogAppend" v-show="showVisit" :class="offsetClass" ref="dialogBoxRef"
            :style="dialogStyle">
            <div class="SimpleCMS-dialog-header">
                <span>{{ title }}</span>
                <div class="SimpleCMS-dialog-header-close" @click="closeDialog">
                    <SimpleCMSIconX size="24px"></SimpleCMSIconX>
                </div>
            </div>
            <div class="SimpleCMS-dialog-body">
                <slot v-if="$slots.default"></slot>
                <template v-else>
                    <span v-if="textContent">{{ textContent }}</span>
                </template>
            </div>
            <div class="SimpleCMS-dialog-footer">
                <slot v-if="$slots.footer" name="footer"></slot>
                <template v-else>
                    <div class="SimpleCMS-dialog-footer-buttons" v-if="dialogType === 'confirm' || dialogType === ''">
                        <el-button @click="cancelDialog" class="el-button--dark">{{ cancelText
                            }}</el-button>
                        <el-button @click="confirmDialog" :loading="saving" type="primary">{{ confirmText
                            }}</el-button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
import {
    useZIndex
} from 'element-plus'

const { nextZIndex } = useZIndex()
export default {
    name: 'VDialog',
    props: {
        overlay: {
            type: Boolean,
            default: true
        },
        visible: {
            type: Boolean,
            default: false
        },
        width: {
            type: Number,
            default: 500
        },
        header: {
            type: String,
            default: null
        },
        content: {
            type: String,
            default: null
        },
        type: {
            type: String,
            default: ''
        },
        appendToBody: {
            type: Boolean,
            default: true
        },
        confirmText: {
            type: String,
            default: '确定'
        },
        cancelText: {
            type: String,
            default: '取消'
        },
        onConfirm: {
            type: Function,
            default: () => {

            }
        },
        name: {
            type: String,
            default: null
        },
        loading: {
            type: Boolean,
            default: null
        }
    },
    emits: ['show', 'close', 'confirm', 'cancel', 'update:modelValue'],
    data() {
        return {
            showOverlay: false,
            showVisit: false,
            dialogStyle: `--cms-dialog-width: ${this.width}px;--cms-dialog-top: 50%;--cms-dialog-left: 50%;--cms-dialog-top-start: 0px;--cms-dialog-left-start: 0px;`,
            title: this.header,
            textContent: this.content,
            dialogType: this.type,
            offsetClass: '',
            dialogAppend: this.appendToBody,
            saving: this.loading,
            added: false
        }
    },
    watch: {
        loading(val) {
            this.saving = val
        },
        appendToBody(val) {
            this.dialogAppend = val
        },
        type(val) {
            this.dialogType = val
        },
        content(val) {
            this.textContent = val
        },
        header(val) {
            this.title = val
        },
        width() {
            this.convertStyle()
        }
    },
    computed: {
    },
    mounted() {
        this.$nextTick(() => {
            this.convertStyle()
        })
    },
    beforeUnmount() {
        if (this.dialogAppend) {
            this.$refs.dialogOverlayRef && this.$refs.dialogOverlayRef.remove();
            this.$refs.dialogBoxRef && this.$refs.dialogBoxRef.remove();
        }
    },
    methods: {
        addDialog() {
            if (!this.added) {
                if (this.dialogAppend) {
                    document.body.appendChild(this.$refs.dialogOverlayRef);
                    document.body.appendChild(this.$refs.dialogBoxRef);
                    this.added = true
                }
            }
        },
        autoIndex() {
            return document.querySelectorAll('.SimpleCMS-dialog-box').length
        },
        convertStyle() {
            const element = this.$refs.dialogButtonRef
            const rect = element.getBoundingClientRect();
            const elementBody = this.$refs.dialogBoxRef
            const rect1 = elementBody.getBoundingClientRect();
            let height = rect1.height;
            if (height > 0) {
                let zIndex = nextZIndex()
                this.offsetClass = `--cms-dialog-z-index:${zIndex};`
                this.dialogStyle = `--cms-dialog-z-index:${zIndex};--cms-dialog-width: ${this.width}px;--cms-dialog-top: ${height / 2}px;--cms-dialog-left: ${this.width / 2}px;--cms-dialog-top-start: ${rect.y}px;--cms-dialog-left-start: ${rect.x}px;`
            }
        },
        openDialog() {
            if (!this.saving) {
                this.addDialog()
                this.showVisit = true
                if (this.overlay) {
                    this.showOverlay = true
                }
                this.$nextTick(() => {
                    this.convertStyle()
                    this.showVisit = false
                    setTimeout(() => {
                        this.showVisit = true
                        this.offsetClass = 'animation'
                    }, 100)
                })
                this.$emit('show')
            }
        },
        closeDialog() {
            if (!this.saving) {
                this.showVisit = false
                this.showOverlay = false
                this.$emit('close')
            }
        },
        cancelDialog() {
            if (!this.saving) {
                this.$emit('cancel');
                this.closeDialog()
            }
        },
        confirmDialog() {
            if (!this.saving) {
                if (!this.$tool.isFunctionEmpty(this.onConfirm)) {
                    this.onConfirm(this.name);
                } else {
                    this.$emit('confirm');
                    this.closeDialog()
                }
            }
        }
    }
}
</script>
<style lang="scss">
@import '@scss/addons/dialog.scss';
</style>