<template>
    <DefaultLayout :breadcrumb="false">
        <div class="simpleCMS-box">
            <el-row :gutter="20">
                <el-col :span="8">
                    <VStringCard style="margin-top:20px;" name="CPU使用率" :text="sys.cpu.used" icon="IconCpu" type="success"></VStringCard>
                </el-col>
                <el-col :span="8">
                    <VStringCard style="margin-top:20px;" name="Web引擎" :text="sys.server.software" icon="IconAssembly" type="danger"></VStringCard>
                </el-col>
                <el-col :span="8">
                    <VStringCard style="margin-top:20px;" name="系统信息" :text="sys.system" icon="IconBrandUbuntu" type="error"></VStringCard>
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
        </div>
    </DefaultLayout>
</template>
<script>
import VStringCard from '@view/Components/Addons/VStringCard.vue'
export default {
    components: {
        VStringCard
    },
    props: {
        systemInfo: {
            type: Object,
            default: {}
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
            console.log(this.sys)
        })
    }
}
</script>
<style lang="scss" scoped></style>