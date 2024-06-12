<template>
    <div class="simpleCMS-layout">

        <Head :title="pageTitle" />
        <el-container>
            <el-aside width="260px">
                <Aside></Aside>
            </el-aside>
            <el-container>
                <el-container>
                    <el-header>
                        <Header></Header>
                    </el-header>
                    <el-main style="height:calc(100vh - 100px)">
                        <el-scrollbar class="main-scrollbar" height="calc(100vh - 100px)" style="width: 100%;">
                            <slot name="header" v-if="$slots.header"></slot>
                            <Breadcrumb v-if="!$slots.header && showBreadcrumb">
                                <slot name="extra"></slot>
                            </Breadcrumb>
                            <TabBar v-if="!$slots.header && showTabBar"></TabBar>
                            <slot></slot>
                            <el-backtop target=".main-scrollbar .el-scrollbar__wrap" :right="50" :bottom="50" />
                        </el-scrollbar>
                    </el-main>
                </el-container>
            </el-container>
        </el-container>
    </div>
</template>

<script>
import Footer from './Addons/Footer.vue'
import Header from './Addons/Header.vue'
import Aside from './Addons/Aside.vue'
import Breadcrumb from './Addons/Breadcrumb.vue'
import TabBar from './Addons/TabBar.vue'
export default {
    props: {
        title: {
            type: String,
            default: 'SimpleCMS'
        },
        breadcrumb: {
            type: Boolean,
            default: true
        },
        tabBar: {
            type: Boolean,
            default: false
        }
    },
    components: {
        Footer,
        Header,
        Breadcrumb,
        TabBar,
        Aside
    },
    watch: {
        '$page.props.flash': {
            handler() {
                this.showFlash()
            },
            deep: true
        },
        '$page.props.title': {
            handler(val) {
                this.pageTitle = val
            }
        },
        breadcrumb(val) {
            this.pageTitle = val
        },
        tabBar(val) {
            this.pageTitle = val
        }
    },
    data() {
        return {
            pageTitle: this.title,
            showBreadcrumb: this.breadcrumb,
            showTabBar: this.tabBar
        }
    },
    created() {
        this.$nextTick(() => {
            this.pageTitle = this.$page.props.title
        })
    },
    methods: {
        showFlash() {
            let errors = this.$page.props.errors
            if (errors) {
                let errorKeys = Object.keys(errors);
                if (errorKeys.length > 0) {
                    var name = errorKeys[0]
                    this.$message.error(errors[name])
                }
            }
            if (this.$page.props.error) {
                this.$message.error(this.$page.props.error)
            }
            if (this.$page.props.success) {
                this.$message.success(this.$page.props.success)
            }
        }
    }
}
</script>
<style lang="scss">
@import '@scss/common.scss';
@import '@scss/default.scss';
</style>