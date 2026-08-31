<template>
    <div class="SimpleCMS-form-page">
        <slot name="header">
            <VPageHeader :title="title" :subtitle="subtitle" :icon="icon">
                <template #actions>
                    <slot name="header-actions"></slot>
                </template>
            </VPageHeader>
        </slot>

        <VPagePanel :title="panelTitle" :no-padding="noPadding">
            <template #actions>
                <slot name="panel-actions"></slot>
            </template>
            <div class="SimpleCMS-form-page-body">
                <slot></slot>
            </div>
            <div v-if="$slots.footer" class="SimpleCMS-form-page-footer">
                <slot name="footer"></slot>
            </div>
        </VPagePanel>
    </div>
</template>

<script>
export default {
    name: 'VFormPage',
    props: {
        title: {
            type: String,
            default: '表单页'
        },
        subtitle: {
            type: String,
            default: ''
        },
        icon: {
            type: String,
            default: ''
        },
        panelTitle: {
            type: String,
            default: '编辑信息'
        },
        noPadding: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-form-page {
    width: 100%;
    box-sizing: border-box;
    .SimpleCMS-form-page-body {
        width: 100%;
    }
    .SimpleCMS-form-page-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 20px;
        margin-top: 20px;
        border-top: 1px solid #f0f2f5;
    }
}
</style>
