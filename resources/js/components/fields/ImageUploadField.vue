<template>
    <div class="block">
        <span class="text-gray-700 mb-1">{{ label }}</span>
        <ul class="list-group" v-if="multiple">
            <li v-for="(file, index) in localFiles" :key="index" class="mb-1">
                <file-item :file="file" @remove-file="() => removeFile(index)"></file-item>
            </li>
        </ul>
        <div class="rounded shadow mb-1 w-full bg-grey-light" v-show="progressBar > 0">
            <div class="rounded bg-blue-600 text-xs leading-none py-1 text-center text-white" :style="`width: ${progressBar}%`">{{ progressBar }}%</div>
        </div>
        <div
            class="py-3 form-input hover:bg-teal-700 hover:text-teal-100 text-teal-700 cursor-pointer" 
            @drop="onDrop"
            ref="dropContainer"
            v-if="!localFiles.length && !multiple"
        >
            <label class="w-full flex flex-col items-center justify-center tracking-wide border border-dashed border-gray-300 cursor-pointer h-full py-3">
                <svg class="w-6 h-6 fill-current" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                </svg>
                <span class="mt-1 text-sm">{{ placeholder || 'Arraste arquivos ou Clique para escolher' }}</span>
                <input type='file' :id="name" :accept="accept" class="hidden" ref="input" :multiple="multiple" @change="onChangeFileInput" />
            </label>
        </div>
        <file-item v-else :file="localFiles[0]" @remove-file="() => removeFile(0)"></file-item>
    </div>
</template>

<script>

const FileItem = Vue.extend({
    props: ['file'],
    template: `<div class="flex items-center border form-input py-3">
        <div class="flex-initial w-16 h-16 flex items-center transform duration-300 hover:scale-500 hover:border-transparent hover:translate-z-0 shadow-md origin-left delay-200 bg-white z-50">
            <img :src="file.url" alt="" class="h-full w-full object-contain">
        </div>
        <div class="flex flex-auto ml-2 items-center">
            <div class="flex-auto">
                <div class="flex flex-col">
                    <a :href="file.url" target="_blank" class="truncate max-w-xs">
                        {{ getFileName() }}
                    </a>
                </div>
                <span class="truncate max-w-xs text-xs" v-if="file.size">{{ formatBytes(file.size) }}</span>
            </div>
            <div class="ml-2">
                <button class="bg-red-600 rounded-full p-2" @click="$emit('remove-file')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current text-white w-3 h-3"><path d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/></svg>
                </button>
            </div>
        </div>
    </div>
    `,
    methods: {
        formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        },
        getFileName() {
            if(!this.file.name) {
                console.log("this.file.url.split('/').pop() ==>", this.file.url.split('/').pop())
                return this.file.url.split('/').pop()
            }

            return this.file.name
        }
    }
})
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
        default: {
            type: Array,
            default: () => []
        },
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
        localFiles: []
    }),
    computed: {
        localValue: {
            get() {
                return this.value || this.default
            },
            set(newValue) {
                this.$emit('input', newValue)
            }
        }
    },
    created() {
        this.localValue = this.value || this.default
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
        handleLocalFiles(files) {
            for(let i = 0; i < files.length; i++) {
                const file = files[i];
                this.localFiles.push({
                    url: URL.createObjectURL(file),
                    size: file.size,
                    name: file.name,
                })
                this.localValue.push(file)
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
                .then(({ data }) => {
                    if(this.multiple) {
                        this.localFiles.push(...data.files)
                    } else {
                        this.localFiles = [data.files.shift()]
                    }

                    this.localValue = { ...this.localFiles }
                })
                .finally(() => this.progressBar = 0);
        },
        removeFile(index) {
            this.localFiles.splice(index, 1)
            this.localValue.splice(index, 1)
        },
    }
}
</script>

<style>

</style>