<template>
    <div class="container add-module">
        
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

            <div class="list-group-item text-center" v-if="loading">
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
                <form @submit.prevent="saveModule()">
                    
                    <div class="form-group row" :class="{'has-danger': errors.github_url}">
                        <label for="moduleURL" class="col-md-2 col-form-label">Module URL</label>
                        <div class="col-md-10">
                            <div class="alert alert-danger" v-if="errors.github_url"><i class="fa fa-exclamation-triangle"></i> {{errors.github_url[0]}}</div>
                            <div class="input-group">
                                <input type="text" class="form-control disabled" id="moduleURL" placeholder="URL" disabled="true" :value="generateGithubUrl(moduleInformation)">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button" @click.prevent="openURL(generateGithubUrl(moduleInformation))"><i class="fa fa-fw fa-eye"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row" :class="{'has-danger': errors.name}">
                        <label for="moduleName" class="col-md-2 col-form-label">Module Name</label>
                        <div class="col-md-10">
                            <div class="alert alert-danger" v-if="errors.name"><i class="fa fa-exclamation-triangle"></i> {{errors.name[0]}}</div>
                            <input type="text" class="form-control" id="moduleName" placeholder="Name"  v-model="moduleInformation.name" maxlength="50">
                            <div class="help-block">Give your module a nice name. Please leave away the common <code>MMM-</code> part.</div>
                        </div>
                    </div>
                    <div class="form-group row" :class="{'has-danger': errors.description}">
                        <label for="moduleDescription" class="col-md-2 col-form-label">Description</label>
                        <div class="col-md-10">
                            <div class="alert alert-danger" v-if="errors.description"><i class="fa fa-exclamation-triangle"></i> {{errors.description[0]}}</div>
                            <textarea class="form-control" rows="5" placeholder="Description" v-model="moduleInformation.description" maxlength="256"></textarea>
                            <div class="help-block">Please describe your module functionalities in 256 characters or less.</div>
                        </div>
                    </div>
                    <div class="form-group row" :class="{'has-danger': errors.link}">
                        <label for="moduleLink" class="col-md-2 col-form-label">More Info URL</label>
                        <div class="col-md-10">
                            <div class="alert alert-danger" v-if="errors.link"><i class="fa fa-exclamation-triangle"></i> {{errors.link[0]}}</div>
                            <input type="text" class="form-control" id="moduleLink" placeholder="URL" v-model="moduleInformation.link">
                            <div class="help-block">Where can we find more information? This can be your website, a forum topic or the GitHub page.</div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row" :class="{'has-danger': errors.image}">
                        <label for="moduleLink" class="col-md-2 col-form-label">Image</label>
                        <div class="col-md-5">
                            <div class="alert alert-danger" v-if="errors.image"><i class="fa fa-exclamation-triangle"></i> {{errors.image[0]}}</div>
                            <image-uploader v-model="moduleInformation.image" base-path="/file/"></image-uploader>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <div class="offset-md-2 col-md-10">
                            <button type="submit" class="btn btn-primary btn-lg" :disabled="moduleInformation.name.length <= 0">
                                <i class="fa fa-fw fa-save" aria-hidden="true"></i> Save Module
                            </button>
                        </div>
                    </div>
                </form>
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
                repositories: [],
                moduleInformation: false,
                errors: {}
            }
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
                    image: ''
                }

                this.step = 2;
            },
            saveModule() {
                var _this = this;
                
                if (_this.moduleInformation.name.length <= 0) {
                    return;
                }

                _this.saving = true;
                this.$http.post('/api/module', _this.moduleInformation).then((response) => {
                    _this.saving = false;
                    if (response.data && response.data.id) {
                        window.location.href = "/module/" + response.data.id;
                    }
                }, (response) => {
                    _this.saving = false;
                    _this.errors = response.data || {};
                    console.error(response);
                })
            },
            openURL(url) {
                window.open(url);
            },
            generateGithubUrl(moduleInformation) {
                return 'https://github.com/' + moduleInformation.github_user + '/' + moduleInformation.github_name;
            }
        },
        mounted() {
            this.fetchRepositories();
        }
    }
</script>