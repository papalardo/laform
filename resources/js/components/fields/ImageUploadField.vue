<template>
    <file-field v-bind="$props" v-on="$listeners">
        <template #item="{ file }">
            <image-file-item :file="file"></image-file-item>
        </template>
    </file-field>
</template>

<script>
import FileField from './file-field/FileField'
import ImageFileItem from './file-field/ImageFileItem'
export default {
    extends: FileField,
    components: {
        FileField,
        ImageFileItem
    },
}
</script>