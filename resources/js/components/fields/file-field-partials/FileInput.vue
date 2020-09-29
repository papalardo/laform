<template>
    <div
        class="py-3 form-input hover:bg-teal-700 hover:text-teal-100 text-teal-700 cursor-pointer" 
        @drop="$emit('change', $event.dataTransfer.files)"
        ref="dropContainer"
    >
        <label class="w-full flex flex-col items-center justify-center tracking-wide border border-dashed border-gray-300 cursor-pointer h-full py-3">
            <div class="w-6 h-6">
                <slot name="icon">
                    <svg class="w-full h-full fill-current" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                    </svg>
                </slot>
            </div>
            <span class="mt-1 text-sm">{{ placeholder }}</span>
            <input type='file' :accept="accept" class="hidden" ref="input" :multiple="multiple" @change="$emit('change', $event.target.files)" />
        </label>
    </div>
</template>

<script>
export default {
    props: {
        placeholder: {
            type: String,
            default: 'Arraste arquivos ou Clique para escolher'
        },
        accept: String,
        multiple: Boolean,
    },
    methods: {

    }
}
</script>