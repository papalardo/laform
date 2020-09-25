const kebabCase = string => string.replace(/([a-z])([A-Z])/g, '$1-$2').replace(/\s+/g, '-').toLowerCase()

const toPascalCase = (string) => `${string}`.replace(new RegExp(/[-_]+/, 'g'), ' ').replace(new RegExp(/[^\w\s]/, 'g'), '').replace(  new RegExp(/\s+(.)(\w+)/, 'g'),  ($1, $2, $3) => `${$2.toUpperCase() + $3.toLowerCase()}`).replace(new RegExp(/\s/, 'g'), '').replace(new RegExp(/\w/), s => s.toUpperCase());

const isObject = (val) => val != null && typeof val === 'object' && Array.isArray(val) === false;

const pick = (n,r) => {if(!isObject(n)&&"function"!=typeof n)return{};var t={};if("string"==typeof r)return r in n&&(t[r]=n[r]),t;for(var i=r.length,e=-1;++e<i;){var f=r[e];f in n&&(t[f]=n[f])}return t}

export default {
    data: () => ({
        defaultProps: [
            'onCreated',
        ]
    }),
    methods: {
        filterProps(field) {
            const componentProps = Object.keys(this.getComponentProps(field.component) || {}).concat(...this.defaultProps)
            return pick(field, componentProps)
        },
        getComponentProps(componentName) {
            const component = this.$root.$options.components[toPascalCase(componentName)] || this.$root.$options.components[kebabCase(componentName)] || null
            if(!component) {
                console.warn(`Component [${componentName}] not found`)
                return null;
            }
            return component.options.props
        },
        mergeWithSchema(componentName, props) {
            return Object.assign({}, props, this.schema[componentName] || {}, { schema: this.schema })
        }
    }
}