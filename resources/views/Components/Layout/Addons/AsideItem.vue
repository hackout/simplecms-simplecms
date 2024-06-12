<template>
    <component :is="menuItem.component" v-if="visible" class="SimpleCMS-aside-menus-item"
        :class="{ active: menuItem.active, open: menuItem.open }"
        :href="!menuItem.active ? $route(menuItem.url.name, menuItem.url.param) : ''">
        <div class="SimpleCMS-aside-menus-item-icon">
            <component :is="`SimpleCMS${menuItem.icon}`" size="20px"></component>
        </div>
        <div class="SimpleCMS-aside-menus-item-text"><span>{{ menuItem.name }}</span></div>
    </component>

</template>

<script>
export default {
    name: 'AsideItem',
    props: {
        history: {
            type: Object,
            default: {}
        },
        menu: {
            type: Object,
            default: []
        },
        show: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            historyMenu: this.history,
            menuItem: this.menu,
            visible: this.show
        }
    },
    watch: {
        show(val){
            this.visible = val
        },
        'menu': {
            handler(val) {
                this.menuItem = val
                this.convertMenu()
            },
            deep: true
        },
        'history': {
            handler(val) {
                this.historyMenu = val
                this.convertMenu()
            },
            deep: true
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.convertMenu()
        })
    },
    methods: {
        convertMenu() {

            let compare = this.$tool.compareJSON(this.menuItem ? this.menuItem.url : null, this.historyMenu ? this.historyMenu.url : null)
            this.menuItem.component = compare ? 'div' : 'Link'
            this.menuItem.active = compare
            this.menuItem.open = this.menuItem.children && this.menuItem.children.length > 0 && compare;
        }
    }
}
</script>

<style lang="scss">

</style>