
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




Vue.component('navBar', require('./components/NavBar.vue'));

Vue.component('homeComponent', require('./components/HomeComponent.vue'));
Vue.component('moduleList', require('./components/ModuleList.vue'));
Vue.component('showModule', require('./components/ShowModule.vue'));
Vue.component('addModule', require('./components/AddModule.vue'));

Vue.component('modulePanel', require('./components/ModulePanel.vue'));


import userStore from './store/user.js';

const routes = [
  { path: '/', component: { template: '<home-component></home-component>' }},
  { path: '/modules', component: { template: '<module-list></module-list>' }},
  { path: '/module/add', component: { template: '<add-module></add-module>' }},
  { path: '/module/:id', component: { template: '<show-module :module-id="$route.params.id"></show-module>' }},
  { path: '/module/:id/:name', component: { template: '<show-module :module-id="$route.params.id"></show-module>' }},
]

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router,
    mounted() {
        userStore.dispatch('fetchUser');
    }
});
