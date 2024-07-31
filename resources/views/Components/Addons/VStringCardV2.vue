<template>
    <div class="SimpleCMS-StringCardV2">
        <div class="SimpleCMS-StringCardV2-extra" :class="type">
            <component :is="`SimpleCMS${icon}`" size="28px"></component>
        </div>
        <div class="SimpleCMS-StringCardV2-content">
            <span :title="text">{{ text }}</span>
            <span>{{ name }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VStringCardV2',
    props: {
        name: {
            type: String,
            default: ''
        },
        text: {
            type: [String,Number],
            default: ''
        },
        icon: {
            type: String,
            default: ''
        },
        type: {
            type: String,
            default: ''
        }
    }
}
</script>

<style lang="scss" scoped>
@import '@scss/addons/string_card_v2.scss';
</style>