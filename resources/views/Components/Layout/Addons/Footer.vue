<template>
    <div class="SimpleCMS-footer">
        <div class="SimpleCMS-footer-list">
            <div class="SimpleCMS-footer-list-item" v-for="(icp, index) in icpList" :key="index">
                <Link :href="icp.url" target="_blank">{{ icp.name }}</Link>
            </div>
            <div class="SimpleCMS-footer-list-copy">
                {{ copyright }}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        copyright: {
            type: String,
            default: '© 2024 Cdiantong.com'
        },
        icpList: {
            type: Array,
            default: [
                {
                    name: '渝0000000-1',
                    url: 'https://beian.miit.gov.cn/'
                }
            ]
        }
    }
}
</script>
<style lang="scss">
@import '@scss/addons/footer.scss';
</style>