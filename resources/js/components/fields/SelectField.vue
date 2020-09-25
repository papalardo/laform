<template>
    <label class="class">
        <span class="block text-gray-700">{{ label }}</span>
        <select :name="name" v-model="localValue" class="form-select mt-1 block w-full">
            <slot 
                name="option"
                :option="option"
                v-for="(option, value) in options" 
            >
                <option :value="valueAttribute ? option[valueAttribute] : value" :key="value">{{ textAttribute ? option[textAttribute] : option }}</option>
            </slot>
        </select>
        <div class="text-sm text-gray-500" v-if="help">{{ help }}</div>
    </label>
</template>

<script>
import { Fragment } from 'vue-fragment'
export default {
    components: {
        Fragment
    },
    props: {
        value: [String, Number],
        name: String,
        label: String,
        help: String,
        linearName: String,
        options: {
            type: [Object, Array],
            default: () => []
        },
        valueAttribute: String,
        textAttribute: String,
        onCreated: Function,
        default: {
            default: null
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
            
    },
    methods: {
        extend(props) {
            return Vue.extend({ props: ['el$', 'option'], ...props })
        }
    }
}
</script>

<style>

</style>