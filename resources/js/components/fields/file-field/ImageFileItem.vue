<template>
    <file-item v-bind="$props">
        <template #icon="{ file }">
            <div class="flex-initial w-16 h-16 flex items-center transform duration-300 hover:scale-500 hover:border-transparent hover:translate-z-0 shadow-md origin-left delay-200 bg-white z-50">
                <img :src="file.url" alt="" class="h-full w-full object-contain">
            </div>
        </template>
    </file-item>
</template>

<script>
import FileItem from './FileItem'
export default {
    extends: FileItem,
    components: {
        FileItem
    },
}
</script>

<style>

</style>