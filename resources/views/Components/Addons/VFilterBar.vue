<template>
    <div class="SimpleCMS-filter-bar">
        <div class="SimpleCMS-filter-bar-main">
            <slot></slot>
        </div>
        <div v-if="$slots.actions" class="SimpleCMS-filter-bar-actions">
            <slot name="actions"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VFilterBar',
}
</script>

<style lang="scss" scoped>
.SimpleCMS-filter-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    padding: 12px 16px;
    background: #fff;
    border: 1px solid #ebeef5;
    border-radius: 12px;
    .SimpleCMS-filter-bar-main {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        flex: 1;
    }
    .SimpleCMS-filter-bar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
}
</style>
