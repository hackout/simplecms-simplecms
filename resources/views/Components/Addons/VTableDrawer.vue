<template>
    <el-drawer v-model="visit" class="SimpleCMS-tableDrawer" :size="drawerSize" :title="drawerTitle"
        @closed="handleClosed">
        <VTable :action="queryAction" :round="false" @change="$emit('change', $event)" :params="queryParam"
            ref="tableRef" @search="$emit('search')" @selection-change="$emit('selection-change', $event)">
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
        modelValue: {
            type: Boolean,
            default: false
        },
        title: {
            type: String,
            default: null
        },
        data: {
            type: Array,
            default: () => []
        },
        params: {
            type: Object,
            default: () => ({})
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
    emits: ['closed', 'search', 'selection-change', 'change', 'update:modelValue'],
    data() {
        return {
            drawerTitle: this.title,
            drawerSize: this.width,
            visit: !!this.modelValue,
            queryParam: this.params,
            queryAction: this.action,
        }
    },
    watch: {
        modelValue(val) {
            this.visit = !!val
        },
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
                this.queryParam = val || {}
            },
            deep: true
        }
    },
    methods: {
        open() {
            this.visit = true
            this.$emit('update:modelValue', true)
        },
        close() {
            this.visit = false
            this.$emit('update:modelValue', false)
        },
        handleClosed() {
            this.$emit('closed')
            this.$emit('update:modelValue', false)
        },
        refreshData() {
            this.$nextTick(() => {
                if (this.$refs.tableRef && this.$refs.tableRef.refreshData) {
                    this.$refs.tableRef.refreshData()
                }
            })
        }
    }
}
</script>
<style lang="scss">
@import '@scss/addons/table_drawer.scss';
</style>