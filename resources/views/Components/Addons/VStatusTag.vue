<template>
    <span class="SimpleCMS-status-tag" :class="'type-' + resolvedType">
        <slot>{{ label }}</slot>
    </span>
</template>

<script>
export default {
    name: 'VStatusTag',
    props: {
        label: {
            type: String,
            default: ''
        },
        type: {
            type: [String, Number, Boolean],
            default: 'info'
        },
        trueText: {
            type: String,
            default: '启用'
        },
        falseText: {
            type: String,
            default: '禁用'
        }
    },
    computed: {
        resolvedType() {
            if (typeof this.type === 'boolean') {
                return this.type ? 'success' : 'danger'
            }
            if (this.type === 1 || this.type === '1' || this.type === 'success' || this.type === 'enabled') {
                return 'success'
            }
            if (this.type === 0 || this.type === '0' || this.type === 'danger' || this.type === 'disabled') {
                return 'danger'
            }
            if (this.type === 'warning' || this.type === 'pending') {
                return 'warning'
            }
            if (this.type === 'info') {
                return 'info'
            }
            return String(this.type)
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-status-tag {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 52px;
    height: 24px;
    padding: 0 8px;
    border-radius: 999px;
    font-size: 12px;
    line-height: 22px;
    font-weight: 600;
    color: #fff;
    background: #909399;

    &.type-success { background: #67c23a; }
    &.type-warning { background: #e6a23c; }
    &.type-danger { background: #f56c6c; }
    &.type-info { background: #909399; }
    &.type-primary { background: #409eff; }
}
</style>
