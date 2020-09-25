/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Object.defineProperty(Array.prototype, 'move', {
    value: function (old_index, new_index) {
        while (old_index < 0) {
            old_index += this.length;
        }
        while (new_index < 0) {
            new_index += this.length;
        }
        if (new_index >= this.length) {
            let k = new_index - this.length;
            while ((k--) + 1) {
                this.push(undefined);
            }
        }
        this.splice(new_index, 0, this.splice(old_index, 1)[0]);
        return this;
    }
});

Vue.component('la-form', require('./components/mixins/Laform.js').default)

Vue.component('input-field', require('./components/fields/InputField.vue').default);
Vue.component('hidden-field', require('./components/fields/HiddenField.vue').default);
Vue.component('nested-field', require('./components/fields/NestedField.vue').default);
Vue.component('repeated-field', require('./components/fields/RepeatedField.vue').default);
Vue.component('select-field', require('./components/fields/SelectField.vue').default);
Vue.component('rich-select-field', require('./components/fields/RichSelectField.vue').default);
Vue.component('date-time-picker-field', require('./components/fields/DateTimePickerField.vue').default);
Vue.component('image-upload-field', require('./components/fields/ImageUploadField.vue').default);

Vue.component('user-edit-form', require('./components/forms/UserEdit.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
