<template>
    <el-form size="large" ref="formRef" label-position="top" :rules="rules" :model="form"
        @submit.native.prevent="onSubmit">
        <div class="SimpleCMS-userDetail-box-avatar">
            <el-image :src="avatar" @click="openFileRef"></el-image>
            <div class="SimpleCMS-userDetail-box-avatar-extra">
                <div class="SimpleCMS-userDetail-box-avatar-extra-buttons">
                    <el-popover placement="bottom" ref="popoverRef" :width="330" trigger="click">
                        <el-row :gutter="6">
                            <el-col :span="4" v-for="i in 24" :key="i">
                                <el-avatar :src="`/assets/avatars/avatar-${i}.png`" @click="chooseAvatar(i)"
                                    class="avatar" :size="50"></el-avatar>
                            </el-col>
                        </el-row>
                        <template #reference>
                            <el-button type="primary">选择系统头像</el-button>
                        </template>
                    </el-popover>
                    <el-button @click="openFileRef" type="primary">上传新的头像</el-button>
                    <el-button @click="resetFileRef" class="el-button--dark">重置</el-button>
                </div>
                <p> 仅上传允许的文件类型：JPG、GIF 或 PNG，图像大小不能超过 800 KB </p>
            </div>
            <input class="invisible" @change="changeFileRef" accept="image/jpg,image/jpeg,image/gif,image/png"
                type="file" ref="fileRef" />
        </div>
        <el-divider></el-divider>
        <el-form-item label="UID">
            <el-input :value="item.uid" placeholder="系统生成" disabled />
        </el-form-item>
        <el-form-item label="用户昵称" prop="nickname">
            <el-input v-model="form.nickname" placeholder="用户昵称" />
        </el-form-item>
        <el-form-item label="是否可用" prop="is_valid">
            <el-switch class="SimpleCMS-dialog-switch" v-model="form.is_valid" size="large" :active-value="1"
                :inactive-value="0">
                <template #active-action>
                    <span class="SimpleCMS-dialog-switch-active">是</span>
                </template>
                <template #inactive-action>
                    <span class="SimpleCMS-dialog-switch-inactive">否</span>
                </template>
            </el-switch>
        </el-form-item>
        <el-divider content-position="left">登录信息</el-divider>
        <el-form-item label="最后登录时间">
            <el-input :value="$tool.dateFormat(item.last_login)" placeholder="尚未登录" disabled />
        </el-form-item>
        <el-form-item label="最后登录IP">
            <el-input :value="item.last_ip" placeholder="尚未登录" disabled />
        </el-form-item>
        <el-divider content-position="left">注册信息</el-divider>
        <el-form-item label="注册时间">
            <el-input :value="$tool.dateFormat(item.created_at)" disabled />
        </el-form-item>
        <el-form-item label="注册IP">
            <el-input :value="item.register_ip" disabled />
        </el-form-item>
        <el-form-item label="设备指纹">
            <el-input :value="item.register_finger" disabled />
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
            rules: {
                nickname: [
                    { required: true, message: '用户昵称不能为空', trigger: 'blur' },
                ]
            },
            avatar: this.item.avatar,
            form: {
                avatar: '',
                is_valid: this.item.is_valid ? 1 : 0,
                nickname: this.item.nickname
            }
        }
    },
    methods: {
        openFileRef() {
            this.$nextTick(() => {
                this.$refs.fileRef.click();
            })
        },
        resetFileRef() {
            this.$nextTick(() => {
                this.$refs.fileRef.value = null;
                this.form.avatar = null
                this.avatar = this.item.avatar
            })
        },
        changeFileRef({ target }) {
            if (!target.files || !target.files[0]) {
                return;
            }
            const file = target.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                this.avatar = e.target.result;
                this.form.avatar = file
            };
            reader.readAsDataURL(file);
        },
        chooseAvatar(i) {
            this.avatar = `/assets/avatars/avatar-${i}.png`
            this.$tool.urlToFile(this.avatar, `avatar-${i}.png`).then(file => {
                this.form.avatar = file
                this.$refs.popoverRef.hide()
            })
        },
        onSubmit() {
            if (!this.loading) {
                this.loading = true
                this.$refs.formRef.validate().then(async () => {
                    let form = new FormData()
                    Object.keys(this.form).forEach(n=>{
                        form.append(n,this.form[n])
                    })
                    let res = await this.$axios.post(this.$route('backend.user.update', { id: this.item.id }),form)
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