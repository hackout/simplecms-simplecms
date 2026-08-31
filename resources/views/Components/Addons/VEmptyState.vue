<template>
    <div class="SimpleCMS-empty-state">
        <div class="SimpleCMS-empty-state-icon" v-if="icon">
            <component :is="`SimpleCMS${icon}`" size="42px" />
        </div>
        <div class="SimpleCMS-empty-state-title" v-if="title">{{ title }}</div>
        <div class="SimpleCMS-empty-state-description" v-if="description">{{ description }}</div>
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'VEmptyState',
    props: {
        icon: {
            type: String,
            default: ''
        },
        title: {
            type: String,
            default: '暂无数据'
        },
        description: {
            type: String,
            default: ''
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 180px;
    padding: 24px 16px;
    color: #606266;
    text-align: center;

    .SimpleCMS-empty-state-icon {
        color: #c0c4cc;
        margin-bottom: 12px;
    }

    .SimpleCMS-empty-state-title {
        font-size: 16px;
        color: #303133;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .SimpleCMS-empty-state-description {
        font-size: 13px;
        color: #909399;
    }
}
</style>
