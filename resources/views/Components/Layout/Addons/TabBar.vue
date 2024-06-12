<template>
    <div class="simpleCMS-tabBar">
        
    </div>
</template>
<script>
export default {
    props: {
        historyMenu: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            history: this.historyMenu
        }
    },
    watch: {
        '$page.props.historyMenu': {
            handler(val) {
                this.history = val
            },
            deep: true
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.history = this.$page.props.historyMenu
        })
    },
    methods: {
        
    }
}
</script>
<style lang="scss">
@import '@scss/addons/tab_bar.scss';
</style>