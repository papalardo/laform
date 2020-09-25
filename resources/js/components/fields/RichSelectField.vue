<template>
    <div class="block w-full" v-if="created">
        <span class="block text-gray-700">{{ label }}</span>
        <div class="relative mt-1" v-on-clickaway="closeDropdown">
            <button
                type="button"
                class="flex text-left justify-between items-center focus:outline-none focus:shadow-outline form-input w-full"
                @click.prevent="opened = !opened"
            >
                <slot
                    name="option"
                    :option="optionSelected"
                    v-if="optionSelected"
                >
                    <span class="block truncate">{{ optionSelected._label }}</span>
                </slot>
                <span v-else>
                    <span class="block truncate text-gray-500">{{ placeholder || '&nbsp;' }}</span>
                </span>

                <!-- Static Field -->
                <input type="hidden" v-model="localValue" :name="name" class="hidden">
                <!-- End Static Field -->

                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current flex-shrink-0 ml-1 h-4 w-4"><path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"></path></svg>
            </button>
            <div 
                class="absolute w-full mt-1 z-20 rounded bg-white shadow-lg overflow-hidden" 
                v-show="opened"
            >
                <div class="inline-block w-full bg-white p-2">
                    <input
                        placeholder="Search..."
                        class="form-input mt-1 block w-full"
                        v-model="searchKeyword"
                    />
                </div>
                <ul class="overflow-auto" style="max-height: 300px;">
                    <div
                        :class="['p-2 cursor-pointer border-l-2 hover:bg-blue-400 hover:border-blue-400', isSelected(option._value) ? 'border-blue-400' : 'border-white']"  
                        @click="selectOption(option)" 
                        v-for="(option, key) in filterOptions" 
                        :key="key"
                    >
                        <slot
                            name="option"
                            :is-selected="isSelected(option._value)"
                            :option="option"
                            :value="option._value"
                        >
                            <span class="truncate block">{{ option._label }}</span>
                        </slot>
                    </div>
                    <div class="p-2" v-show="!filterOptions.length">
                        <slot
                            name="noResults"
                            :keyword="searchKeyword"
                        >
                            <span class="block text-center text-xs text-gray-600">Nenhum resultado encotrado.</span>
                        </slot>
                    </div>
                </ul>
            </div>
        </div>
        <div class="text-sm text-gray-500" v-if="help">{{ help }}</div>
    </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';

export default {
    mixins: [clickaway],
    props: {
        value: {
            default: null
        },
        name: String,
        label: String,
        help: String,
        placeholder: {
            type: String,
        },
        options: {
            type: [Object, Array],
            default: () => []
        },
        valueAttribute: {
            type: String,
        },
        textAttribute: {
            type: String,
        },
        onCreated: Function,
        closeOnSelect: {
            type: Boolean,
            default: true
        }
    },
    data: () => ({
        created: false,
        optionSelected: null,

        opened: false,
        localValueText: '',
        searchKeyword: ''
    }),
    created() {
        this.fillLocalValue()
        this.$nextTick(() => {
            this.created = true
        })
    },
    computed: {
        localValue: {
            get() {
                return this.value
            },
            set(newValue) {
                this.$emit('input', newValue)
            }
        },
        filterOptions() {
            if(! this.searchKeyword) {
                return this.arrayOptions
            }
            return this.arrayOptions.filter(option => option._label.toLowerCase().includes(this.searchKeyword.toLowerCase()))
        },
        arrayOptions() {
            if(Array.isArray(this.options) && (!this.valueAttribute || !this.textAttribute)) {
                console.warn(`[${this.$options.name}] [${this.name}] Quando [options] for um array, [valueAttribute] e [textAttribute] devem ser informados.`)
                return [];
            }

            if(typeof this.options === 'object' && !Array.isArray(this.options)) {
                return Object.entries(this.options).map(([key, option]) => {
                    return {
                        ...option,
                        '_value': this.valueAttribute ? option[this.valueAttribute] : key,
                        '_label': this.textAttribute ? option[this.textAttribute] : option
                    }
                })
            }

            return this.options.map((option) => {
                return {
                    ...option,
                    '_value': option[this.valueAttribute],
                    '_label': option[this.valueAttribute]
                }
            })
        }
    },
    methods: {
        fillLocalValue() {
            if(this.localValue) {
                const option = this.arrayOptions.find(option => option._value == this.localValue)
                if(option) {
                    this.localValue = option._value
                    this.optionSelected = option
                }
            }
        },
        selectOption(option) {
            this.localValue = option._value
            this.optionSelected = option

            if(this.closeOnSelect) {
                this.closeDropdown()
            }
        },
        isSelected(value) {
            return this.localValue == value
        },
        closeDropdown() {
            this.opened = false
        }
    }
}
</script>