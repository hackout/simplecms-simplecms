<template>
    <div class="SimpleCMS-aside">
        <Link :href="$route('backend.dashboard')" class="SimpleCMS-aside-header">
        <img src="/assets/logo_load.png" alt="SimpleCMS" />
        <span>SiMPlECMS</span>
        </Link>
        <el-scrollbar height="calc(100vh - 70px)" style="width:100%;">
            <div class="SimpleCMS-aside-menus">
                <div v-if="route_name === 'backend.dashboard'" class="SimpleCMS-aside-menus-item"
                    :class="{ active: route_name === 'backend.dashboard' }">
                    <div class="SimpleCMS-aside-menus-item-icon">
                        <SimpleCMSIconHome size="26px"></SimpleCMSIconHome>
                    </div>
                    <div class="SimpleCMS-aside-menus-item-text"><span>控制台首页</span></div>
                </div>
                <Link v-else :href="$route('backend.dashboard')" class="SimpleCMS-aside-menus-item">
                <div class="SimpleCMS-aside-menus-item-icon">
                    <SimpleCMSIconHome size="26px"></SimpleCMSIconHome>
                </div>
                <div class="SimpleCMS-aside-menus-item-text"><span>控制台首页</span></div>
                </Link>
                <template v-for="(menu, index) in menuItems" :key="index">
                    <div v-if="menu.component == 'div'" class="SimpleCMS-aside-menus-item" @click="toggleMenu(index)"
                        :class="{ active: menu.active, open: menu.open }">
                        <div class="SimpleCMS-aside-menus-item-icon">
                            <component :is="`SimpleCMS${menu.icon}`" size="26px"></component>
                        </div>
                        <div class="SimpleCMS-aside-menus-item-text"><span>{{ menu.name }}</span></div>
                        <div class="SimpleCMS-aside-menus-item-extra" v-if="menu.children && menu.children.length > 0">
                            <SimpleCMSIconChevronRight size="22px"></SimpleCMSIconChevronRight>
                        </div>
                    </div>
                    <Link v-else class="SimpleCMS-aside-menus-item" :class="{ active: menu.active }"
                        :href="$route(menu.url.name, menu.url.param)">
                    <div class="SimpleCMS-aside-menus-item-icon">
                        <component :is="`SimpleCMS${menu.icon}`" size="26px"></component>
                    </div>
                    <div class="SimpleCMS-aside-menus-item-text"><span>{{ menu.name }}</span></div>
                    </Link>
                    <AsideItem :menu="child" :show="menu.open" v-for="(child, index2) in menu.children"
                        :key="index + '-' + index2" :history="history ? history.child : null"> </AsideItem>

                </template>
            </div>
        </el-scrollbar>
    </div>
</template>

<script>
import AsideItem from './AsideItem.vue'
export default {
    components: {
        AsideItem
    },
    props: {
        historyMenu: {
            type: Object,
            default: {}
        },
        menus: {
            type: Array,
            default: []
        },
        routeName: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            route_name: '',
            history: {},
            menuList: []
        }
    },
    watch: {
        '$page.props.historyMenu': {
            handler(val) {
                this.history = val
                this.convertMenu()
            }
        },
        '$page.props.routeName': {
            handler(val) {
                this.route_name = val
            }
        },
        '$page.props.menus': {
            handler(val) {
                this.menuList = JSON.parse(JSON.stringify(val))
                this.convertMenu()
            },
            deep: true
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.route_name = this.$page.props.routeName
            this.menuList = JSON.parse(JSON.stringify(this.$page.props.menus))
            this.history = this.$page.props.historyMenu
            this.convertMenu()
        })
    },
    computed: {
        menuItems() {
            return this.menuList
        }
    },
    methods: {
        convertMenu() {
            this.menuList.forEach(menu => {
                let compare = this.$tool.compareJSON(menu ? menu.url : null, this.history ? this.history.url : null)
                let isChild = menu.children && menu.children.length > 0;
                menu.component = compare || isChild ? 'div' : 'Link'
                menu.active = compare
                menu.open = isChild && compare;
                menu.icon = menu.icon || 'IconCircle'
            })
        },
        toggleMenu(index) {
            this.menuList[index].open = !this.menuList[index].open
        }
    }
}
</script>

<style lang="scss">
@import '@scss/addons/aside.scss';
</style>