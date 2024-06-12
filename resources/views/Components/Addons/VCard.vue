<template>
    <div class="SimpleCMS-card">
        <div class="SimpleCMS-card-header" v-if="$slots.header">
            <slot name="header"></slot>
        </div>
        <div class="SimpleCMS-card-body">
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
        
    },
    data() {
        return {
            route_name: '',
            menuList: []
        }
    },
    watch: {
        
    },
    mounted() {
        this.$nextTick(() => {
        })
    },
    methods: {
    }
}
</script>

<style lang="scss">
@import '@scss/addons/card.scss';
</style>