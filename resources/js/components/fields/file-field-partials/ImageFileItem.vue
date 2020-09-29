<template>
    <file-item v-bind="$props" v-on="$listeners">
        <template #icon="{ file }">
            <div class="flex-initial w-10 h-10 flex items-center transform duration-300 hover:scale-300 hover:border-transparent hover:translate-z-0 shadow-md origin-left delay-200 bg-white z-30">
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