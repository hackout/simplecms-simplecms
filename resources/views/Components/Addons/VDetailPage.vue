<template>
    <div class="SimpleCMS-detail-page">
        <slot name="header">
            <VPageHeader :title="title" :subtitle="subtitle" :icon="icon">
                <template #actions>
                    <slot name="header-actions"></slot>
                </template>
            </VPageHeader>
        </slot>

        <div class="SimpleCMS-detail-page-body">
            <VPagePanel :title="overviewTitle" v-if="showOverview">
                <template #actions>
                    <slot name="overview-actions"></slot>
                </template>
                <slot name="overview"></slot>
            </VPagePanel>

            <div class="SimpleCMS-detail-page-main">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VDetailPage',
    props: {
        title: {
            type: String,
            default: '详情页'
        },
        subtitle: {
            type: String,
            default: ''
        },
        icon: {
            type: String,
            default: ''
        },
        overviewTitle: {
            type: String,
            default: '基本信息'
        },
        showOverview: {
            type: Boolean,
            default: true
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-detail-page {
    width: 100%;
    box-sizing: border-box;
    .SimpleCMS-detail-page-body {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .SimpleCMS-detail-page-main {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
}
</style>
