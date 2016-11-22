
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('Multiselect', require('vue-multiselect'));
Vue.component('Multiselect', require('vue-multiselect').default);

Vue.component('moduleList', require('./components/ModuleList.vue'));
Vue.component('modulePanel', require('./components/ModulePanel.vue'));
Vue.component('addModule', require('./components/AddModule.vue'));
Vue.component('imageUploader', require('./components/ImageUploader.vue'));
Vue.component('showModule', require('./components/ShowModule.vue'));
Vue.component('readmeViewer', require('./components/ReadmeViewer.vue'));

const app = new Vue({
    el: '#app'
});
