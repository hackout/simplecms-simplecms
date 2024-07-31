<template>
    <div class="SimpleCMS-StringCard">
        <div class="SimpleCMS-StringCard-content">
            <span :title="text">{{ text }}</span>
            <span>{{ name }}</span>
        </div>
        <div class="SimpleCMS-StringCard-extra" :class="type">
            <component :is="`SimpleCMS${icon}`" size="28px"></component>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VStringCard',
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
@import '@scss/addons/string_card.scss';
</style>