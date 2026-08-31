<template>
    <DefaultLayout :breadcrumb="false">
        <div class="SimpleCMS-box">
            <VAdminDashboard>
                <template #header>
                    <VPagePanel title="运营概览">
                        <div class="SimpleCMS-dashboard-overview-header">
                            <div>
                                <h3>内容运营看板</h3>
                                <p>监控发布状态、账号增长与系统状态</p>
                            </div>
                        </div>
                    </VPagePanel>
                </template>

                <template #stats>
                    <VStatCard label="新增会员" :value="user_static.total" meta="累计人数" icon="Users" icon-color="#409EFF" />
                    <VStatCard label="管理员" :value="manager_static.total" meta="账号总数" icon="User" icon-color="#67C23A" />
                    <VStatCard label="已发布" :value="content_static.published" meta="内容发布量" icon="Article" icon-color="#E6A23C" />
                    <VStatCard label="审核中" :value="content_static.review" meta="待审数量" icon="Clock" icon-color="#F56C6C" />
                </template>

                <template #main>
                    <VPagePanel title="系统信息">
                        <el-row :gutter="20">
                            <el-col :span="8">
                                <VStringCard name="CPU使用率" :text="sys.cpu.used" icon="IconCpu" type="success"></VStringCard>
                            </el-col>
                            <el-col :span="8">
                                <VStringCard name="Web引擎" :text="sys.server.software" icon="IconAssembly" type="danger"></VStringCard>
                            </el-col>
                            <el-col :span="8">
                                <VStringCard name="系统信息" :text="sys.system" icon="IconBrandUbuntu" type="error"></VStringCard>
                            </el-col>
                            <el-col :span="6">
                                <VStringCard style="margin-top:20px;" name="MYSQL信息" :text="sys.database" icon="IconBrandMysql" type="warning"></VStringCard>
                            </el-col>
                            <el-col :span="6">
                                <VStringCard style="margin-top:20px;" name="PHP版本" :text="sys.php" icon="IconBrandPhp" type="primary"></VStringCard>
                            </el-col>
                            <el-col :span="6">
                                <VStringCard style="margin-top:20px;" :name="sys.framework.name" :text="sys.framework.version" icon="IconPackage" type="info"></VStringCard>
                            </el-col>
                            <el-col :span="6">
                                <VStringCard style="margin-top:20px;" name="Laravel" :text="sys.laravel" icon="IconBrandLaravel" type="danger"></VStringCard>
                            </el-col>
                        </el-row>
                    </VPagePanel>
                </template>

                <template #side>
                    <VPagePanel title="内容状态">
                        <div class="SimpleCMS-dashboard-status-list">
                            <div class="SimpleCMS-dashboard-status-item">
                                <span class="dot dot-success"></span>
                                <span>已发布：{{ content_static.published }}</span>
                            </div>
                            <div class="SimpleCMS-dashboard-status-item">
                                <span class="dot dot-warning"></span>
                                <span>审核中：{{ content_static.review }}</span>
                            </div>
                            <div class="SimpleCMS-dashboard-status-item">
                                <span class="dot dot-danger"></span>
                                <span>草稿：{{ content_static.draft }}</span>
                            </div>
                            <div class="SimpleCMS-dashboard-status-item">
                                <span class="dot dot-info"></span>
                                <span>总计：{{ content_static.total }}</span>
                            </div>
                        </div>
                    </VPagePanel>
                </template>
            </VAdminDashboard>
        </div>
    </DefaultLayout>
</template>
<script>
import VStringCard from '@view/Components/Addons/VStringCard.vue'
import VStatCard from '@view/Components/Addons/VStatCard.vue'
import VAdminDashboard from '@view/Components/Addons/VAdminDashboard.vue'
import VPagePanel from '@view/Components/Addons/VPagePanel.vue'

export default {
    components: {
        VStringCard,
        VStatCard,
        VAdminDashboard,
        VPagePanel
    },
    props: {
        systemInfo: {
            type: Object,
            default: () => ({})
        },
        user_static: {
            type: Object,
            default: () => ({ total: 0 })
        },
        manager_static: {
            type: Object,
            default: () => ({ total: 0 })
        },
        content_static: {
            type: Object,
            default: () => ({ published: 0, review: 0, draft: 0, total: 0 })
        }
    },
    data() {
        return {
            sys: this.systemInfo
        }
    },
    created() {
        this.$nextTick(() => {
            this.sys = this.$page.props.systemInfo
        })
    }
}
</script>
<style lang="scss" scoped>
.SimpleCMS-dashboard-overview-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;

    h3 {
        margin: 0 0 4px;
        color: #1f2937;
    }

    p {
        margin: 0;
        color: #6b7280;
    }
}

.SimpleCMS-dashboard-status-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.SimpleCMS-dashboard-status-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #374151;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}

.dot-success { background: #67c23a; }
.dot-warning { background: #e6a23c; }
.dot-danger { background: #f56c6c; }
.dot-info { background: #409eff; }
</style>