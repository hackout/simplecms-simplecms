<template>
    <DefaultLayout>
        <div class="SimpleCMS-content">
            <div class="SimpleCMS-content-box">
                <div class="page-header">
                    <div>
                        <h2>内容审核</h2>
                        <p>审核中文章列表，支持快速审阅与发布。</p>
                    </div>
                    <el-button type="primary" @click="refreshData">刷新</el-button>
                </div>

                <VTable action="backend.content.list" :params="queryParam" @search="searchData" ref="tableRef">
                    <template #header_right>
                        <el-form-item label="关键词">
                            <el-input v-model="queryParam.keyword" clearable @clear="searchData" placeholder="搜索标题/摘要"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" native-type="submit">查询</el-button>
                        </el-form-item>
                    </template>

                    <el-table-column label="标题" min-width="240" prop="title" />
                    <el-table-column label="分类" width="150" prop="category" />
                    <el-table-column label="作者" width="140" prop="author" />
                    <el-table-column label="状态" width="120">
                        <template #default="scope">
                            <el-tag type="warning">审核中</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="更新时间" width="180">
                        <template #default="scope">
                            {{ $tool.dateFormat(scope.row.updated_at) }}
                        </template>
                    </el-table-column>
                    <el-table-column label="操作" fixed="right" width="220">
                        <template #default="scope">
                            <el-button size="small" type="primary" @click="previewArticle(scope.row)">查看</el-button>
                            <el-button size="small" type="success" @click="publishArticle(scope.row)">发布</el-button>
                            <el-button size="small" type="danger" @click="rejectArticle(scope.row)">退回</el-button>
                        </template>
                    </el-table-column>
                </VTable>
            </div>
        </div>

        <el-dialog v-model="previewVisible" title="文章预览" width="900px" destroy-on-close>
            <div v-if="currentArticle" class="article-preview">
                <h3>{{ currentArticle.title }}</h3>
                <div class="meta">
                    <span>{{ currentArticle.category || '未分类' }}</span>
                    <span>{{ currentArticle.author || '未知作者' }}</span>
                    <span>{{ $tool.dateFormat(currentArticle.updated_at) }}</span>
                </div>
                <div class="summary" v-if="currentArticle.summary">{{ currentArticle.summary }}</div>
                <div class="content" v-html="currentArticle.content"></div>
            </div>
            <template #footer>
                <el-button @click="previewVisible = false">关闭</el-button>
                <el-button type="success" @click="publishArticle(currentArticle)">确认发布</el-button>
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
            queryParam: {
                page: 1,
                limit: 20,
                keyword: '',
                status: 'review',
                ...(this.query || {})
            },
            previewVisible: false,
            currentArticle: null,
        }
    },
    methods: {
        searchData() {
            this.queryParam.page = 1
            this.refreshData()
        },
        refreshData() {
            this.$nextTick(() => {
                this.$refs.tableRef?.refreshData()
            })
        },
        previewArticle(row) {
            this.currentArticle = row
            this.previewVisible = true
        },
        async publishArticle(row) {
            if (!row || !row.id) return
            const res = await this.$axios.post(this.$route('backend.content.publish', { id: row.id }))
            if (res.code === this.$config.successCode) {
                this.$message.success('文章已发布')
                this.previewVisible = false
                this.refreshData()
            } else {
                this.$message.error(res.message || '发布失败')
            }
        },
        async rejectArticle(row) {
            if (!row || !row.id) return

            const reason = await this.$prompt('请输入退回原因', '审核退回', {
                confirmButtonText: '确认退回',
                cancelButtonText: '取消',
                inputType: 'textarea',
                inputPlaceholder: '例如：标题不够精准，需要补充业务价值说明。',
                inputValidator: (value) => {
                    if (!value || !value.trim()) {
                        return '退回原因不能为空'
                    }
                    return true
                }
            }).catch(() => null)

            if (!reason) return

            const res = await this.$axios.post(this.$route('backend.content.reject', { id: row.id }), {
                reason: reason.value || reason
            })

            if (res.code === this.$config.successCode) {
                this.$message.success('文章已退回草稿状态')
                this.refreshData()
            } else {
                this.$message.error(res.message || '退回失败')
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;

    h2 {
        margin: 0 0 6px;
        font-size: 28px;
        font-weight: 700;
    }

    p {
        margin: 0;
        color: #64748b;
    }
}

.article-preview {
    .meta {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        color: #64748b;
        font-size: 13px;
        margin: 12px 0 18px;
    }

    .summary {
        margin-bottom: 18px;
        padding: 12px 14px;
        background: #f8fafc;
        border-radius: 8px;
        color: #475569;
    }

    .content {
        line-height: 1.8;
        color: #1f2937;
    }
}
</style>
