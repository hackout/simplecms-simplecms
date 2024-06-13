<template>
    <DefaultLayout>
        <div class="SimpleCMS-profile">
            <div class="SimpleCMS-profile-tab">
                <div class="SimpleCMS-profile-tab-item active">
                    <SimpleCMSIconUserScan size="24px"></SimpleCMSIconUserScan>
                    <span>个人资料</span>
                </div>
                <Link :href="$route('backend.dashboard.profile.password')" class="SimpleCMS-profile-tab-item">
                <SimpleCMSIconBrandSamsungpass size="24px"></SimpleCMSIconBrandSamsungpass>
                <span>密码安全</span>
                </Link>
                <Link :href="$route('backend.dashboard.profile.email')" class="SimpleCMS-profile-tab-item">
                <SimpleCMSIconAt size="24px"></SimpleCMSIconAt>
                <span>密保邮箱</span>
                </Link>
            </div>
            <div class="SimpleCMS-profile-box">
                <el-card>
                    <el-form size="large" label-position="top" :rules="rules" :model="form"
                        @submit.native.prevent="onSubmit">
                        <div class="SimpleCMS-profile-box-avatar">
                            <el-image :src="avatar" @click="openFileRef"></el-image>
                            <div class="SimpleCMS-profile-box-avatar-extra">
                                <div class="SimpleCMS-profile-box-avatar-extra-buttons">
                                    <el-popover placement="bottom" ref="popoverRef" :width="330" trigger="click">
                                        <el-row :gutter="6">
                                            <el-col :span="4" v-for="i in 24" :key="i">
                                                <el-avatar :src="`/assets/avatars/avatar-${i}.png`"
                                                    @click="chooseAvatar(i)" class="avatar" :size="50"></el-avatar>
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
                            <input class="invisible" @change="changeFileRef"
                                accept="image/jpg,image/jpeg,image/gif,image/png" type="file" ref="fileRef" />
                        </div>
                        <el-divider></el-divider>
                        <el-form-item label="用户姓名" prop="name">
                            <el-input v-model="form.name" placeholder="用户姓名" />
                        </el-form-item>
                        <el-form-item label="登录账号" prop="account">
                            <el-input v-model="form.account" />
                        </el-form-item>
                        <el-divider content-position="left">校验密码</el-divider>
                        <el-form-item label="登录密码" prop="password">
                            <el-input type="password" v-model="form.password" placeholder="登录密码" autocomplete="off" />
                        </el-form-item>
                        <el-divider></el-divider>
                        <el-form-item>
                            <el-button type="primary" @click="onSubmit">保存更改</el-button>
                            <el-button>重置</el-button>
                        </el-form-item>
                    </el-form>
                </el-card>
            </div>
        </div>
    </DefaultLayout>
</template>
<script>
export default {
    props: {
        manager: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            rules: {
                password: [
                    { required: true, message: '请输入登录密码', trigger: 'blur' },
                ],
                name: [
                    { required: true, message: '请输入用户姓名', trigger: 'blur' }
                ],
                account: [
                    { required: true, message: '请输入登录账号', trigger: 'blur' }
                ]
            },
            avatar: this.manager.avatar,
            form: {
                avatar: '',
                account: this.manager.account,
                name: this.manager.name,
                password: ''
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
                this.avatar = this.manager.avatar
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
                this.$ajax.post(this.$route('backend.dashboard.profile_update'), this.form, {
                    forceFormData: true,
                    onFinish: () => {
                        this.loading = false
                    }
                })
            }
        }
    }
}
</script>
<style lang="scss">
@import '@scss/profile/index.scss';
</style>