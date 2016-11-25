<template>
    <div class="module-list">
        <div class="jumbotron">
            <div class="container">
                <h1>MagicMirror² Modules</h1>
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
    </div>
</template>
<script>

    import userStore from './../store/user.js';

    export default {
        data() {
            return {
                loading: false,
                modules: []
            }
        },
        computed: {
            user() {
                return userStore.state.user;
            }
        },
        methods: {
            fetchModules() {
                var _this = this;
                _this.loading = true;
                this.$http.get('/api/module').then((response) => {
                    _this.loading = false;
                    _this.modules = response.data;
                }, (response) => {
                    _this.loading = false;
                    console.error(response);
                })
            },
        },
        mounted() {
            this.fetchModules();
        }
    }
</script>