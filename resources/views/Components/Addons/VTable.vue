<template>
    <div class="SimpleCMS-table" ref="tableRef" :class="{ rounded: round, padding: padding }">
        <el-form class="SimpleCMS-table-header" ref="tableHeaderRef" v-if="$slots.header_left || $slots.header_right"
            :inline="true" label-position="left" @submit.native.prevent="$emit('search')">
            <div class="SimpleCMS-table-header-left">
                <slot name="header_left"></slot>
            </div>
            <div class="SimpleCMS-table-header-right">
                <slot name="header_right"></slot>
            </div>
        </el-form>
        <div class="SimpleCMS-table-body" :style="{ height: maxStyle + 'px' }">
            <el-table :data="items" @selection-change="$emit('selection-change', $event)" :indent="6"
                v-loading="loading" :row-key="rowKey" :tree-props="treeProps" :default-expand-all="defaultExpandAll"
                @sort-change="changeSort" :highlight-current-row="false" :height="tableHeight" :stripe="striped"
                :border="border" style="width: calc(100% - 2px)">
                <slot></slot>
                <template #empty>
                    <el-empty :image="emptyIconState" :description="emptyTextState" :image-size="168" />
                </template>
            </el-table>
        </div>
        <div class="SimpleCMS-table-footer" ref="tableFooterRef" v-if="!hiddenFooter && showPagination">
            <div class="SimpleCMS-table-footer-left">
                <slot v-if="$slots.footer_left" name="footer_left"></slot>
                <span v-else>{{ totalText }}</span>
            </div>
            <div class="SimpleCMS-table-footer-right">
                <slot v-if="$slots.footer_right" name="footer_right"></slot>
                <template v-else>
                    <div class="SimpleCMS-table-footer-right-item">
                        <el-select :model-value="query.limit" @change="changeLimit">
                            <el-option v-for="(d, index) in pageSizes" :key="index" :label="d"
                                :value="d"></el-option>
                        </el-select>
                    </div>
                    <el-button class="el-button--dark" circle :disabled="!prevDisabled" @click="prevPage">
                        <SimpleCMSIconChevronLeft size="20px"></SimpleCMSIconChevronLeft>
                    </el-button>
                    <div class="SimpleCMS-table-footer-right-buttons" :style="pageStyle">
                        <div class="SimpleCMS-table-footer-right-buttons-item" :class="{ active: p == query.page }"
                            v-for="(p, i) in showPages" :key="i" @click="setPage(p, i)">
                            <span>{{ p }}</span>
                        </div>
                    </div>
                    <el-button class="el-button--dark" circle :disabled="!nextDisabled" @click="nextPage">
                        <SimpleCMSIconChevronRight size="20px"></SimpleCMSIconChevronRight>
                    </el-button>
                    <el-button class="el-button--dark" @click="getData" circle>
                        <SimpleCMSIconRefresh size="20px"></SimpleCMSIconRefresh>
                    </el-button>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import tableConfig from '@/config/table.js';
export default {
    name: 'VTable',
    props: {
        height: {
            type: String,
            default: null
        },
        data: {
            type: Array,
            default: () => []
        },
        params: {
            type: Object,
            default: () => ({})
        },
        action: {
            type: String,
            default: null
        },
        round: {
            type: Boolean,
            default: true
        },
        defaultExpandAll: {
            type: Boolean,
            default: false
        },
        treeProps: {
            type: Object,
            default: () => ({
                children: 'children',
                hasChildren: 'hasChildren'
            })
        },
        rowKey: {
            type: String,
            default: null
        },
        hiddenFooter: {
            type: Boolean,
            default: false
        },
        showPagination: {
            type: Boolean,
            default: true
        },
        pageSizes: {
            type: Array,
            default: () => [10, 20, 50, 100]
        },
        striped: {
            type: Boolean,
            default: false
        },
        border: {
            type: Boolean,
            default: true
        },
        padding: {
            type: Boolean,
            default: true
        },
        emptyText: {
            type: String,
            default: '暂无数据'
        },
        emptyIcon: {
            type: String,
            default: '/assets/images/no_data.png'
        }
    },
    emits: ['search', 'selection-change', 'change'],
    data() {
        return {
            loading: false,
            pageConfig: tableConfig,
            total: this.getTotalFromData(this.data),
            items: this.getItemsFromData(this.data),
            tableHeight: this.height,
            query: Object.assign({}, tableConfig.request, this.params || {}),
            queryName: this.action,
            pageIndex: 0,
            maxStyle: 320,
            pagePosition: [],
            emptyTextState: this.emptyText,
            emptyIconState: this.emptyIcon,
        }
    },
    watch: {
        action(val) {
            this.queryName = val
            if (this.queryName) {
                this.getData()
            } else {
                this.syncLocalData()
            }
        },
        height(val) {
            this.tableHeight = val
        },
        emptyText(val) {
            this.emptyTextState = val
        },
        emptyIcon(val) {
            this.emptyIconState = val
        },
        params: {
            handler(val) {
                this.query = Object.assign({}, tableConfig.request, val || {})
                this.pageIndex = 0
                if (!this.queryName) {
                    this.syncLocalData()
                }
            },
            deep: true
        },
        data: {
            handler(val) {
                if (!this.queryName) {
                    this.syncLocalData()
                }
            },
            deep: true
        }
    },
    computed: {
        pageStyle() {
            let m = 4;
            if (this.pageIndex > 0) {
                m += (this.pageIndex * 38)
            }
            return `--cms-button-left: ${m}px;`
        },
        totalText() {
            let start = (this.query.page - 1) * this.query.limit
            let end = start + this.query.limit
            let safeTotal = Number(this.total) || 0
            let texts = [
                '显示',
                start + 1,
                '至',
                end > safeTotal ? safeTotal : end,
                '条,',
                '共',
                safeTotal,
                '条记录.'
            ];
            return texts.join(' ');
        },
        prevDisabled() {
            let allPage = this.total == 0 ? 1 : Math.ceil(this.total / this.query.limit);
            return allPage > 1 && this.query.page > 1
        },
        nextDisabled() {
            let allPage = this.total == 0 ? 1 : Math.ceil(this.total / this.query.limit);
            return allPage > 1 && this.query.page < allPage
        },
        showPages() {
            let allPage = this.total == 0 ? 1 : Math.ceil(this.total / this.query.limit);
            let i = (Math.ceil(this.query.page / 5) - 1) * 5 + 1;
            let end = i + 5 > allPage ? allPage : i + 5
            let pages = []
            for (i; i <= end; i++) {
                pages.push(i)
            }
            return pages
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.maxHeight()
            if (this.queryName) {
                this.getData()
            } else {
                this.syncLocalData()
            }
        })
    },
    methods: {
        getTotalFromData(list) {
            if (!Array.isArray(list)) return 0
            return list.length
        },
        getItemsFromData(list) {
            return Array.isArray(list) ? list : []
        },
        normalizeResponse(res) {
            if (Array.isArray(res)) {
                return {
                    total: res.length,
                    items: res
                }
            }
            if (res && typeof res === 'object') {
                const list = Array.isArray(res.items) ? res.items : (Array.isArray(res.list) ? res.list : (Array.isArray(res.data) ? res.data : []))
                const total = Number(res.total ?? res.count ?? res.totalCount ?? (Array.isArray(list) ? list.length : 0)) || 0
                return {
                    total,
                    items: list
                }
            }
            return {
                total: 0,
                items: []
            }
        },
        syncLocalData() {
            const normalized = this.normalizeResponse(this.data)
            this.total = normalized.total
            this.items = normalized.items
            this.$emit('change', this.items)
        },
        maxHeight() {
            let ref = this.$refs.tableRef
            let hRef = this.$refs.tableHeaderRef
            let fRef = this.$refs.tableFooterRef
            let t = ref ? ref.clientHeight : 0;
            let h = hRef && hRef.$el ? hRef.$el.clientHeight : 0;
            let f = fRef && fRef.$el ? fRef.$el.clientHeight : 0;
            let mx = t - (h + f + 50)
            this.maxStyle = mx > 0 ? mx : 320
            if (this.tableHeight == '100%') {
                this.tableHeight = this.maxStyle + 'px'
            }
        },
        setPage(i, index) {
            if (i != this.query.page) {
                this.query.page = i
                this.pageIndex = index
                this.getData()
            }
        },
        prevPage() {
            if (this.prevDisabled) {
                this.query.page--
                this.pageIndex = this.showPages.indexOf(this.query.page)
                this.getData()
            }
        },
        nextPage() {
            if (this.nextDisabled) {
                this.query.page++
                this.pageIndex = this.showPages.indexOf(this.query.page)
                this.getData()
            }
        },
        changeLimit(v) {
            this.query.limit = v
            this.query.page = 1
            this.getData()
        },
        refreshData() {
            this.query = Object.assign({}, tableConfig.request, this.params || {}, this.query)
            this.pageIndex = this.showPages.indexOf(this.query.page)
            this.getData()
        },
        changeSort({ prop, order }) {
            const nextOrder = order === 'ascending' ? 'asc' : (order === 'descending' ? 'desc' : '')
            this.query.prop = prop || ''
            this.query.order = nextOrder
            this.getData()
        },
        async getData() {
            if (!this.queryName) {
                this.syncLocalData()
                return
            }
            if (this.loading) {
                return
            }
            this.loading = true
            this.emptyTextState = '加载中'
            this.emptyIconState = '/assets/images/coming.png'
            this.items = []
            try {
                const res = await this.$axios.get(this.$route(this.queryName, this.query))
                const payload = res && typeof res === 'object' ? res : {}
                const code = payload.code ?? payload.status ?? this.$config.successCode
                const result = payload.data ?? payload
                if (code == this.$config.successCode || code === 200 || code === 0) {
                    const normalized = this.normalizeResponse(result)
                    this.total = normalized.total
                    this.items = normalized.items
                    if (this.items.length == 0) {
                        this.emptyTextState = '暂无数据'
                        this.emptyIconState = '/assets/images/no_data.png'
                    }
                } else {
                    this.items = []
                    this.total = 0
                    this.emptyTextState = payload.message || '获取数据失败'
                    this.emptyIconState = '/assets/images/error.png'
                }
            } catch (error) {
                this.items = []
                this.total = 0
                this.emptyTextState = error?.message || '请求失败'
                this.emptyIconState = '/assets/images/error.png'
            } finally {
                this.loading = false
                this.$emit('change', this.items)
            }
        }
    }
}
</script>

<style lang="scss">
@import '@scss/addons/table.scss';
</style>