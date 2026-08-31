<template>
    <div class="SimpleCMS-admin-dashboard">
        <div class="SimpleCMS-admin-dashboard-header">
            <slot name="header"></slot>
        </div>
        <div class="SimpleCMS-admin-dashboard-stats">
            <slot name="stats"></slot>
        </div>
        <div class="SimpleCMS-admin-dashboard-grid">
            <div class="SimpleCMS-admin-dashboard-main">
                <slot name="main"></slot>
            </div>
            <div class="SimpleCMS-admin-dashboard-side">
                <slot name="side"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'VAdminDashboard'
}
</script>

<style lang="scss" scoped>
.SimpleCMS-admin-dashboard {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 18px;
    .SimpleCMS-admin-dashboard-header {
        width: 100%;
    }
    .SimpleCMS-admin-dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }
    .SimpleCMS-admin-dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr);
        gap: 16px;
        align-items: start;
    }
    .SimpleCMS-admin-dashboard-main,
    .SimpleCMS-admin-dashboard-side {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    @media (max-width: 980px) {
        .SimpleCMS-admin-dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
}
</style>
