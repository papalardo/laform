<template>
    <label class="block">
        <span class="text-gray-700">{{ label }}</span>
        <div class="flex flex-wrap items-stretch w-full relative mt-1">
			<div class="flex -mr-px" v-show="prependAddon">
				<span class="flex items-center leading-normal bg-gray-300 rounded rounded-r-none border border-r-0 px-3 whitespace-no-wrap text-gray-600 text-sm">{{ prependAddon }}</span>
			</div>
            <input :class="['form-input block w-px flex-shrink flex-grow flex-auto', { 'rounded-l-none': prependAddon }, { 'rounded-r-none': appendAddon }]" 
                :type="type" 
                :id="name" 
                :name="name"
                :placeholder="placeholder"
                v-model.lazy="localValue"
            >
			<div class="flex -mr-px" v-show="appendAddon">
				<span class="flex items-center leading-normal bg-gray-300 rounded rounded-l-none border border-l-0 px-3 whitespace-no-wrap text-gray-600 text-sm">{{ appendAddon }}</span>
			</div>	
		</div>		
        
        <div class="text-sm text-gray-500" v-if="help">{{ help }}</div>
    </label>
</template>

<script>
export default {
    props: {
        name: String,
        label: String,
        value: String,
        placeholder: String,
        prependAddon: String,
        appendAddon: String,
        default: {
            type: [String, Number],
            default: ''
        },
        type: {
            type: String,
            default: 'text'
        },
        help: {
            type: String
        }
    },
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
    }
}
</script>

<style>

</style>