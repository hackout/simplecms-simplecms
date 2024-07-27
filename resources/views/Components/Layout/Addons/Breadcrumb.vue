<template>
    <div class="SimpleCMS-breadcrumb">
        <div class="SimpleCMS-breadcrumb-main">
            <h2>{{ pageTitle }}</h2>
            <el-divider v-if="breadcrumb && breadcrumb.length > 0" direction="vertical" />
            <el-breadcrumb v-if="breadcrumb && breadcrumb.length > 0" :separator-icon="iconComponent">
                <el-breadcrumb-item class="SimpleCMS-breadcrumb-main-link"
                    @click="$ajax.visit($route('backend.dashboard'))">
                    <SimpleCMSIconHome size="18px"></SimpleCMSIconHome>
                </el-breadcrumb-item>
                <el-breadcrumb-item :class="{ 'SimpleCMS-breadcrumb-main-link': index + 1 < breadcrumb.length }"
                    @click="index + 1 < breadcrumb.length ? $ajax.visit($route(item.url.name)) : $ajax.visit($route('backend.dashboard'))"
                    v-for="(item, index) in breadcrumb" :key="index">{{ item.name }}</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="SimpleCMS-breadcrumb-extra" v-if="showExtra">
            <slot v-if="$slots.default"></slot>
            <el-button v-else size="large" type="primary">
                <SimpleCMSIconSettings size="26px"></SimpleCMSIconSettings>
            </el-button>
        </div>
    </div>
</template>
<script>
import { IconChevronRight } from '@tabler/icons-vue'
export default {
    props: {
        historyMenu: {
            type: Object,
            default: {}
        },
        showExtra: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            history: this.historyMenu,
            pageTitle: 'SimpleCMS',
            iconComponent: IconChevronRight
        }
    },
    watch: {
        '$page.props.title': {
            handler(val) {
                this.pageTitle = val
            }
        },
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
            this.pageTitle = this.$page.props.title
        })
    },
    computed: {
        breadcrumb() {
            let breadcrumb = []
            if (this.history) {
                breadcrumb.push(this.convertMenu(this.history))
                if (this.history.child) {
                    breadcrumb.push(this.convertMenu(this.history.child))
                    if (this.history.child.child) {
                        breadcrumb.push(this.convertMenu(this.history.child.child))
                        if (this.history.child.child.child) {
                            breadcrumb.push(this.convertMenu(this.history.child.child.child))
                        }
                    }
                }
            }
            return breadcrumb

        },
    },
    methods: {
        convertMenu(menu) {
            return {
                name: menu.name,
                url: menu.url,
                icon: menu.icon
            }
        }
    }
}
</script>
<style lang="scss">
@import '@scss/addons/breadcrumb.scss';
</style>