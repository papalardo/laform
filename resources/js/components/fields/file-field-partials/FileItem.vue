<template>
    <div class="flex items-center border form-input py-3">
        <slot name="icon" :file="file">
            <svg class="flex-initial w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64.06 83.59"><path d="M55.94,83.59a8.16,8.16,0,0,0,8.12-8.16V19.12a1.77,1.77,0,0,0-.52-1.25L46.21.59A1.69,1.69,0,0,0,45.14.08L44.69,0l-.18,0H8.13A8.18,8.18,0,0,0,0,8.16V75.41a8.16,8.16,0,0,0,8.13,8.16H55.94ZM46.68,6,58.11,17.38H46.68ZM3.52,75.43V8.16A4.64,4.64,0,0,1,8.13,3.52h35V19.16a1.75,1.75,0,0,0,1.76,1.74H60.55V75.43a4.65,4.65,0,0,1-4.61,4.65H8.13A4.65,4.65,0,0,1,3.52,75.43Z"/></svg>
        </slot>
        <div class="flex flex-auto ml-2 items-center">
            <div class="flex-auto">
                <div class="flex flex-col truncate w-32 max-w-xs sm:w-auto">
                    <slot
                        name="name" 
                        :getFileName="getFileName" 
                        :file="file"
                    >  
                        <a :href="file.url" target="_blank" class="leading-4 truncate">
                            {{ getFileName() }}
                        </a>
                    </slot>
                    <slot :file="file" :formatBytes="formatBytes">
                        <span class="leading-4 text-xs truncate" v-if="file.size">
                            {{ formatBytes(file.size) }}
                        </span>
                    </slot>
                </div>
            </div>
            <div class="ml-2">
                <slot name="delete-icon">
                    <button class="bg-red-600 rounded-full p-2" @click.prevent="$emit('remove-file')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current text-white w-3 h-3"><path d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/></svg>
                    </button>
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        file: {
            type: Object,
            required: true
        }
    },
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
                if(!this.file.url) {
                    console.warn(`[${this.$options._componentTag}] - File URL not defined`)
                    return '';
                }
                return this.file.url.split('/').pop()
            }

            return this.file.name
        }
    }
}
</script>

<style>

</style>