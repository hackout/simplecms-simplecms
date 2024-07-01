<template>
    <el-drawer v-model="visit" class="SimpleCMS-tableDrawer" size="950px" :title="drawerTitle"
        @closed="$emit('closed')">
        <VTable :action="queryAction" :round="false" @change="$emit('change',$event)" :params="queryParam" ref="tableRef" @search="$emit('search')"
            @selection-change="$emit('selection-change', $event)">
            <template #header_left>
                <slot name="header_left"></slot>
            </template>
            <template #header_right>
                <slot name="header_right"></slot>
            </template>
            <slot></slot>
        </VTable>
    </el-drawer>
</template>
<script>

export default {
    props: {
        title: {
            type: String,
            default: null
        },
        data: {
            type: Array,
            default: []
        },
        params: {
            type: Object,
            default: {}
        },
        action: {
            type: String,
            default: null
        },
        width: {
            type: String,
            default: '65vw'
        }
    },
    emits: ['closed', 'search', 'selection-change','change'],
    data() {
        return {
            drawerTitle: this.title,
            drawerSize: this.width,
            visit: false,
            queryParam: this.params,
            queryAction: this.action,
        }
    },
    watch: {
        title(val) {
            this.drawerTitle = val
        },
        width(val) {
            this.drawerSize = val
        },
        action(val) {
            this.queryAction = val
        },
        params: {
            handler(val) {
                this.queryParam = val
            },
            deep: true
        }
    },
    created() {
        this.$nextTick(() => {

        })
    },
    methods: {
        open() {
            this.visit = true
        },
        refreshData() {
            this.$nextTick(() => {
                this.$refs.tableRef.refreshData()
            })
        }
    }
}
</script>
<style lang="scss">
@import '@scss/addons/table_drawer.scss';
</style>