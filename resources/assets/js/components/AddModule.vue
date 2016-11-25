<template>
    <div class="add-module">
        <div class="jumbotron">
            <div class="container">
                <h1> Add your Module</h1>
            </div>
        </div>
        <div class="container">



        
            <ul class="text-xs-center img-thumbnail wizard-steps">
                <div class="row">
                    <div class="col-md-6 wizard-step" >
                        <a href="#" class="wizard-step-link" :class="{'active': step == 1}" @click.prevent="step = 1">
                            <h4>Step 1</h4>
                            <p>Select repository</p>
                        </a>
                    </div>
                    <div class="col-md-6 wizard-step" >
                        <a href="#" class="wizard-step-link" :class="{'disabled':!moduleInformation, 'active': step == 2}" @click.prevent="step = (!moduleInformation) ? 1 : 2">
                            <h4>Step 2</h4>
                            <p>Enter Module Info</p>
                        </a>
                    </div>
                </div>
            </ul>
                    
            <div class="list-group" v-if="step == 1">
                <div class="list-group-item header">
                    <h3>Select Repository</h3>
                    <p>Please select the repository of the MagicMirror² Module you want to add.</p>
                </div>

                <div class="list-group-item text-sm-center" v-if="loading">
                    <i class="fa fa-spinner fa-pulse fa-fw"></i> Loading repositories &hellip;
                </div>

                <a href="#" class="list-group-item list-group-item-action" v-for="repository in repositories" @click.prevent="selectRepository(repository)" :class="{'disabled':repository.magicmirror_id > 0}">
                    <!--<a href="#" class="btn btn-default btn-xs pull-right" type="button" @click.stop.prevent="openURL(repository.html_url)"><i class="fa fa-fw fa-eye"></i></a>-->
                    <h5 class="list-group-item-heading">{{repository.name}}</h5>
                    <p class="list-group-item-text">{{repository.description}}</p>
                </a>
            </div>

            <div class="list-group" v-if="step == 2 && moduleInformation">
                <div class="list-group-item header">
                    <h3>Enter Module Information</h3>
                    <p>Please enter or modify the information about your module down below.</p>
                </div>
                <div class="list-group-item">
                    <module-edit-form :module="moduleInformation"></module-edit-form>
                    
                    <pre>{{moduleInformation}}</pre>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                step: 1,
                loading: false,
                saving: false,
                categories: [],
                repositories: [],
                tagSuggestions: [],
                moduleInformation: false,
                errors: {},
            }
        },
        components: {
            'moduleEditForm': require('./ModuleEditForm.vue')
        },
        methods: {
            fetchRepositories() {
                var _this = this;
                _this.loading = true;
                this.$http.get('/api/me/repositories').then((response) => {
                    _this.errors = {};
                    _this.loading = false;
                    _this.repositories = response.data;
                }, (response) => {
                    _this.loading = false;
                    console.error(response);
                })
            },
            selectRepository(repository) {
                if (repository.magicmirror_id > 0) {
                    return;
                }
                this.errors = {};
                this.moduleInformation = {
                    github_user: repository.owner.login,
                    github_name: repository.name,
                    name: repository.name.replace(/^[m]{2,3}[_\- ]/i, ""),
                    description: repository.description,
                    link: repository.html_url,
                    image: '',
                    category_id: 1
                }

                this.step = 2;
            }     
        },
        mounted() {
            this.fetchRepositories();

            var _this = this;
            this.$on("SAVED", function(module) {
                alert('module created, navigate to page');
            })
        }
    }
</script>