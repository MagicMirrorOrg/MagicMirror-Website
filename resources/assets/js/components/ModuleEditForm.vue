<template>
    <div v-if="module">
        <form @submit.prevent="saveModule()">
            <div class="form-group row" :class="{'has-danger': errors.github_url}">
                <label for="moduleURL" class="col-md-2 col-form-label">Module URL</label>
                <div class="col-md-10">
                    <div class="alert alert-danger" v-if="errors.github_url"><i class="fa fa-exclamation-triangle"></i> {{errors.github_url[0]}}</div>
                    <div class="input-group">
                        <input type="text" class="form-control disabled" id="moduleURL" placeholder="URL" disabled="true" :value="generateGithubUrl(moduleCopy)">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button" @click.prevent="openURL(generateGithubUrl(moduleCopy))"><i class="fa fa-fw fa-eye"></i></button>
                        </span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="form-group row" :class="{'has-danger': errors.name}">
                <label for="moduleName" class="col-md-2 col-form-label">Module Name</label>
                <div class="col-md-10">
                    <div class="alert alert-danger" v-if="errors.name"><i class="fa fa-exclamation-triangle"></i> {{errors.name[0]}}</div>
                    <input type="text" class="form-control" id="moduleName" placeholder="Name"  v-model="moduleCopy.name" maxlength="50">
                    <div class="help-block">Give your module a nice name. Please leave away the common <code>MMM-</code> part.</div>
                </div>
            </div>
            <div class="form-group row" :class="{'has-danger': errors.description}">
                <label for="moduleDescription" class="col-md-2 col-form-label">Description</label>
                <div class="col-md-10">
                    <div class="alert alert-danger" v-if="errors.description"><i class="fa fa-exclamation-triangle"></i> {{errors.description[0]}}</div>
                    <textarea class="form-control" rows="5" placeholder="Description" v-model="moduleCopy.description" maxlength="256"></textarea>
                    <div class="help-block">Please describe your module functionalities in 256 characters or less.</div>
                </div>
            </div>
            <div class="form-group row" :class="{'has-danger': errors.link}">
                <label for="moduleLink" class="col-md-2 col-form-label">More Info URL</label>
                <div class="col-md-10">
                    <div class="alert alert-danger" v-if="errors.link"><i class="fa fa-exclamation-triangle"></i> {{errors.link[0]}}</div>
                    <input type="text" class="form-control" id="moduleLink" placeholder="URL" v-model="moduleCopy.link">
                    <div class="help-block">Where can we find more information? This can be your website, a forum topic or the GitHub page.</div>
                </div>
            </div>

            <hr>

            <div class="form-group row" :class="{'has-danger': errors.image}">
                <label for="moduleLink" class="col-md-2 col-form-label">Image</label>
                <div class="col-md-5">
                    <div class="alert alert-danger" v-if="errors.image"><i class="fa fa-exclamation-triangle"></i> {{errors.image[0]}}</div>
                    <image-uploader v-model="moduleCopy.image" base-path="/file/"></image-uploader>
                </div>
            </div>

            <hr>

            <div class="form-group row" :class="{'has-danger': errors.github_url}">
                <label for="moduleURL" class="col-md-2 col-form-label">Category</label>
                <div class="col-md-10">
                    <select class="custom-select"  v-model="moduleCopy.category_id">
                        <option v-for="category in categories" v-bind:value="category.id">{{category.name}}</option>
                    </select>
                </div>
            </div>

            <div class="form-group row" :class="{'has-danger': errors.tags}">
                <label for="moduleLink" class="col-md-2 col-form-label">Tags</label>
                <div class="col-md-5">
                    <multiselect    v-model="moduleCopy.tags" 
                                    :options="tagSuggestions" 
                                    :multiple="true" 
                                    :taggable="true" 
                                    :hideSelected="true"
                                    :closeOnSelect="false"
                                    :max="10"
                                    input-filter="[^a-zA-Z0-9-]"
                                    tag-placeholder="Add this as new tag" 
                                    placeholder="Add tags"
                                    @search-change="searchTags">
                    </multiselect>
                </div>
            </div>

            <hr>

            <div class="form-group row">
                <div class="offset-md-2 col-md-10">
                    <button type="submit" class="btn btn-primary btn-lg" :disabled="moduleCopy.name.length <= 0 || saving">
                        <i class="fa fa-fw fa-save" aria-hidden="true"></i> Save Module
                    </button>
                    <button @click.prevent="$parent.$emit('CANCEL_EDIT')" class="btn btn-secondary btn-lg" :disabled="saving" v-if="moduleCopy.id > 0">
                        <i class="fa fa-fw fa-ban" aria-hidden="true"></i> Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        props: ['module'],
        components: {
            imageUploader: require('./ImageUploader.vue'),
            multiselect: require('vue-multiselect').default
        },
        data() {
            return {
                saving: false,
                errors: {},
                categories: [],
                tagSuggestions: [],
            }
        },
        computed: {
            moduleCopy: function() {
                return Vue.util.extend({}, this.module);
            }
        },
        methods: {
            fetchCategories() {
                var _this = this;
                this.$http.get('/api/category').then((response) => {
                    _this.categories = response.data;
                }, (response) => {
                    console.error("Could not load categories.");
                    console.error(response);
                })
            },
            saveModule() {
                var _this = this;
                
                if (_this.moduleCopy.name.length <= 0) {
                    return;
                }

                _this.saving = true;

                var method = (_this.moduleCopy.id > 0) ? "put" :"post";
                var url = (_this.moduleCopy.id > 0) ? "/api/module/" + _this.moduleCopy.id : "/api/module";

                _this.$http[method](url, _this.moduleCopy).then((response) => {
                    _this.saving = false;
                    if (response.data) {
                        _this.$parent.$emit('SAVED', response.data);
                    }
                }, (response) => {
                    _this.saving = false;
                    _this.errors = response.data || {};
                    console.error(response);
                })
            },
            generateGithubUrl(module) {
                return 'https://github.com/' + module.github_user + '/' + module.github_name;
            },
            searchTags(query) {
                if (query.length < 2 ) {
                    this.tagSuggestions = [];
                    return;
                }

                this.tagSuggestion = [query];

                var _this = this;
                _this.$http.get('/api/tag/' + query).then((response) => {
                    _this.tagSuggestions = response.data;
                    _this.tagSuggestions.splice(0, 0, query);
                });
            },
            openURL(url) {
                window.open(url);
            }
        },
        mounted() {
            this.fetchCategories();
        }
    }
</script>