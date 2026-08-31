<template>
    <div class="SimpleCMS-stat-card" :class="[{ 'is-borderless': !bordered }, customClass]" @click="$emit('click')">
        <div class="SimpleCMS-stat-card-icon" :style="iconStyle" v-if="icon">
            <component :is="`SimpleCMS${icon}`" size="22px" />
        </div>
        <div class="SimpleCMS-stat-card-body">
            <div class="SimpleCMS-stat-card-label">{{ label }}</div>
            <div class="SimpleCMS-stat-card-value">{{ value }}</div>
            <div class="SimpleCMS-stat-card-meta" v-if="meta || trend !== null">
                <span v-if="trend !== null" :class="trend >= 0 ? 'up' : 'down'">
                    {{ trend >= 0 ? '+' : '' }}{{ trend }}%
                </span>
                <span>{{ meta }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VStatCard',
    props: {
        label: {
            type: String,
            default: '统计'
        },
        value: {
            type: [String, Number],
            default: 0
        },
        meta: {
            type: String,
            default: ''
        },
        trend: {
            type: Number,
            default: null
        },
        icon: {
            type: String,
            default: ''
        },
        iconColor: {
            type: String,
            default: '#409EFF'
        },
        bordered: {
            type: Boolean,
            default: true
        },
        customClass: {
            type: String,
            default: ''
        }
    },
    emits: ['click'],
    computed: {
        iconStyle() {
            return {
                background: `${this.iconColor}1A`,
                color: this.iconColor,
                borderColor: `${this.iconColor}33`
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-stat-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 18px 20px;
    background: #fff;
    border-radius: 12px;
    border: 1px solid #ebeef5;
    min-height: 120px;
    box-sizing: border-box;
    &.is-borderless { border: none; box-shadow: 0 8px 18px rgba(0,0,0,0.04); }
    .SimpleCMS-stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        flex-shrink: 0;
    }
    .SimpleCMS-stat-card-body {
        flex: 1;
        min-width: 0;
    }
    .SimpleCMS-stat-card-label {
        color: #909399;
        font-size: 12px;
        margin-bottom: 8px;
    }
    .SimpleCMS-stat-card-value {
        color: #303133;
        font-size: 28px;
        font-weight: 700;
        line-height: 1.2;
    }
    .SimpleCMS-stat-card-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
        font-size: 12px;
        color: #909399;
        .up { color: #67c23a; }
        .down { color: #f56c6c; }
    }
}
</style>
