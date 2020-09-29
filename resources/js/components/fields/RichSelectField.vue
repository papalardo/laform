<template>
    <div class="block w-full" v-if="created">
        <span class="block text-gray-700">{{ label }}</span>
        <div class="relative mt-1" v-on-clickaway="closeDropdown">
            <button
                type="button"
                ref="button"
                class="flex text-left justify-between items-center focus:outline-none focus:shadow-outline form-input w-full"
                @click.prevent="opened ? closeDropdown() : openDropdown()"
            >
                <slot
                    name="option"
                    :option="optionSelected"
                    v-if="optionSelected"
                >
                    <span class="block truncate">{{ optionSelected }}</span>
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
                class="absolute w-full mt-1 z-50 rounded bg-white shadow-lg overflow-hidden" 
                v-show="opened"
            >
                <div class="inline-block w-full bg-white p-2">
                    <input
                        placeholder="Search..."
                        class="form-input mt-1 block w-full"
                        v-model="searchKeyword"
                        ref="input"
                        @keypress.enter.prevent.stop="selectOptionOnKeypress"
                    />
                </div>
                <ul class="overflow-auto" style="max-height: 300px;">
                    <div
                        :class="['p-2 cursor-pointer border-l-2 hover:bg-blue-400 hover:border-blue-400', isSelected(option._value) ? 'border-blue-400' : 'border-white']"  
                        @click="selectOption(value)" 
                        v-for="(option, value) in filterOptions" 
                        :key="value"
                    >
                        <slot
                            name="option"
                            :is-selected="isSelected(value)"
                            :option="option"
                            :value="value"
                        >
                            <span class="truncate block">{{ option }}</span>
                        </slot>
                    </div>
                    <div class="p-2" v-show="!Object.keys(filterOptions).length">
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
        trackByValue: {
            type: String,
        },
        trackByLabel: {
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

        opened: false,
        localValueText: '',
        searchKeyword: ''
    }),
    created() {
        // this.fillLocalValue()
        this.$nextTick(() => {
            this.created = true
        })
    },
    computed: {
        optionSelected() {
            return this.arrayOptions[this.localValue]
        },
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
            return Object.entries(this.arrayOptions).filter(([key, option]) => {
                const search = (property) => {
                    if(typeof property === 'string') {
                        return property.toLowerCase().includes(this.searchKeyword.toLowerCase())
                    }
                }

                if(typeof option === 'object') {
                    return Object.values(option).some(search)
                }
                return search(option)
            }).reduce((acc, [key, option]) => (acc[key] = option, acc), {})
        },
        arrayOptions() {
            return this.options;

            if(Array.isArray(this.options) && (!this.trackByValue || !this.trackByLabel)) {
                console.warn(`[${this.$options.name}] [${this.name}] Quando [options] for um array, [trackByValue] e [trackByLabel] devem ser informados.`)
                return [];
            }

            if(typeof this.options === 'object' && !Array.isArray(this.options)) {
                return Object.entries(this.options).map(([key, option]) => {
                    return {
                        ...option,
                        '_value': this.trackByValue ? option[this.trackByValue] : key,
                        '_label': this.trackByLabel ? option[this.trackByLabel] : option
                    }
                })
            }

            return this.options.map((option) => {
                return {
                    ...option,
                    '_value': option[this.trackByValue],
                    '_label': option[this.trackByValue]
                }
            })
        }
    },
    methods: {
        openDropdown() {
            this.opened = true
            this.$nextTick(() => this.$refs.input.focus());
        },
        selectOptionOnKeypress() {
            if(Object.keys(this.filterOptions).length === 1) {
                this.selectOption(Object.keys(this.filterOptions)[0])
                this.$refs.button.focus()
            }
        },
        selectOption(value) {
            this.localValue = value

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