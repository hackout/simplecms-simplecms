<template>
    <el-form-item
        class="SimpleCMS-form-item"
        :label="label"
        :prop="prop"
        :rules="rules"
        :required="required"
        :inline-message="inlineMessage"
    >
        <slot></slot>
    </el-form-item>
</template>

<script>
export default {
    name: 'VFormItem',
    props: {
        label: {
            type: String,
            default: ''
        },
        prop: {
            type: String,
            default: ''
        },
        rules: {
            type: Array,
            default: () => []
        },
        required: {
            type: Boolean,
            default: false
        },
        inlineMessage: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style lang="scss" scoped>
.SimpleCMS-form-item {
    min-width: 220px;
    margin-bottom: 18px;
}
</style>
