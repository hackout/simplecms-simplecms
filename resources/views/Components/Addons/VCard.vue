<template>
    <div class="SimpleCMS-card" :class="[{ 'is-shadow': shadow, 'is-borderless': !bordered }, customClass]">
        <div class="SimpleCMS-card-header" v-if="$slots.header || title">
            <slot name="header">
                <div class="SimpleCMS-card-header-title">{{ title }}</div>
            </slot>
        </div>
        <div class="SimpleCMS-card-body" :style="bodyStyle">
            <slot></slot>
        </div>
        <div class="SimpleCMS-card-footer" v-if="$slots.footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VCard',
    props: {
        title: {
            type: String,
            default: ''
        },
        shadow: {
            type: Boolean,
            default: true
        },
        bordered: {
            type: Boolean,
            default: true
        },
        customClass: {
            type: String,
            default: ''
        },
        bodyStyle: {
            type: [Object, String],
            default: null
        }
    }
}
</script>

<style lang="scss">
@import '@scss/addons/card.scss';
</style>