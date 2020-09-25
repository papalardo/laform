<script>
import Vue from 'vue'
import Laform from '../mixins/Laform'
export default {
    mixins: [Laform],
    data: () => ({
        schema: {
            'nested_field.options': {
                trackBy: 'name',
                slots: {
                    option: Vue.extend({
                        props: ['el$', 'option'],
                        template: `<option>{{ option }} + hellow</option>`
                    })
                },
                // onCreated() {
                //     this.$on('inputChanged', (value) => {
                //         console.log('value ==>', value)
                //     })
                // }
            }
        }
    })
}
</script>

<style>

</style>