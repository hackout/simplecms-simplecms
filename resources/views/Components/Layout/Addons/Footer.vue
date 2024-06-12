<template>
    <div class="simpleCMS-footer">
        <div class="simpleCMS-footer-list">
            <div class="simpleCMS-footer-list-item" v-for="(icp, index) in icpList" :key="index">
                <Link :href="icp.url" target="_blank">{{ icp.name }}</Link>
            </div>
            <div class="simpleCMS-footer-list-copy">
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