<template>
    <div class="SimpleCMS-layout">
        <Head :title="pageTitle" />
        <el-container>
            <el-main>
                <slot />
                <el-backtop :right="100" :bottom="100" />
            </el-main>
            <el-footer>
                <Footer />
            </el-footer>
        </el-container>
    </div>
</template>

<script>
import Footer from './Addons/Footer.vue'

export default {
    props: {
        title: {
            type: String,
            default: 'SimpleCMS'
        }
    },
    components: {
        Footer
    },
    watch: {
        '$page.props.flash': {
            handler() {
                this.showFlash()
            },
            deep: true
        },
        '$page.props.title': {
            handler(){
                this.pageTitle = this.$page.props.title
            }
        }
    },
    data(){
        return {
            pageTitle: this.title
        }
    },
    created(){
        this.$nextTick(()=>{
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
@import '@scss/empty.scss';
</style>