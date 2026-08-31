<template>
    <div class="SimpleCMS-action-bar" :class="[{ 'is-compact': compact }, customClass]">
        <div class="SimpleCMS-action-bar-main">
            <slot name="left">
                <div v-if="title" class="SimpleCMS-action-bar-title">{{ title }}</div>
            </slot>
        </div>
        <div class="SimpleCMS-action-bar-actions">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VActionBar',
    props: {
        title: {
            type: String,
            default: ''
        },
        compact: {
            type: Boolean,
            default: false
        },
        customClass: {
            type: String,
            default: ''
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-action-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1px solid #ebeef5;
    background: #fff;
    box-sizing: border-box;
    &.is-compact {
        padding: 8px 12px;
    }
    .SimpleCMS-action-bar-main {
        min-width: 0;
        flex: 1;
    }
    .SimpleCMS-action-bar-title {
        font-size: 16px;
        font-weight: 600;
        line-height: 1.5;
        color: #303133;
    }
    .SimpleCMS-action-bar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
}
</style>
