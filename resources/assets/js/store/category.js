import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        categories: []
    },
    mutations: {
        fetchCategories(state, categories) {
            state.categories = categories;
        },
    },
    actions: {
        fetchCategories(context) {
            Vue.http.get('/api/category').then((response) => {
                context.commit('fetchCategories', response.data);
            });   
        }
    }
})


