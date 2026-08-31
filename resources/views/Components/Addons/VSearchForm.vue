<template>
    <el-form
        class="SimpleCMS-search-form"
        :model="model"
        :label-width="labelWidth"
        :inline="inline"
        :size="size"
        @submit.native.prevent="onSubmit"
    >
        <slot></slot>
        <div v-if="showActions || $slots.actions" class="SimpleCMS-search-form-actions">
            <slot name="actions">
                <el-button type="primary" @click="onSubmit">查询</el-button>
                <el-button @click="onReset">重置</el-button>
            </slot>
        </div>
    </el-form>
</template>

<script>
export default {
    name: 'VSearchForm',
    props: {
        model: {
            type: Object,
            default: () => ({})
        },
        inline: {
            type: Boolean,
            default: true
        },
        labelWidth: {
            type: String,
            default: '100px'
        },
        size: {
            type: String,
            default: 'default'
        },
        showActions: {
            type: Boolean,
            default: true
        }
    },
    emits: ['submit', 'reset'],
    methods: {
        onSubmit() {
            this.$emit('submit', this.model)
        },
        onReset() {
            this.$emit('reset')
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-search-form {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: flex-start;
    .SimpleCMS-search-form-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
        padding-left: 8px;
    }
}
</style>
