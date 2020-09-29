<template>
    <div class="p-3 border border-gray-300 mt-2 rounded bg-gray-100">
        <label class="text-gray-700">{{ label }}</label>
        <draggable v-model="localValue" handle=".move">
            <div
                v-for="(value, valueKey) in localValue" 
                :key="`${name}[${valueKey}]`"
                class="form-input p-3 mt-2"
            >
                <div class="flex justify-end w-full">
                    <div class="group relative w-6 hover:w-20 focus:w-20 tranform duration-300" tabindex="1" :ref="`actions.${valueKey}`">
                        <div 
                            v-if="valueKey > 0" 
                            class="absolute block rounded-full bg-blue-600 p-1 cursor-pointer" 
                            @click.prevent="moveRowUp(valueKey)"
                        >
                            <svg class="fill-current text-white w-4 h-4" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#4CAF50;" d="M263.432,3.136c-4.16-4.171-10.914-4.179-15.085-0.019c-0.006,0.006-0.013,0.013-0.019,0.019 l-192,192c-4.093,4.237-3.975,10.99,0.262,15.083c4.134,3.992,10.687,3.992,14.82,0L245.213,36.416v464.917 c0,5.891,4.776,10.667,10.667,10.667c5.891,0,10.667-4.776,10.667-10.667V36.416l173.781,173.781 c4.093,4.237,10.845,4.355,15.083,0.262c4.237-4.093,4.354-10.845,0.262-15.083c-0.086-0.089-0.173-0.176-0.262-0.262L263.432,3.136 z"/><path d="M447.88,213.333c-2.831,0.005-5.548-1.115-7.552-3.115L255.88,25.749L71.432,210.219c-4.237,4.093-10.99,3.975-15.083-0.262 c-3.992-4.134-3.992-10.687,0-14.82l192-192c4.165-4.164,10.917-4.164,15.083,0l192,192c4.159,4.172,4.149,10.926-0.024,15.085 C453.409,212.214,450.702,213.333,447.88,213.333z"/><path d="M255.88,512c-5.891,0-10.667-4.776-10.667-10.667V10.667C245.213,4.776,249.989,0,255.88,0 c5.891,0,10.667,4.776,10.667,10.667v490.667C266.546,507.224,261.771,512,255.88,512z"/></svg>
                        </div>
                        <div 
                            v-if="valueKey < localValue.length - 1" 
                            class="transform -translate-x-1/2 absolute block rounded-full bg-blue-600 p-1 cursor-pointer" 
                            style="left: 50%" 
                            @click.prevent="moveRowDown(valueKey)"
                        >
                            <svg class="fill-current text-white w-4 h-4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#FFC107;" d="M440.437,301.781L266.656,475.584V10.667C266.656,4.776,261.88,0,255.989,0 c-5.891,0-10.667,4.776-10.667,10.667v464.917L71.541,301.781c-4.237-4.093-10.99-3.975-15.083,0.262 c-3.992,4.134-3.992,10.687,0,14.82l192,192c4.16,4.171,10.914,4.179,15.085,0.019c0.006-0.006,0.013-0.013,0.019-0.019l192-192 c4.093-4.237,3.975-10.99-0.262-15.083c-4.134-3.993-10.687-3.993-14.821,0L440.437,301.781z"/><path d="M255.989,512c-2.831,0.005-5.548-1.115-7.552-3.115l-192-192c-4.093-4.237-3.975-10.99,0.262-15.083 c4.134-3.992,10.687-3.992,14.82,0l184.469,184.448l184.448-184.448c4.237-4.093,10.99-3.975,15.083,0.262 c3.993,4.134,3.993,10.687,0,14.821l-192,192C261.521,510.879,258.813,511.999,255.989,512z"/><path d="M255.989,512c-5.891,0-10.667-4.776-10.667-10.667V10.667C245.323,4.776,250.098,0,255.989,0 c5.891,0,10.667,4.776,10.667,10.667v490.667C266.656,507.224,261.88,512,255.989,512z"/></svg>
                        </div>
                        <div class="absolute block right-0 rounded-full bg-green-600 cursor-move move p-1 z-10" style="top: 50%; transform: translateY(-50%)">
                            <svg class="fill-current text-white w-4 h-4" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><polygon style="" points="56.25,62.5 56.25,81.25 68.75,81.25 50,100 31.25,81.25 43.75,81.25 43.75,62.5 "/><polygon style="" points="37.5,56.25 18.75,56.25 18.75,68.75 0,50 18.75,31.25 18.75,43.75 37.5,43.75 "/><polygon style="" points="43.75,37.5 43.75,18.75 31.25,18.75 50,0 68.75,18.75 56.25,18.75 56.25,37.5 "/><polygon style="" points="62.5,43.75 81.25,43.75 81.25,31.25 100,50 81.25,68.75 81.25,56.25 62.5,56.25 "/></svg>
                        </div>
                    </div>
                    <button class="rounded-full bg-red-600 p-1 ml-1" @click.prevent="removeRow(valueKey)">
                        <svg class="fill-current text-white w-4 h-4" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="24px" height="24px"><path d="M 24 4 C 20.491685 4 17.570396 6.6214322 17.080078 10 L 10.238281 10 A 1.50015 1.50015 0 0 0 9.9804688 9.9785156 A 1.50015 1.50015 0 0 0 9.7578125 10 L 6.5 10 A 1.50015 1.50015 0 1 0 6.5 13 L 8.6386719 13 L 11.15625 39.029297 C 11.427329 41.835926 13.811782 44 16.630859 44 L 31.367188 44 C 34.186411 44 36.570826 41.836168 36.841797 39.029297 L 39.361328 13 L 41.5 13 A 1.50015 1.50015 0 1 0 41.5 10 L 38.244141 10 A 1.50015 1.50015 0 0 0 37.763672 10 L 30.919922 10 C 30.429604 6.6214322 27.508315 4 24 4 z M 24 7 C 25.879156 7 27.420767 8.2681608 27.861328 10 L 20.138672 10 C 20.579233 8.2681608 22.120844 7 24 7 z M 11.650391 13 L 36.347656 13 L 33.855469 38.740234 C 33.730439 40.035363 32.667963 41 31.367188 41 L 16.630859 41 C 15.331937 41 14.267499 40.033606 14.142578 38.740234 L 11.650391 13 z M 20.476562 17.978516 A 1.50015 1.50015 0 0 0 19 19.5 L 19 34.5 A 1.50015 1.50015 0 1 0 22 34.5 L 22 19.5 A 1.50015 1.50015 0 0 0 20.476562 17.978516 z M 27.476562 17.978516 A 1.50015 1.50015 0 0 0 26 19.5 L 26 34.5 A 1.50015 1.50015 0 1 0 29 34.5 L 29 19.5 A 1.50015 1.50015 0 0 0 27.476562 17.978516 z"/></svg>
                    </button>
                    <div class="rounded bg-indigo-600 p-1 ml-1 flex items-center justify-center text-white">
                        <span class="h-4 leading-4 text-center" style="min-width: 1rem">{{ valueKey + 1 }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-3">
                    <input type="hidden" :name="`${name}[${valueKey}][order]`" :value="valueKey">
                    <component
                        :class="[`col-span-${field.widthSpan || 12}`]"
                        :is="field.component"
                        :key="`${name}[${valueKey}][${field.name}]`"
                        v-for="(field) in fields"
                        :value="localValue[valueKey][field.name]"
                        @input="newValue => onInput(valueKey, field.name, newValue)"
                        v-bind="filterProps({
                            ...mergeWithSchema(`${flatName}.${field.name}`, field), 
                            flatName: `${flatName}.${field.name}`,
                            name: `${name}[${valueKey}][${field.name}]`,
                            order: valueKey
                        })"
                    />
                </div>
            </div>
        </draggable>
        <button @click.prevent="addRow" class="rounded mt-2 py-1 px-3 bg-indigo-500 flex items-center justify-center">
            <svg class="fill-current text-white w-4 h-4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="15 15 60 60" xml:space="preserve"><g><path d="M45.2,17.8c-15.4,0-27.8,12.5-27.8,27.8c0,15.3,12.5,27.8,27.8,27.8C60.5,73.5,73,61,73,45.6C73,30.3,60.5,17.8,45.2,17.8z    M45.2,70.1c-13.5,0-24.5-11-24.5-24.5c0-13.5,11-24.5,24.5-24.5c13.5,0,24.5,11,24.5,24.5C69.7,59.1,58.7,70.1,45.2,70.1z"/><path d="M57.3,44H46.9V33.6c0-0.9-0.8-1.7-1.7-1.7s-1.7,0.8-1.7,1.7V44H33.1c-0.9,0-1.7,0.8-1.7,1.7s0.8,1.7,1.7,1.7h10.4v10.4   c0,0.9,0.8,1.7,1.7,1.7s1.7-0.8,1.7-1.7V47.3h10.4c0.9,0,1.7-0.8,1.7-1.7S58.2,44,57.3,44z"/></g></svg>
            <span class="ml-1 text-white">Adicionar</span>
        </button>
    </div>
</template>

<script>
import { Fragment } from 'vue-fragment'
import filterPropsMixin from '../mixins/FilterProps'
import Draggable from 'vuedraggable'
export default {
    mixins: [filterPropsMixin],
    components: {
        Fragment,
        Draggable
    },
    props: {
        name: String,
        label: String,
        component: String,
        flatName: String,
        fields: {
            type: Array,
            default: () => []
        },
        value: {
            type: Array,
            default: () => []
        },
        default: {
            type: Array,
            default: () => []
        },
        schema: Object
    },
    mounted() {
        this.localValue = this.value

        // if(!this.localValue.length) {
        //     this.addRow()
        // }
    },
    data: () => ({
        localValue: [],
        hoveringMove: false
    }),
    methods: {
        onInput(arrayIndex, fieldName, newValue) {
            this.$set(this.localValue[arrayIndex], fieldName, newValue)
            this.$nextTick(() => 
                this.$emit('input', this.localValue))
        },
        addRow() {
            this.localValue.push(
                this.fields.reduce((acc, field) => (acc[field.name] = field.value, acc), {}))

            this.$nextTick(() => 
                this.$emit('input', this.localValue))
        },
        removeRow(valueKey) {
            this.localValue.splice(valueKey, 1)
            this.$nextTick(() => 
                this.$emit('input', this.localValue)
            )
        },
        moveRowUp(valueKey) {
            this.localValue.move(valueKey, valueKey - 1)
            this.$nextTick(() => {
                const prevButtonMoveUp = this.$refs[`actions.${valueKey - 1}`]
                if(prevButtonMoveUp.length) prevButtonMoveUp[0].focus()
            })
        },
        moveRowDown(valueKey) {
            this.localValue.move(valueKey, valueKey + 1)
            this.$nextTick(() => {
                const prevButtonMoveUp = this.$refs[`actions.${valueKey + 1}`]
                if(prevButtonMoveUp.length) prevButtonMoveUp[0].focus()
            })
        }
    },
}
</script>

<style>

</style>