<template>
    <div class="block">
        <span class="text-gray-700 mb-1">{{ label }}</span>
        <div class="rounded shadow mb-1 w-full bg-grey-light" v-show="progressBar > 0">
            <div class="rounded bg-blue-600 text-xs leading-none py-1 text-center text-white" :style="`width: ${progressBar}%`">{{ progressBar }}%</div>
        </div>
        <div v-if="localValue">
            <slot name="item" :file="localValue">
                <file-item :file="localValue" @remove-file="() => removeFile()"></file-item>
            </slot>
        </div>
        <file-input 
            @change="handleFiles"
            :accept="accept"
            v-else
        />
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
            type: [Object, String],
            default: null
        },
        placeholder: String,
        help: {
            type: String
        },
        serverConfig: Object,
        useApi: Boolean
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
        this.localValue = typeof this.value === 'string' ? { url: this.value } : this.value
    },
    methods: {
        handleFiles(files) {
            this.useApi ? this.uploadFilesServer(files) : this.handleLocalFile(files)
        },
        handleLocalFile(files) {
            const file = files[0];
            this.localValue = {
                url: URL.createObjectURL(file),
                size: file.size,
                name: file.name,
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
            this.localValue = files[0]
        },
        removeFile() {
            this.localValue = null
        },
    }
}
</script>