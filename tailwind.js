module.exports = {
    purge: [],
    theme: {
        scale: Array.from({length:10},(v,k)=>k+1).reduce((acc, index) => (acc[String(`${index}00`)] = String(index), acc), {}),
        extend: {},
    },
    variants: {},
    plugins: [
        require('@tailwindcss/custom-forms')
    ],
}