<template>
    <div class="SimpleCMS-page-header">
        <div class="SimpleCMS-page-header-main">
            <div class="SimpleCMS-page-header-title-group">
                <div v-if="icon" class="SimpleCMS-page-header-icon">
                    <component :is="`SimpleCMS${icon}`" size="20px" />
                </div>
                <div>
                    <div class="SimpleCMS-page-header-title">{{ title }}</div>
                    <div v-if="subtitle" class="SimpleCMS-page-header-subtitle">{{ subtitle }}</div>
                </div>
            </div>
            <div v-if="$slots.actions" class="SimpleCMS-page-header-actions">
                <slot name="actions" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VPageHeader',
    props: {
        title: {
            type: String,
            default: '页面标题'
        },
        subtitle: {
            type: String,
            default: ''
        },
        icon: {
            type: String,
            default: ''
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-page-header {
    width: 100%;
    padding: 12px 0 20px;
    .SimpleCMS-page-header-main {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .SimpleCMS-page-header-title-group {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }
    .SimpleCMS-page-header-icon {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef5ff;
        border-radius: 10px;
        color: #409eff;
    }
    .SimpleCMS-page-header-title {
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
        line-height: 1.3;
    }
    .SimpleCMS-page-header-subtitle {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }
    .SimpleCMS-page-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
}
</style>
