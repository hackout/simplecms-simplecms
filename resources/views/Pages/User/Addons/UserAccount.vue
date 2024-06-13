<template>
    <el-row :gutter="20">
        <el-col v-for="(icon, index) in icons" :key="index" :span="6">
            <div class="SimpleCMS-userDetail-account">
                <div class="SimpleCMS-userDetail-account-icon" :class="icon.color">
                    <component :is="`SimpleCMS${icon.icon}`" size="38px"></component>
                </div>
                <div class="SimpleCMS-userDetail-account-text">{{ getAccount(index + 1) }}</div>
            </div>
            <div class="SimpleCMS-userDetail-accountInfo">
                <div class="SimpleCMS-userDetail-accountInfo-item"
                    :class="{ disabled: getAccount(index + 1, true) === true }" @click="editAccount(index + 1)">
                    <span>修改</span>
                </div>
                <div class="SimpleCMS-userDetail-accountInfo-item"
                    :class="{ disabled: getAccount(index + 1, true) === true }" @click="deleteAccount(index + 1)">
                    <span>删除</span>
                </div>
            </div>
        </el-col>
    </el-row>
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
            accounts: this.item.accounts,
            icons: [{
                name: '本埠账号',
                icon: 'IconUserCircle',
                color: 'info'
            },
            {
                name: 'Email',
                icon: 'IconMail',
                color: 'info'
            },
            {
                name: '手机号码',
                icon: 'IconDeviceMobile',
                color: 'info'
            },
            {
                name: '微信',
                icon: 'IconBrandWechat',
                color: 'success'
            },
            {
                name: '支付宝',
                icon: 'IconBrandAlipay',
                color: 'primary'
            },
            {
                name: 'Github',
                icon: 'IconBrandGithub',
                color: 'dark'
            },
            {
                name: 'Apple',
                icon: 'IconBrandApple',
                color: 'grey'
            },
            {
                name: 'Google',
                icon: 'IconBrandGoogle',
                color: 'danger'
            }
            ]
        }
    },
    methods: {
        getAccount(index, isBool) {
            let account = this.item.accounts.filter(n => n.type == index)
            if (!account || account.length == 0) return isBool ? true : '未设置'
            return account[0].account
        },
        editAccount(index) {
            if(index > 3)
            {
                this.$message.warning('该信息无法删除')
            }else{
            if (this.getAccount(index, true) !== true) {
                let account = this.getAccount(index);
                this.$prompt('账号:', '修改该账号',{
                    inputValue: account
                }).then(async ({value}) => {
                    let res = await this.$axios.put(this.$route('backend.account.update', { id: this.item.id,type:index}),{account:value})
                    if (res.code == this.$config.successCode) {
                        this.$message.success('修改账号成功')
                        this.$reload()
                    }else{
                        this.$message.error(res.message)
                    }
                }).catch(() => { })
            }
            }
        },
        deleteAccount(index) {
            if (this.getAccount(index, true) !== true) {
                this.$confirm('系统提示', '是否取消该账号信息?').then(async () => {
                    let res = await this.$axios.delete(this.$route('backend.account.delete', { id: this.item.id,type:index }))
                    if (res.code == this.$config.successCode) {
                        this.$reload()
                    }else{
                        this.$message.error(res.message)
                    }
                }).catch(() => { })
            }
        }
    }
}
</script>
<style lang="scss" scoped></style>