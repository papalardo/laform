<template>
    <multi-file-field v-bind="$props" v-on="$listeners">
        <template #item="{ file, index }">
            <image-file-item 
                :file="file"
                @remove-file="() => removeFile(index)"
            />
        </template>
    </multi-file-field>
</template>

<script>
import ImageFileItem from './file-field-partials/ImageFileItem'
import MultiFileField from './MultiFileField'
export default {
    extends: MultiFileField,
    props: {
        accept: {
            type: String,
            default: 'image/png, image/jpeg'
        },
    },
    components: {
        ImageFileItem,
        MultiFileField
    },
}
</script>