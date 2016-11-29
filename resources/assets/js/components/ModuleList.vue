<template>
    <div class="module-list">
        <div class="jumbotron">
            <div class="container">
                <h1>MagicMirror² Modules</h1>
                <p class="lead">Want to add some features to your mirror? Check out these modules &hellip;</p>
            </div>
        </div>
        
        <div class="filter-bar" v-if="filter.tag || filter.category || filter.user">
            <div class="container">
                <router-link to="/modules"> 
                    <div v-if="filter.tag">You are currently filtering on tag: <strong>{{filter.tag}}</strong>.</div>
                    <div v-if="filter.category && categories[filter.category]">You are currently filtering on category: <strong>{{categories[filter.category]}}</strong>.</div>
                    <div v-if="filter.user">You are currently filtering on user: <strong>{{filter.user}}</strong>.</div>
                    <small>Click here to remove filter.</small>
                </router-link>
            </div>
        </div>

        <div class="container">

            <ul class="list-group" v-if="loading">
                <li class="list-group-item text-xs-center text-muted">
                    <i class="fa fa-spinner fa-pulse fa-fw"></i> Loading modules &hellip;
                </li>
            </ul>

            <div class="card-columns">

                <div class="card card-inverse text-xs-center" style="background-color: #333; border-color: #333;" v-if="user">
                    <div class="card-block">
                        <h3 class="card-title">Are you a developer?</h3>
                        <p class="card-text">Create your own modules and add them to the list!</p>
                        <router-link to="/module/add" class="btn btn-primary"><i class="fa fa-fw fa-plus-circle" aria-hidden="true"></i> Add Your Module</router-link>
                    </div>
                </div>

                <module-panel :module="module" v-for="module in modules"></module-panel>
   
            </div>

        </div>
        <div class="container" v-if="loadMoreButton">
            <div class="row">
                <div class="col-sm-4 offset-sm-4">
                    <button class="btn btn-secondary btn-block" @click="fetchModules">Load more &hellip;</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import userStore from './../store/user.js';
    import categoryStore from './../store/category.js';

    export default {
        data() {
            return {
                loading: false,
                modules: [],
                loadMoreButton: false,
                filter: this.$route.query
            }
        },
        computed: {
            user() {
                return userStore.state.user;
            },
            categories() {
                var categories = {};
                categoryStore.state.categories.forEach((category) => {
                    categories[category.id] = category.name;
                });

                return categories;
            }
        },
        methods: {
            fetchModules() {
                var params = {
                    offset: this.modules.length,
                    limit: 25,
                }
                if (this.filter) {
                    params.filter = this.filter;
                }

                this.loading = true;
                this.loadMoreButton = false;
                this.$http.get('/api/module', {params: params}).then((response) => {
                    this.loading = false;
                    this.modules = this.modules.concat(response.data);
                    this.loadMoreButton = response.data.length === params.limit;
                }, (response) => {
                    this.loading = false;
                    console.error(response);
                })
            },
        },
        mounted() {
            this.fetchModules();
        },
        watch: {
            filter: {
                handler() {
                    this.modules = [];
                    this.fetchModules();
                }, 
                deep: true
            },
            '$route.query': function(query) {
                this.filter = query
            }
        }
    }
</script>

<style lang="sass">
    .filter-bar {

        background: #0275d8;
        margin-top: -2rem;
        margin-bottom: 2rem;
        a {
            padding: 10px 0;
            display:block;
            text-align: center;
            color: lighten(#0275d8, 50%);
            strong {
                color: white;
            }
            small {
                color: lighten(#0275d8, 25%);
            }
        }
        a:hover {
            text-decoration: none;
        }
        
    }
</style>