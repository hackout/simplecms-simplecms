<template>
    <DefaultLayout>
        <div class="SimpleCMS-content">
            <div class="SimpleCMS-content-box">
                <div class="content-catalogs">
                    <el-row :gutter="16">
                        <el-col :span="12">
                            <el-card shadow="never" class="catalog-card">
                                <template #header>
                                    <div class="catalog-header">
                                        <span>文章分类</span>
                                        <v-dialog-form button="新增分类" header="新增分类"
                                            :action="$route('backend.content.category.create')" method="post"
                                            :options="categoryFormItem('create')" @saved="refreshCatalogs()">
                                            <el-button type="primary" size="small">新增分类</el-button>
                                        </v-dialog-form>
                                    </div>
                                </template>
                                <el-table :data="categoryList" stripe border size="small">
                                    <el-table-column label="分类名称" prop="name"></el-table-column>
                                    <el-table-column label="标识" prop="slug" width="140"></el-table-column>
                                    <el-table-column label="状态" width="90">
                                        <template #default="scope">
                                            <el-tag :type="scope.row.is_valid ? 'success' : 'info'">
                                                {{ scope.row.is_valid ? '启用' : '禁用' }}
                                            </el-tag>
                                        </template>
                                    </el-table-column>
                                    <el-table-column label="操作" width="120" fixed="right">
                                        <template #default="scope">
                                            <v-dialog-form header="编辑分类"
                                                :action="$route('backend.content.category.update', { id: scope.row.id })"
                                                method="put" :options="categoryFormItem('update', scope.row)"
                                                @saved="refreshCatalogs()">
                                                <el-button title="编辑" circle class="el-button--dark" size="small">
                                                    <SimpleCMSIconEdit size="14px"></SimpleCMSIconEdit>
                                                </el-button>
                                            </v-dialog-form>
                                            <v-dialog header="系统提示" :name="`categoryRemoveDialogRef${scope.row.id}`"
                                                :ref="`categoryRemoveDialogRef${scope.row.id}`" content="确定删除此分类？"
                                                type="confirm" @confirm="deleteCategory(scope.row, `categoryRemoveDialogRef${scope.row.id}`)">
                                                <template #button>
                                                    <el-button circle class="el-button--dark" size="small">
                                                        <SimpleCMSIconTrash size="14px"></SimpleCMSIconTrash>
                                                    </el-button>
                                                </template>
                                            </v-dialog>
                                        </template>
                                    </el-table-column>
                                </el-table>
                            </el-card>
                        </el-col>
                        <el-col :span="12">
                            <el-card shadow="never" class="catalog-card">
                                <template #header>
                                    <div class="catalog-header">
                                        <span>文章标签</span>
                                        <v-dialog-form button="新增标签" header="新增标签"
                                            :action="$route('backend.content.tag.create')" method="post"
                                            :options="tagFormItem('create')" @saved="refreshCatalogs()">
                                            <el-button type="primary" size="small">新增标签</el-button>
                                        </v-dialog-form>
                                    </div>
                                </template>
                                <el-table :data="tagList" stripe border size="small">
                                    <el-table-column label="标签名称" prop="name"></el-table-column>
                                    <el-table-column label="标识" prop="slug" width="140"></el-table-column>
                                    <el-table-column label="操作" width="120" fixed="right">
                                        <template #default="scope">
                                            <v-dialog-form header="编辑标签"
                                                :action="$route('backend.content.tag.update', { id: scope.row.id })"
                                                method="put" :options="tagFormItem('update', scope.row)"
                                                @saved="refreshCatalogs()">
                                                <el-button title="编辑" circle class="el-button--dark" size="small">
                                                    <SimpleCMSIconEdit size="14px"></SimpleCMSIconEdit>
                                                </el-button>
                                            </v-dialog-form>
                                            <v-dialog header="系统提示" :name="`tagRemoveDialogRef${scope.row.id}`"
                                                :ref="`tagRemoveDialogRef${scope.row.id}`" content="确定删除此标签？"
                                                type="confirm" @confirm="deleteTag(scope.row, `tagRemoveDialogRef${scope.row.id}`)">
                                                <template #button>
                                                    <el-button circle class="el-button--dark" size="small">
                                                        <SimpleCMSIconTrash size="14px"></SimpleCMSIconTrash>
                                                    </el-button>
                                                </template>
                                            </v-dialog>
                                        </template>
                                    </el-table-column>
                                </el-table>
                            </el-card>
                        </el-col>
                    </el-row>
                </div>

                <VTable action="backend.content.list" :params="queryParam" @search="searchData" ref="tableRef">
                    <template #header_left>
                        <el-form-item>
                            <v-dialog-form button="新增文章" header="新增文章" :action="$route('backend.content.create')"
                                method="post" :options="formItem('create')" @saved="refreshData()">
                                <el-button type="primary">新增文章</el-button>
                            </v-dialog-form>
                        </el-form-item>
                    </template>
                    <template #header_right>
                        <el-form-item label="状态">
                            <el-select v-model="queryParam.status" clearable placeholder="全部状态" style="width: 120px;">
                                <el-option label="已发布" :value="1"></el-option>
                                <el-option label="草稿" :value="0"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="分类">
                            <el-select v-model="queryParam.category_id" clearable placeholder="全部分类" style="width: 160px;">
                                <el-option v-for="item in categoryOptions" :key="item.value" :label="item.name" :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item>
                            <el-input v-model="queryParam.keyword" clearable @clear="searchData" placeholder="关键词"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" native-type="submit">查询</el-button>
                        </el-form-item>
                    </template>

                    <el-table-column label="ID" width="90" prop="id"></el-table-column>
                    <el-table-column label="标题" min-width="220" prop="title"></el-table-column>
                    <el-table-column label="分类" width="120" prop="category"></el-table-column>
                    <el-table-column label="作者" width="120" prop="author"></el-table-column>
                    <el-table-column label="状态" width="100" prop="is_published">
                        <template #default="scope">
                            <el-tag :type="scope.row.is_published ? 'success' : 'info'">
                                {{ scope.row.is_published ? '已发布' : '草稿' }}
                            </el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="发布时间" width="190" prop="published_at">
                        <template #default="scope">
                            {{ $tool.dateFormat(scope.row.published_at) }}
                        </template>
                    </el-table-column>
                    <el-table-column label="操作" fixed="right" width="220">
                        <template #default="scope">
                            <el-button title="版本历史" circle class="el-button--dark" @click="openVersions(scope.row)">
                                <SimpleCMSIconTime size="16px"></SimpleCMSIconTime>
                            </el-button>
                            <v-dialog-form header="编辑文章" :action="$route('backend.content.update', { id: scope.row.id })"
                                method="put" :options="formItem('update', scope.row)" @saved="refreshData()">
                                <el-button title="编辑" circle class="el-button--dark">
                                    <SimpleCMSIconEdit size="16px"></SimpleCMSIconEdit>
                                </el-button>
                            </v-dialog-form>
                            <v-dialog header="系统提示" :name="`removeDialogRef${scope.row.id}`" :ref="`removeDialogRef${scope.row.id}`"
                                content="确定删除此文章？" type="confirm" @confirm="deleteItem(scope.row, `removeDialogRef${scope.row.id}`)">
                                <template #button>
                                    <el-button circle class="el-button--dark">
                                        <SimpleCMSIconTrash size="16px"></SimpleCMSIconTrash>
                                    </el-button>
                                </template>
                            </v-dialog>
                        </template>
                    </el-table-column>
                </VTable>
            </div>
        </div>

        <el-dialog v-model="versionDialogVisible" title="版本历史" width="920px" destroy-on-close>
            <div v-if="currentArticle">
                <div class="version-summary">
                    <strong>{{ currentArticle.title }}</strong>
                    <span>当前版本：{{ currentArticle.status || 'draft' }}</span>
                </div>
                <el-table :data="versionList" stripe border size="small" empty-text="暂无版本记录">
                    <el-table-column label="版本号" width="100" prop="version_number" />
                    <el-table-column label="标题" min-width="220" prop="title" />
                    <el-table-column label="状态" width="120">
                        <template #default="scope">
                            <el-tag :type="scope.row.status === 'published' ? 'success' : scope.row.status === 'review' ? 'warning' : 'info'">
                                {{ scope.row.status === 'published' ? '已发布' : scope.row.status === 'review' ? '审核中' : '草稿' }}
                            </el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="更新时间" width="180">
                        <template #default="scope">
                            {{ $tool.dateFormat(scope.row.updated_at || scope.row.created_at) }}
                        </template>
                    </el-table-column>
                    <el-table-column label="操作" width="120" fixed="right">
                        <template #default="scope">
                            <el-button size="small" type="primary" @click="restoreVersion(scope.row)">恢复</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <template #footer>
                <el-button @click="versionDialogVisible = false">关闭</el-button>
            </template>
        </el-dialog>
    </DefaultLayout>
</template>

<script>
export default {
    props: {
        query: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            queryParam: Object.assign({}, this.query),
            categoryOptions: [],
            tagOptions: [],
            categoryList: [],
            tagList: [],
            versionDialogVisible: false,
            versionList: [],
            currentArticle: null
        }
    },
    mounted() {
        this.loadOptions()
        this.loadCatalogs()
    },
    methods: {
        async loadOptions() {
            try {
                const [categoryRes, tagRes] = await Promise.all([
                    this.$axios.get(this.$route('backend.content.category.list')),
                    this.$axios.get(this.$route('backend.content.tag.list'))
                ])

                const categoryItems = (categoryRes && categoryRes.code === this.$config.successCode ? (categoryRes.data?.items || []) : [])
                const tagItems = (tagRes && tagRes.code === this.$config.successCode ? (tagRes.data?.items || []) : [])

                this.categoryOptions = categoryItems.map(item => ({ name: item.name, value: item.id }))
                this.tagOptions = tagItems.map(item => ({ name: item.name, value: item.id }))
            } catch (error) {
                this.categoryOptions = []
                this.tagOptions = []
            }
        },
        async loadCatalogs() {
            try {
                const [categoryRes, tagRes] = await Promise.all([
                    this.$axios.get(this.$route('backend.content.category.list')),
                    this.$axios.get(this.$route('backend.content.tag.list'))
                ])

                this.categoryList = categoryRes && categoryRes.code === this.$config.successCode ? (categoryRes.data?.items || []) : []
                this.tagList = tagRes && tagRes.code === this.$config.successCode ? (tagRes.data?.items || []) : []
            } catch (error) {
                this.categoryList = []
                this.tagList = []
            }
        },
        async openVersions(row) {
            if (!row || !row.id) return

            this.currentArticle = row
            const res = await this.$axios.get(this.$route('backend.content.versions', { id: row.id }))
            if (res && res.code === this.$config.successCode) {
                this.versionList = Array.isArray(res.data?.items) ? res.data.items : []
            } else {
                this.versionList = []
                this.$message.error(res?.message || '版本加载失败')
            }
            this.versionDialogVisible = true
        },
        async restoreVersion(version) {
            if (!this.currentArticle || !version || !version.id) return

            const res = await this.$axios.post(this.$route('backend.content.restore-version', { id: this.currentArticle.id }), {
                version_id: version.id,
            })

            if (res && res.code === this.$config.successCode) {
                this.$message.success(`已恢复到 V${version.version_number}`)
                this.versionDialogVisible = false
                this.refreshData()
            } else {
                this.$message.error(res?.message || '恢复失败')
            }
        },
        categoryFormItem(mode, item) {
            return [
                {
                    name: '分类名称',
                    key: 'name',
                    placeholder: '请输入分类名称',
                    rules: [
                        { required: true, message: '分类名称不能为空', trigger: 'blur' },
                        { min: 2, max: 100, message: '分类名称长度需在2-100之间', trigger: 'blur' }
                    ],
                    clearable: true,
                    value: mode === 'update' && item ? item.name : ''
                },
                {
                    name: '分类标识',
                    key: 'slug',
                    placeholder: '请输入分类标识',
                    rules: [
                        { required: true, message: '分类标识不能为空', trigger: 'blur' },
                        { validator: this.$validation.slug }
                    ],
                    clearable: true,
                    value: mode === 'update' && item ? item.slug : ''
                },
                {
                    name: '分类描述',
                    key: 'description',
                    placeholder: '请输入分类描述',
                    maxlength: 255,
                    clearable: true,
                    value: mode === 'update' && item ? item.description : ''
                },
                {
                    name: '状态',
                    element: 'switch',
                    key: 'is_valid',
                    activeValue: 1,
                    inactiveValue: 0,
                    value: mode === 'update' && item ? (item.is_valid ? 1 : 0) : 1
                }
            ]
        },
        tagFormItem(mode, item) {
            return [
                {
                    name: '标签名称',
                    key: 'name',
                    placeholder: '请输入标签名称',
                    rules: [
                        { required: true, message: '标签名称不能为空', trigger: 'blur' },
                        { min: 2, max: 100, message: '标签名称长度需在2-100之间', trigger: 'blur' }
                    ],
                    clearable: true,
                    value: mode === 'update' && item ? item.name : ''
                },
                {
                    name: '标签标识',
                    key: 'slug',
                    placeholder: '请输入标签标识',
                    rules: [
                        { required: true, message: '标签标识不能为空', trigger: 'blur' },
                        { validator: this.$validation.slug }
                    ],
                    clearable: true,
                    value: mode === 'update' && item ? item.slug : ''
                },
                {
                    name: '标签描述',
                    key: 'description',
                    placeholder: '请输入标签描述',
                    maxlength: 255,
                    clearable: true,
                    value: mode === 'update' && item ? item.description : ''
                }
            ]
        },
        formItem(mode, item) {
            return [
                {
                    name: '文章标题',
                    key: 'title',
                    placeholder: '请输入文章标题',
                    rules: [
                        { required: true, message: '文章标题不能为空', trigger: 'blur' },
                        { min: 2, max: 255, message: '文章标题长度需在2-255之间', trigger: 'blur' }
                    ],
                    clearable: true,
                    value: mode === 'update' && item ? item.title : ''
                },
                {
                    name: '文章标识',
                    key: 'slug',
                    placeholder: '请输入文章标识',
                    rules: [
                        { required: true, message: '文章标识不能为空', trigger: 'blur' },
                        { validator: this.$validation.slug }
                    ],
                    clearable: true,
                    value: mode === 'update' && item ? item.slug : ''
                },
                {
                    name: '分类',
                    element: 'select',
                    key: 'category_id',
                    placeholder: '请选择分类',
                    option: { category_id: this.categoryOptions },
                    clearable: true,
                    value: mode === 'update' && item ? item.category_id : ''
                },
                {
                    name: '标签',
                    element: 'checkbox',
                    key: 'tag_ids',
                    option: { tag_ids: this.tagOptions },
                    value: mode === 'update' && item && Array.isArray(item.tags) ? item.tags.map(tag => tag.id) : []
                },
                {
                    name: '摘要',
                    key: 'summary',
                    placeholder: '请输入文章摘要',
                    maxlength: 500,
                    clearable: true,
                    value: mode === 'update' && item ? item.summary : ''
                },
                {
                    name: '内容',
                    element: 'editor',
                    key: 'content',
                    placeholder: '请输入正文内容',
                    value: mode === 'update' && item ? item.content : ''
                },
                {
                    name: '封面',
                    key: 'cover',
                    placeholder: '请输入封面地址',
                    clearable: true,
                    value: mode === 'update' && item ? item.cover : ''
                },
                {
                    name: '状态',
                    element: 'select',
                    key: 'status',
                    placeholder: '请选择文章状态',
                    option: {
                        status: [
                            { name: '草稿', value: 'draft' },
                            { name: '审核中', value: 'review' },
                            { name: '已发布', value: 'published' },
                            { name: '归档', value: 'archived' }
                        ]
                    },
                    value: mode === 'update' && item ? (item.status || 'draft') : 'draft'
                },
                {
                    name: '是否发布',
                    element: 'switch',
                    key: 'is_published',
                    activeValue: 1,
                    inactiveValue: 0,
                    value: mode === 'update' && item ? (item.is_published ? 1 : 0) : 1
                },
                {
                    name: '是否置顶',
                    element: 'switch',
                    key: 'is_top',
                    activeValue: 1,
                    inactiveValue: 0,
                    value: mode === 'update' && item ? (item.is_top ? 1 : 0) : 0
                },
                {
                    name: '是否推荐',
                    element: 'switch',
                    key: 'is_recommended',
                    activeValue: 1,
                    inactiveValue: 0,
                    value: mode === 'update' && item ? (item.is_recommended ? 1 : 0) : 0
                },
                {
                    name: 'SEO标题',
                    key: 'seo_title',
                    placeholder: '请输入SEO标题',
                    clearable: true,
                    value: mode === 'update' && item ? item.seo_title : ''
                },
                {
                    name: 'SEO描述',
                    key: 'seo_description',
                    placeholder: '请输入SEO描述',
                    maxlength: 500,
                    clearable: true,
                    value: mode === 'update' && item ? item.seo_description : ''
                },
                {
                    name: 'SEO关键词',
                    key: 'seo_keywords',
                    placeholder: '请输入SEO关键词',
                    clearable: true,
                    value: mode === 'update' && item ? item.seo_keywords : ''
                },
                {
                    name: '排序',
                    type: 'number',
                    key: 'sort_order',
                    placeholder: '请输入排序',
                    value: mode === 'update' && item ? item.sort_order : 0
                },
                {
                    name: '发布时间',
                    element: 'date',
                    key: 'published_at',
                    type: 'datetime',
                    value: mode === 'update' && item && item.published_at ? item.published_at : ''
                }
            ]
        },
        searchData() {
            this.queryParam.page = 1
            this.refreshData()
        },
        refreshData() {
            this.$nextTick(() => {
                this.$refs.tableRef.refreshData()
            })
        },
        async refreshCatalogs() {
            await this.loadOptions()
            await this.loadCatalogs()
            this.refreshData()
        },
        async deleteItem(item, refName) {
            let res = await this.$axios.delete(this.$route('backend.content.delete', { id: item.id }))
            if (res.code == this.$config.successCode) {
                this.$message.success('删除文章成功')
                this.$closeDialog(refName)
                this.refreshData()
            } else {
                this.$message.error(res.message)
            }
        },
        async deleteCategory(item, refName) {
            let res = await this.$axios.delete(this.$route('backend.content.category.delete', { id: item.id }))
            if (res.code == this.$config.successCode) {
                this.$message.success('删除分类成功')
                this.$closeDialog(refName)
                await this.refreshCatalogs()
            } else {
                this.$message.error(res.message)
            }
        },
        async deleteTag(item, refName) {
            let res = await this.$axios.delete(this.$route('backend.content.tag.delete', { id: item.id }))
            if (res.code == this.$config.successCode) {
                this.$message.success('删除标签成功')
                this.$closeDialog(refName)
                await this.refreshCatalogs()
            } else {
                this.$message.error(res.message)
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '@scss/content/index.scss';

.content-catalogs {
    margin-bottom: 18px;
}

.catalog-card {
    height: 100%;
}

.catalog-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    font-weight: 600;
}
</style>
