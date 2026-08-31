
import { Ziggy } from '@/ziggy'
import { createApp, h } from 'vue'
import 'animate.css'
import ElementPlus from 'element-plus'
import zhCn from 'element-plus/dist/locale/zh-cn.mjs'
import { createInertiaApp, Head, Link, router } from '@inertiajs/vue3'
import { route as ZiggyJs } from '../../vendor/tightenco/ziggy/src/js'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import DefaultLayout from '@view/Components/Layout/DefaultLayout.vue'
import EmptyLayout from '@view/Components/Layout/EmptyLayout.vue'
import VTable from '@view/Components/Addons/VTable.vue'
import VCard from '@view/Components/Addons/VCard.vue'
import VDialog from '@view/Components/Addons/VDialog.vue'
import VDialogForm from '@view/Components/Addons/VDialogForm.vue'
import VTableDrawer from '@view/Components/Addons/VTableDrawer.vue'
import VUploadFile from '@view/Components/Addons/VUploadFile.vue'
import VEditor from '@view/Components/Addons/VEditor.vue'
import VBadge from '@view/Components/Addons/VBadge.vue'
import VEmptyState from '@view/Components/Addons/VEmptyState.vue'
import VStatusTag from '@view/Components/Addons/VStatusTag.vue'
import VChart from '@view/Components/Addons/VChart.vue'
import VStatCard from '@view/Components/Addons/VStatCard.vue'
import VPageHeader from '@view/Components/Addons/VPageHeader.vue'
import VFilterBar from '@view/Components/Addons/VFilterBar.vue'
import VActionBar from '@view/Components/Addons/VActionBar.vue'
import VPagePanel from '@view/Components/Addons/VPagePanel.vue'
import VDescriptionList from '@view/Components/Addons/VDescriptionList.vue'
import VCrudPage from '@view/Components/Addons/VCrudPage.vue'
import VDetailPage from '@view/Components/Addons/VDetailPage.vue'
import VFormPage from '@view/Components/Addons/VFormPage.vue'
import VSearchForm from '@view/Components/Addons/VSearchForm.vue'
import VFormItem from '@view/Components/Addons/VFormItem.vue'
import VAdminDashboard from '@view/Components/Addons/VAdminDashboard.vue'
import mixinJs from '@/utils/mixin'
import axios from '@/utils/request'
import tool from '@/utils/tool.js'
import validation from '@/utils/validation.js'
import config from '@/config'
import { icons as TablerIcons } from '@tabler/icons-vue';
import VueApexCharts from "vue3-apexcharts";
import VueAMap, { initAMapApiLoader } from '@vuemap/vue-amap';
import '@vuemap/vue-amap/dist/style.css'
import 'element-plus/theme-chalk/el-message.css'
import 'element-plus/theme-chalk/el-message-box.css'

initAMapApiLoader({
    key: 'ecb8338edd5f01d1e95dc7cd1f910377',
    securityJsCode: 'ad0edde6d062b0e85bf07523a51e256a',
    plugin: ['AMap.Autocomplete', 'AMap.PlaceSearch', 'AMap.Scale', 'AMap.OverView', 'AMap.ToolBar', 'AMap.MapType', 'AMap.PolyEditor', 'AMap.CircleEditor'],
});
const ZiggyFunc = (name, params, absolute, config = Ziggy) => ZiggyJs(name, params, absolute, config);
createInertiaApp({
    resolve: (name) => resolvePageComponent(`../views/Pages/${name}.vue`, import.meta.glob('../views/Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(VueApexCharts)
            .use(VueAMap)
            .use(ElementPlus, { locale: zhCn });

        app.component('Head', Head)
        app.component('Link', Link)
        app.component('DefaultLayout', DefaultLayout)
        app.component('EmptyLayout', EmptyLayout)
        app.component('VTableDrawer', VTableDrawer)
        app.component('VUploadFile', VUploadFile)
        app.component('VDialog', VDialog)
        app.component('VDialogForm', VDialogForm)
        app.component('VTable', VTable)
        app.component('VEditor', VEditor)
        app.component('VCard', VCard)
        app.component('VBadge', VBadge)
        app.component('VEmptyState', VEmptyState)
        app.component('VStatusTag', VStatusTag)
        app.component('VChart', VChart)
        app.component('VStatCard', VStatCard)
        app.component('VPageHeader', VPageHeader)
        app.component('VFilterBar', VFilterBar)
        app.component('VActionBar', VActionBar)
        app.component('VPagePanel', VPagePanel)
        app.component('VDescriptionList', VDescriptionList)
        app.component('VCrudPage', VCrudPage)
        app.component('VDetailPage', VDetailPage)
        app.component('VFormPage', VFormPage)
        app.component('VSearchForm', VSearchForm)
        app.component('VFormItem', VFormItem)
        app.component('VAdminDashboard', VAdminDashboard)
        app.provide('route', ZiggyFunc);
        app.config.globalProperties.$route = ZiggyFunc
        app.config.globalProperties.$ajax = router
        app.config.globalProperties.$axios = axios
        app.config.globalProperties.$config = config
        app.config.globalProperties.$tool = tool
        app.config.globalProperties.$validation = validation
        for (let icon in TablerIcons) {
            app.component(`SimpleCMS${icon}`, TablerIcons[icon])
        }
        window.document.getElementById('loading-bg').remove();
        app.mixin(mixinJs)
        return app.mount(el)
    },
});