import toFormData from '../../helpers/object-to-form-data'
import filterPropsMixin from '../mixins/FilterProps'
export default {
    mixins: [filterPropsMixin],
    props: {
        form: Object
    },
    data: () => ({
        schema: {},
        formData: {}
    }),
    template: `
        <form @submit.prevent="onSubmit">
            <div class="grid grid-cols-12 gap-3">
                <component
                    :class="['col-span-' + (field.widthSpan || 12)]"
                    v-for="(field, fieldIndex) in form.fields"
                    :key="fieldIndex"
                    v-model="formData[field.name]"
                    :is="field.component"
                    v-bind="filterProps({
                        ...mergeWithSchema(field.component, field),
                        flatName: field.name
                    })"
                >
                <template v-for="(slot, name) in (field.slots || [])" :slot="name" slot-scope="slotData">
                    <component
                        :is="extend({
                            props: slot.props,
                            template: slot.template
                        })" 
                        v-bind="slotData"
                    />
                </template>
                </component>
            </div>
            <button type="submit">Submit</button>
        </form>
    `,
    created() {
        this.form.fields.forEach(field => {
            this.$set(this.formData, field.name, (field.value || field.default))
        })
    },
    methods: {
        onSubmit() {
            const headers = {
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded'
            }
            axios.post('/post', toFormData(this.formData, { indices: true }), { headers })
        },
        extend(props) {
            return Vue.extend(props)
        }
    }
}