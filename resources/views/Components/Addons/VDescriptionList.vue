<template>
    <div class="SimpleCMS-description-list" :class="customClass">
        <div v-for="(item, index) in items" :key="item.key || index" class="SimpleCMS-description-item">
            <div class="SimpleCMS-description-label">{{ item.label }}</div>
            <div class="SimpleCMS-description-value">
                <slot :name="item.key" v-if="$slots[item.key]" :item="item"></slot>
                <template v-else>{{ item.value ?? '-' }}</template>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VDescriptionList',
    props: {
        items: {
            type: Array,
            default: () => []
        },
        customClass: {
            type: String,
            default: ''
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-description-list {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 14px 18px;
    .SimpleCMS-description-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding: 12px 14px;
        border: 1px solid #eef1f6;
        border-radius: 10px;
        background: #fafbff;
        min-height: 80px;
    }
    .SimpleCMS-description-label {
        color: #909399;
        font-size: 12px;
        line-height: 1.4;
    }
    .SimpleCMS-description-value {
        color: #303133;
        font-size: 14px;
        line-height: 1.6;
        word-break: break-word;
    }
}
</style>
