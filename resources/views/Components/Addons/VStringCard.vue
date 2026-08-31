<template>
    <div class="SimpleCMS-StringCard" :class="type" @click="$emit('click')">
        <div class="SimpleCMS-StringCard-content">
            <span :title="resolvedText">{{ resolvedText }}</span>
            <span>{{ resolvedName }}</span>
        </div>
        <div class="SimpleCMS-StringCard-extra" :class="type">
            <component v-if="icon" :is="`SimpleCMS${icon}`" size="28px"></component>
            <slot v-else name="icon"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VStringCard',
    props: {
        name: {
            type: [String, Number],
            default: ''
        },
        text: {
            type: [String, Number],
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
    },
    emits: ['click'],
    computed: {
        resolvedName() {
            return this.name ?? ''
        },
        resolvedText() {
            return this.text ?? ''
        }
    }
}
</script>

<style lang="scss" scoped>
@import '@scss/addons/string_card.scss';
</style>