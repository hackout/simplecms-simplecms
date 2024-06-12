<template>
    <div class="simpleCMS-upload-file">
        <el-tooltip placement="top" :disabled="type != 'image' || !image || image.length == 0"
            popper-class="simpleCMS-upload-file-tooltip">
            <template #content><el-image :src="image" style="width:128px;height:128px;" /></template>
            <el-input @click="openFileRef" v-model="fileName" :placeholder="placeholderText" readonly>
                <template #suffix>
                    <SimpleCMSIconSquareRoundedX @click="clear" v-if="image && image.length > 0" size="20px">
                    </SimpleCMSIconSquareRoundedX>
                </template>

                <template #append><span @click="openFileRef">浏览</span></template>
            </el-input>
        </el-tooltip>
        <input type="file" class="invisible" @change="changeFile" autocomplete="off"
            :accept="type != 'image' ? 'image/*,video/*,audio/*,.pdf,.xls,.xlsx,.doc,.docx,.ppt,.pptx,.apk,.ipa,.exe,.dmg,.plist,.bundle,.pkg,.rar,.7z,.zip,.gz,.tar,.md,.txt' : 'image/jpg,image/jpeg,image/gif,image/png'"
            ref="fileRef" />
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
            type: String,
            default: null
        },
        type: {
            type: String,
            default: 'image'
        }
    },
    data() {
        return {
            loading: false,
            fileName: '',
            image: this.src,
            placeholderText: this.placeholder
        }
    },
    watch: {
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
    mounted() {
        this.$nextTick(() => {
            if (this.queryName) {
                this.getData()
            }
        })
    },
    methods: {
        openFileRef() {
            this.$nextTick(() => {
                this.$refs.fileRef.click();
            })
        },
        clear() {
            this.file = null;
            this.image = null;
            this.fileName = null
        },
        changeFile({ target }) {
            if (!target.files || !target.files[0]) {
                return;
            }
            const file = target.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                this.image = e.target.result;
                this.file = file
                this.fileName = file.name
            };
            reader.readAsDataURL(file);
        }
    }
}
</script>

<style lang="scss">
@import '@scss/addons/upload_file.scss';
</style>