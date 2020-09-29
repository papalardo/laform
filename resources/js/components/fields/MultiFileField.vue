<template>
    <div class="block">
        <span class="text-gray-700 mb-1">{{ label }}</span>
        <div class="mb-1" v-for="(file, index) in localValue" :key="index"> 
            <slot name="item" :file="file" :index="index">
                <file-item 
                    :file="file" 
                    @remove-file="() => removeFile(index)"
                />
            </slot>
        </div>
        <div class="rounded shadow mb-1 w-full bg-grey-light" v-show="progressBar > 0">
            <div class="rounded bg-blue-600 text-xs leading-none py-1 text-center text-white" :style="`width: ${progressBar}%`">{{ progressBar }}%</div>
        </div>
        <slot 
            name="input" 
            :accept="accept" 
            @change="handleFiles"
        >
            <file-input 
                :accept="accept"
                multiple
                @change="handleFiles"
            />
        </slot>
    </div>
</template>

<script>
import FileItem from './file-field-partials/FileItem'
import FileInput from './file-field-partials/FileInput'
export default {
    props: {
        name: String,
        label: String,
        accept: String,
        multiple: Boolean,
        value: {
            type: Array,
            default: () => []
        },
        placeholder: String,
        help: String,
        serverConfig: Object
    },
    components: {
        FileItem,
        FileInput
    },
    data:() => ({
        progressBar: 0,
    }),
    computed: {
        localValue: {
            get() {
                return this.value
            },
            set(newValue) {
                this.$emit('input', newValue)
            }
        }
    },
    created() {
        this.localValue = this.value
    },
    methods: {
        handleFiles(files) {
            this.useApi ? this.uploadFilesServer(files) : this.handleLocalFile(files)
        },
        handleLocalFile(files) {
            for(let i = 0; i < files.length; i++) {
                const file = files[i];
                this.localValue.push({
                    url: URL.createObjectURL(file),
                    size: file.size,
                    name: file.name,
                })
            }
        },
        uploadFilesServer(files) {
            let form_data = new FormData();
            
            if(this.serverConfig.dir) {
                form_data.append('dir', this.serverConfig.dir);
            }

            for (let i = 0; i < files.length; i++) {
                form_data.append('files[]', files[i]);
            }

            const axiosConfig = { 
                headers: { 
                    'X-CSRF-Token': this.csrfToken 
                },
                onUploadProgress: (progressEvent) => {
                    this.progressBar = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                }
            }

            axios.post(this.serverConfig.endpoint, form_data, axiosConfig)
                .then(({ data }) => this.uploadSuccess(data))
                .finally(() => this.progressBar = 0);
        },
        uploadSuccess({ files }) {
            this.localValue.push(...files)
        },
        removeFile(index) {
            this.localValue.splice(index, 1)
        },
    }
}
</script>