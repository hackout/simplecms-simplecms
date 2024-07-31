<template>
    <div class="SimpleCMS-upload-file">
        <template v-if="multiple">
            <el-tooltip v-for="(_file, index) in image" placement="left" :disabled="type != 'image'"
                popper-class="SimpleCMS-upload-file-tooltip" :key="index">
                <template #content><el-image fit="fill" :src="_file.url ? _file.url : _file" style="width:128px;height:128px;" /></template>
                <el-input :value="_file.name ? _file.name : fileName[index]" style="margin-bottom:6px" :placeholder="placeholderText" readonly>
                    <template #suffix>
                        <SimpleCMSIconSquareRoundedX @click="clear(index)" size="20px">
                        </SimpleCMSIconSquareRoundedX>
                    </template>
                </el-input>
            </el-tooltip>
            <el-input @click="openFileRef" v-if="file.length < multipleLimit" :placeholder="placeholderText" readonly>
                <template #append><span
                    style="cursor: pointer;" @click="openFileRef">浏览</span></template>
            </el-input>
        </template>
        <el-tooltip v-else placement="top" :disabled="type != 'image' || !image || image.length == 0"
            popper-class="SimpleCMS-upload-file-tooltip">
            <template #content><el-image fit="fill" :src="image" style="width:128px;height:128px;" /></template>
            <el-input @click="openFileRef" v-model="fileName" :placeholder="placeholderText" readonly>
                <template #suffix>
                    <SimpleCMSIconSquareRoundedX @click="clear" v-if="image && image.length > 0" size="20px">
                    </SimpleCMSIconSquareRoundedX>
                </template>
                <template #append><span
                    style="cursor: pointer;" @click="openFileRef">浏览</span></template>
            </el-input>
        </el-tooltip>
        <input type="file" class="invisible" @change="changeFile" autocomplete="off"
            :accept="type != 'image' ? 'image/*,video/*,audio/*,.pdf,.xls,.xlsx,.doc,.docx,.ppt,.pptx,.apk,.ipa,.exe,.dmg,.plist,.bundle,.pkg,.rar,.7z,.zip,.gz,.tar,.md,.txt' : 'image/jpg,image/jpeg,image/gif,image/png'"
            ref="fileRef" :multiple="multiple ? 'multiple' : null" />
    </div>
</template>

<script>
export default {
    name: 'VUploadFile',
    props: {
        modelValue: {
            type: [Object, String],
            default: null
        },
        placeholder: {
            type: String,
            default: null
        },
        src: {
            type: [String, Array],
            default: null
        },
        type: {
            type: String,
            default: 'image'
        },
        multiple: {
            type: Boolean,
            default: false
        },
        multipleLimit: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            loading: false,
            fileName: this.multiple ? this.src.map(n=>n.name) : '',
            image: this.src,
            placeholderText: this.placeholder
        }
    },
    watch: {
        src(val){
            this.fileName = this.multiple ? val.map(n=>n.name) : ''
            this.image = val
        },
        placeholder(val) {
            this.placeholderText = val
        }
    },
    computed: {
        file: {
            get() {
                return this.modelValue
            },
            set(val) {
                this.$emit('update:modelValue', val)
            }
        }
    },
    methods: {
        openFileRef() {
            this.$nextTick(() => {
                this.$refs.fileRef.click();
            })
        },
        clear(i = 0) {
            if (this.multiple) {
                this.file = this.file.filter((n, x) => x != i);
                this.image = this.image.filter((n, x) => x != i);
                this.fileName = this.fileName.filter((n, x) => x != i)
            } else {
                this.file = null;
                this.image = null;
                this.fileName = null
            }
        },
        canPush(i) {
            if (!this.multiple && i == 0) return true
            return this.file.length + i < this.multipleLimit;
        },
        changeFile({ target }) {
            if (!target.files || !target.files[0]) {
                return;
            }
            for (let i = 0; i < target.files.length; i++) {
                if (this.canPush(i)) {
                    this.convertFile(target.files[i])
                }
            }
        },
        async convertFile(file) {
            const reader = new FileReader()
            reader.onload = e => {
                if (this.multiple) {
                    this.image.push(e.target.result)
                    this.file.push(file)
                    this.fileName.push(file.name)
                } else {
                    this.image = e.target.result
                    this.file = file
                    this.fileName = file.name
                }
            }
            await reader.readAsDataURL(file)
        }
    }
}
</script>

<style lang="scss">
@import '@scss/addons/upload_file.scss';
</style>