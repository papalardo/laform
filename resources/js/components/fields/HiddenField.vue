<template>
    <input type="hidden" :value="value" :name="name">
</template>

<script>
export default {
    props: {
        name: String,
        value: String,
    },
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
    }
}
</script>

<style>

</style>