export const propsDefinitions = {
    'input-field': {
        name: String,
        label: String,
    },
    'select-field': {
        name: String,
        label: String,
        component: String,
        options: {
            type: Object,
            default: () => []
        }
    },
    'nested-field': {
        name: String,
        label: String,
        component: String,
        linearName: String,
        fields: {
            type: Array,
            default: () => []
        },
        value: {
            type: Array,
            default: () => []
        }
    }
}

export function getPropsByComponentName(componentName) {
    return propsDefinitions[componentName] || null
}