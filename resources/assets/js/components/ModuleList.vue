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
                <module-panel :module="module" v-for="module in modules"></module-panel>
            </div>
        
        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                loading: false,
                modules: []
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