<template>
    <div class="SimpleCMS-chart" :class="[{ 'is-full': full }, customClass]">
        <div class="SimpleCMS-chart-header" v-if="title || $slots.header">
            <slot name="header">
                <span>{{ title }}</span>
            </slot>
        </div>
        <div class="SimpleCMS-chart-body" :style="bodyStyle">
            <component :is="chartComponent" v-bind="chartProps" />
        </div>
    </div>
</template>

<script>
import { computed, defineComponent, h } from 'vue'

export default defineComponent({
    name: 'VChart',
    props: {
        title: {
            type: String,
            default: ''
        },
        full: {
            type: Boolean,
            default: false
        },
        customClass: {
            type: String,
            default: ''
        },
        bodyStyle: {
            type: [Object, String],
            default: null
        },
        type: {
            type: String,
            default: 'line'
        },
        options: {
            type: Object,
            default: () => ({})
        },
        series: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        chartComponent() {
            return this.type === 'bar' ? 'BarChart' : 'LineChart'
        },
        chartProps() {
            return {
                options: this.options,
                series: this.series
            }
        }
    },
    render() {
        const component = this.chartComponent
        if (component === 'BarChart') {
            return h('div', { class: 'SimpleCMS-chart-fallback' }, 'BarChart component not mounted in this demo build')
        }
        return h('div', { class: 'SimpleCMS-chart-fallback' }, 'LineChart component not mounted in this demo build')
    }
})
</script>

<style lang="scss" scoped>
.SimpleCMS-chart {
    display: block;
    width: 100%;
    background: #fff;
    border-radius: 12px;
    border: 1px solid #ebeef5;
    overflow: hidden;
    &.is-full { min-height: 240px; }
    .SimpleCMS-chart-header {
        padding: 14px 16px 0;
        font-size: 14px;
        font-weight: 600;
        color: #303133;
    }
    .SimpleCMS-chart-body {
        padding: 12px 16px 16px;
        min-height: 180px;
    }
    .SimpleCMS-chart-fallback {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 180px;
        color: #909399;
        background: linear-gradient(180deg, #fafafa 0%, #ffffff 100%);
    }
}
</style>
