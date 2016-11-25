
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

Vue.component('navBar', require('./components/NavBar.vue'));


Vue.component('homeComponent', require('./components/HomeComponent.vue'));
Vue.component('moduleList', require('./components/ModuleList.vue'));
Vue.component('showModule', require('./components/ShowModule.vue'));
Vue.component('addModule', require('./components/AddModule.vue'));


Vue.component('modulePanel', require('./components/ModulePanel.vue'));

Vue.component('imageUploader', require('./components/ImageUploader.vue'));

const routes = [
  { path: '/', component: { template: '<home-component></home-component>' }},
  { path: '/modules', component: { template: '<module-list></module-list>' }},
  { path: '/module/add', component: { template: '<add-module></add-module>' }},
  { path: '/module/:id', component: { template: '<show-module :module-id="$route.params.id" :user="user"></show-module>' }},
  { path: '/module/:id/:name', component: { template: '<show-module :module-id="$route.params.id" :user="user"></show-module>' }},
]

const router = new VueRouter({
    mode: 'history',
    routes // short for routes: routes
})

const app = new Vue({
    el: '#app',
    router,
    data: {
        user: null
    },
    methods: {
        fetchUser() {
            var _this = this;
            _this.$http.get('/api/me').then((response) => {
                _this.user = response.data;
            })
        },
        logout() {
            var _this = this;
            this.$http.post('/logout').then((response) => {
                _this.user = null;
                _this.$router.push('/');
            });
        }
    },
    mounted() {
        var _this = this;
        _this.$on('logout', function () {
            _this.logout();
        })
        _this.fetchUser();
    }
});
