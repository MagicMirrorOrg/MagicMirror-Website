<template>
    <div class="container add-module">
        <div class="row">
            <div class="col-md-12">

                <div class="row form-group">
                    <div class="col-xs-12">
                        <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                            <li :class="{'active': step == 1}">
                                <a href="#" @click.prevent="step = 1">
                                    <h4 class="list-group-item-heading">Step 1</h4>
                                    <p class="list-group-item-text">Select repository</p>
                                </a>
                            </li>
                            <li :class="{'disabled':!moduleInformation, 'active': step == 2}">
                                <a href="#" @click.prevent="step = (!moduleInformation) ? 1 : 2">
                                    <h4 class="list-group-item-heading">Step 2</h4>
                                    <p class="list-group-item-text">Enter Module Info</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="list-group" v-if="step == 1">
                    <div class="list-group-item header">
                        <h3>Select Repository</h3>
                        <p>Please select the repository of the MagicMirror² Module you want to add.</p>
                    </div>

                    <div class="list-group-item text-center" v-if="loading">
                        <i class="fa fa-spinner fa-pulse fa-fw"></i> Loading repositories &hellip;
                    </div>

                    <a href="#" class="list-group-item" v-for="repository in repositories" @click.prevent="selectRepository(repository)">
                        <!--<a href="#" class="btn btn-default btn-xs pull-right" type="button" @click.stop.prevent="openURL(repository.html_url)"><i class="fa fa-fw fa-eye"></i></a>-->
                        <h4 class="list-group-item-heading">{{repository.name}}</h4>
                        <p class="list-group-item-text">{{repository.description}}</p>
                    </a>
                </div>


                <div class="list-group" v-if="step == 2 && moduleInformation">
                    <div class="list-group-item header">
                        <h3>Enter Module Information</h3>
                        <p>Please enter or modify the information about your module down below.</p>
                    </div>
                    <div class="list-group-item">
                        <form class="form-horizontal" @submit.prevent="saveModule()">
                            
                            <div class="form-group" :class="{'has-error': errors.github_url}">
                                <label for="moduleURL" class="col-sm-2 control-label">Module URL</label>
                                <div class="col-sm-10">
                                    <div class="alert alert-danger" v-if="errors.github_url"><i class="fa fa-exclamation-triangle"></i> {{errors.github_url[0]}}</div>
                                    <div class="input-group">
                                        <input type="text" class="form-control disabled" id="moduleURL" placeholder="URL" disabled="true" v-model="moduleInformation.github_url" @change="">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" @click.prevent="openURL(moduleInformation.github_url)"><i class="fa fa-fw fa-eye"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group" :class="{'has-error': errors.name}">
                                <label for="moduleName" class="col-sm-2 control-label">Module Name</label>
                                <div class="col-sm-10">
                                    <div class="alert alert-danger" v-if="errors.name"><i class="fa fa-exclamation-triangle"></i> {{errors.name[0]}}</div>
                                    <input type="text" class="form-control" id="moduleName" placeholder="Name"  v-model="moduleInformation.name" maxlength="50">
                                    <span id="helpBlock" class="help-block">Give your module a nice name. Please leave away the common <code>MMM-</code> part.</span>
                                </div>
                            </div>
                            <div class="form-group" :class="{'has-error': errors.description}">
                                <label for="moduleDescription" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <div class="alert alert-danger" v-if="errors.description"><i class="fa fa-exclamation-triangle"></i> {{errors.description[0]}}</div>
                                    <textarea class="form-control" rows="5" placeholder="Description" v-model="moduleInformation.description" maxlength="1000"></textarea>
                                    <span id="helpBlock" class="help-block">Please describe your module functionalities in 1000 characters or less.</span>
                                </div>
                            </div>
                            <div class="form-group" :class="{'has-error': errors.link}">
                                <label for="moduleLink" class="col-sm-2 control-label">More Info</label>
                                <div class="col-sm-10">
                                    <div class="alert alert-danger" v-if="errors.link"><i class="fa fa-exclamation-triangle"></i> {{errors.link[0]}}</div>
                                    <input type="text" class="form-control" id="moduleLink" placeholder="URL" v-model="moduleInformation.link">
                                    <span id="helpBlock" class="help-block">Where can we find more information? This can be your website, a forum topic or the GitHub page.</span>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group" :class="{'has-error': errors.image}">
                                <label for="moduleLink" class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-5">
                                    <div class="alert alert-danger" v-if="errors.image"><i class="fa fa-exclamation-triangle"></i> {{errors.image[0]}}</div>
                                    <image-uploader v-model="moduleInformation.image" base-path="/file/"></image-uploader>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" :disabled="moduleInformation.name.length <= 0">
                                        <i class="fa fa-fw fa-save" aria-hidden="true"></i> Save Module
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
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
                this.errors = {};
                this.moduleInformation = {
                    github_url: repository.html_url,
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
                    alert('saved');
                }, (response) => {
                    _this.saving = false;
                    _this.errors = response.data || {};
                    console.error(response);
                })
            },
            openURL(url) {
                window.open(url);
            }
        },
        mounted() {
            this.fetchRepositories();
        }
    }
</script>