import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: null
    },
    mutations: {
        fetchUser(state, user) {
            state.user = user;
        },
        logout(state) {
            state.user = null;
        }
    },
    actions: {
        fetchUser(context) {
            Vue.http.get('/api/me').then((response) => {
                context.commit('fetchUser', response.data);
            });
        },
        logout(context) {
            Vue.http.post('/logout').then((response) => {
                context.commit('logout');
            });
        }
    }
})