<template>
    <file-field v-bind="$props" v-on="$listeners">
        <template #item="{ file }">
            <image-file-item 
                :file="file"
                @remove-file="() => removeFile()"   
            />
        </template>
    </file-field>
</template>

<script>
import ImageFileItem from './file-field-partials/ImageFileItem'
import FileField from './FileField'
export default {
    extends: FileField,
    components: {
        FileField,
        ImageFileItem
    },
    props: {
        accept: {
            type: String,
            default: 'image/png, image/jpeg'
        }
    }
}
</script>