<template>
    <div class="SimpleCMS-demo-dashboard">
        <VPageHeader title="后台看板" subtitle="运营数据总览" icon="LayoutDashboard" />

        <VAdminDashboard>
            <template #header>
                <VPagePanel title="概览">
                    <div class="SimpleCMS-demo-dashboard-header">
                        <div>
                            <h3>业务概况</h3>
                            <p>近 7 天运营指标概览</p>
                        </div>
                        <el-button type="primary">导出报表</el-button>
                    </div>
                </VPagePanel>
            </template>

            <template #stats>
                <VStatCard label="新增用户" :value="1280" :trend="12.4" meta="较上周" icon="Users" icon-color="#409EFF" />
                <VStatCard label="订单总额" :value="'¥86420'" :trend="8.9" meta="较上月" icon="Currency" icon-color="#67C23A" />
                <VStatCard label="转化率" :value="'4.8%'" :trend="-1.2" meta="较昨日" icon="ChartLine" icon-color="#E6A23C" />
                <VStatCard label="待处理" :value="36" :trend="5.3" meta="需要关注" icon="Bell" icon-color="#F56C6C" />
            </template>

            <template #main>
                <VPagePanel title="趋势图表">
                    <VChart type="line" :options="chartOptions" :series="chartSeries" full />
                </VPagePanel>
            </template>

            <template #side>
                <VPagePanel title="实时状态">
                    <div class="SimpleCMS-demo-status-list">
                        <div class="SimpleCMS-demo-status-item">
                            <span class="dot dot-success"></span>
                            <span>系统运行正常</span>
                        </div>
                        <div class="SimpleCMS-demo-status-item">
                            <span class="dot dot-warning"></span>
                            <span>2 个任务待处理</span>
                        </div>
                        <div class="SimpleCMS-demo-status-item">
                            <span class="dot dot-danger"></span>
                            <span>1 个异常需要排查</span>
                        </div>
                    </div>
                </VPagePanel>
            </template>
        </VAdminDashboard>
    </div>
</template>

<script setup>
const chartSeries = [
    { name: '新增用户', data: [120, 160, 190, 210, 240, 260, 310] },
    { name: '订单量', data: [90, 130, 170, 180, 220, 210, 260] }
]

const chartOptions = {
    chart: {
        type: 'line',
        toolbar: { show: false }
    },
    xaxis: {
        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
    },
    stroke: {
        curve: 'smooth'
    },
    tooltip: {
        shared: true
    },
    colors: ['#409EFF', '#67C23A']
}
</script>

<style lang="scss" scoped>
@import '@scss/demo/crud_example.scss';

.SimpleCMS-demo-dashboard {
    width: 100%;
}

.SimpleCMS-demo-dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
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

.SimpleCMS-demo-status-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.SimpleCMS-demo-status-item {
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
</style>
