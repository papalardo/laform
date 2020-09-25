<template>
    <div class="block">
        <span class="text-gray-700 mb-1">{{ label }}</span>
        <div class="rounded shadow mb-1 w-full bg-grey-light" v-show="progressBar > 0">
            <div class="rounded bg-blue-600 text-xs leading-none py-1 text-center text-white" :style="`width: ${progressBar}%`">{{ progressBar }}%</div>
        </div>
        <div
            class="py-3 form-input hover:bg-teal-700 hover:text-teal-100 text-teal-700 cursor-pointer" 
            @drop="onDrop"
            ref="dropContainer"
            v-if="!localValue"
        >
            <label class="w-full flex flex-col items-center justify-center tracking-wide border border-dashed border-gray-300 cursor-pointer h-full py-3">
                <svg class="w-6 h-6 fill-current" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                </svg>
                <span class="mt-1 text-sm">{{ placeholder || 'Arraste arquivos ou Clique para escolher' }}</span>
                <input type='file' :id="name" :accept="accept" class="hidden" ref="input" :multiple="multiple" @change="onChangeFileInput" />
            </label>
        </div>
        <div v-else>
            <slot name="item" :file="localValue">
                <file-item :file="localValue" @remove-file="() => removeFile()"></file-item>
            </slot>
        </div>
    </div>
</template>

<script>

import FileItem from './FileItem'

export default {
    props: {
        name: String,
        label: String,
        accept: String,
        multiple: Boolean,
        value: {
            type: Object,
            default: null
        },
        placeholder: String,
        help: {
            type: String
        },
        serverConfig: Object
    },
    components: {
        FileItem
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
        onChangeFileInput($event) {
            this.handleFiles($event.target.files)
        },
        onDrop($event) {
            this.handleFiles($event.dataTransfer.files)
        },
        handleFiles(files) {
            this.uploadFilesServer(files)
        },
        handleLocalFile(files) {
            const file = files[0];
            this.localFile = {
                url: URL.createObjectURL(file),
                size: file.size,
                name: file.name,
            }
        },
        uploadFilesServer(files) {
            let form_data = new FormData();
            
            form_data.append('dir', this.serverConfig.dir);

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