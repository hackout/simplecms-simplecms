<template>
    <div class="SimpleCMS-page-panel" :class="[{ 'is-no-padding': noPadding }, customClass]">
        <div class="SimpleCMS-page-panel-header" v-if="title || $slots.header || $slots.actions">
            <div class="SimpleCMS-page-panel-title-wrap">
                <span v-if="title" class="SimpleCMS-page-panel-title">{{ title }}</span>
                <slot name="header"></slot>
            </div>
            <div v-if="$slots.actions" class="SimpleCMS-page-panel-actions">
                <slot name="actions"></slot>
            </div>
        </div>
        <div class="SimpleCMS-page-panel-body">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VPagePanel',
    props: {
        title: {
            type: String,
            default: ''
        },
        noPadding: {
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
.SimpleCMS-page-panel {
    width: 100%;
    background: #fff;
    border: 1px solid #ebeef5;
    border-radius: 14px;
    overflow: hidden;
    box-sizing: border-box;
    &.is-no-padding {
        .SimpleCMS-page-panel-body {
            padding: 0;
        }
    }
    .SimpleCMS-page-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 20px;
        border-bottom: 1px solid #f0f2f5;
        background: linear-gradient(180deg, #ffffff 0%, #fbfcff 100%);
    }
    .SimpleCMS-page-panel-title-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
        flex: 1;
    }
    .SimpleCMS-page-panel-title {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }
    .SimpleCMS-page-panel-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .SimpleCMS-page-panel-body {
        padding: 20px;
        box-sizing: border-box;
    }
}
</style>
