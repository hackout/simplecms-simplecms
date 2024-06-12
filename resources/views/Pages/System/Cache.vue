<template>
    <DefaultLayout>
        <div class="SimpleCMS-cache">
            <VCard>
                <div class="SimpleCMS-cache-title">缓存占用量</div>
                <div class="SimpleCMS-cache-value">{{ $tool.byteString(cache.size) }}</div>
                <div class="SimpleCMS-cache-subtitle">共缓存了{{ cache.total }}条数据</div>
                <div class="SimpleCMS-cache-buttons">
                    <el-button type="primary" @click="clearCache">清理缓存</el-button>
                </div>
            </VCard>
        </div>
    </DefaultLayout>
</template>
<script>
export default {
    props: {
    },
    data() {
        return {
            cache: {
                size: 0,
                total: 0
            }
        }
    },
    watch: {
        '$page.props.cache': {
            handler(val) {
                this.cache = val
            },
            deep: true
        }
    },
    created() {
        this.$nextTick(() => {
            this.cache = this.$page.props.cache
        })
    },
    methods: {
        async clearCache() {
            let res = await this.$axios.post(this.$route('backend.system_cache_clear'))
            if (res.code == this.$config.successCode) {
                this.$message.success('清理缓存成功')
                this.$reload()
            } else {
                this.$message.error(res.message)
            }
        }
    }
}
</script>
<style lang="scss" scoped>
@import '@scss/system/cache.scss';
</style>