<template>
    <span class="SimpleCMS-badge" :class="['type-' + type, { 'is-dot': dot, 'is-pill': pill }]">
        <slot>{{ text }}</slot>
    </span>
</template>

<script>
export default {
    name: 'VBadge',
    props: {
        text: {
            type: String,
            default: ''
        },
        type: {
            type: String,
            default: 'primary'
        },
        dot: {
            type: Boolean,
            default: false
        },
        pill: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 22px;
    padding: 0 8px;
    border-radius: 999px;
    font-size: 12px;
    line-height: 1;
    font-weight: 600;
    color: #fff;
    background: #409eff;
    &.is-dot {
        width: 10px;
        height: 10px;
        min-height: 10px;
        padding: 0;
        border-radius: 50%;
    }
    &.is-pill {
        border-radius: 999px;
    }
    &.type-success { background: #67c23a; }
    &.type-warning { background: #e6a23c; }
    &.type-danger { background: #f56c6c; }
    &.type-info { background: #909399; }
    &.type-primary { background: #409eff; }
    &.type-secondary { background: #6c757d; }
}
</style>
