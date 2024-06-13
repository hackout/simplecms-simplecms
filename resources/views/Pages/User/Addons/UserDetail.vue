<template>
    <el-form size="large" label-position="top" ref="formRef" :rules="rules" :model="form"
        @submit.native.prevent="onSubmit">
        <el-form-item label="用户姓名" prop="name">
            <el-input v-model="form.name" placeholder="用户姓名" autocomplete="off" />
        </el-form-item>
        <el-form-item label="出生日期" prop="birth_date">
            <el-date-picker style="width:100%;" v-model="form.birth_date" type="date" placeholder="请选择出生日期" />
        </el-form-item>
        <el-divider content-position="left">应急信息</el-divider>
        <el-form-item label="联系人" prop="emergency_contact">
            <el-input v-model="form.emergency_contact" placeholder="联系人" autocomplete="off" />
        </el-form-item>
        <el-form-item label="联系电话" prop="emergency_phone">
            <el-input v-model="form.emergency_phone" placeholder="联系电话" autocomplete="off" />
        </el-form-item>
        <el-form-item label="联系地址" prop="emergency_address">
            <el-input v-model="form.emergency_address" placeholder="联系地址" autocomplete="off" />
        </el-form-item>
        <el-divider></el-divider>
        <el-form-item>
            <el-button type="primary" @click="onSubmit">保存更改</el-button>
            <el-button>重置</el-button>
        </el-form-item>
    </el-form>
</template>
<script>
export default {
    props: {
        item: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            loading: false,
            form: {
                name: this.item.profile.name,
                birth_date: this.item.profile.birth_date,
                emergency_contact: this.item.profile.emergency_contact,
                emergency_phone: this.item.profile.emergency_phone,
                emergency_address: this.item.profile.emergency_address,
            },
            rules: {
            }
        }
    },
    methods: {
        onSubmit() {
            if (!this.loading) {
                this.loading = true
                this.$refs.formRef.validate().then(async () => {
                    let res = await this.$axios.put(this.$route('backend.user.profile', { id: this.item.id }),this.form)
                    this.loading = false
                    if (res.code == this.$config.successCode) {
                        this.$message.success('修改用户信息成功')
                    } else {
                        this.$message.error(res.message)
                    }
                }).catch(() => {
                    this.loading = false
                })
            }
        }
    }
}
</script>
<style lang="scss" scoped></style>