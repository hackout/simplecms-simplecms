<template>
    <div class="SimpleCMS-crud-page">
        <slot name="header">
            <VPageHeader :title="title" :subtitle="subtitle" :icon="icon">
                <template #actions>
                    <slot name="header-actions"></slot>
                </template>
            </VPageHeader>
        </slot>

        <div class="SimpleCMS-crud-page-body">
            <slot name="filter">
                <VFilterBar v-if="showFilterBar">
                    <slot name="filter-content"></slot>
                    <template #actions>
                        <slot name="filter-actions"></slot>
                    </template>
                </VFilterBar>
            </slot>

            <VPagePanel :title="panelTitle" :no-padding="noPadding">
                <template #actions>
                    <slot name="panel-actions"></slot>
                </template>
                <slot></slot>
            </VPagePanel>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VCrudPage',
    props: {
        title: {
            type: String,
            default: '列表页'
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
            default: ''
        },
        showFilterBar: {
            type: Boolean,
            default: true
        },
        noPadding: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-crud-page {
    width: 100%;
    box-sizing: border-box;
    .SimpleCMS-crud-page-body {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
}
</style>
