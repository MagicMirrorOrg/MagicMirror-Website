<template>
    <div>
        <div class="show-module" v-if="module">
            <div class="jumbotron">
                <div class="container">
                    <div class="col-md-6 col-xs-12">
                        <h1>{{module.name}}</h1>
                        <p class="lead">{{module.description}}</p>
                    </div>
                </div>
            </div>
            
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <module-edit-form :module="module" v-if="editMode"></module-edit-form>
                        <readme-viewer :module="module" v-if="!editMode"></readme-viewer>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-block edit-button" 
                            @click.prevent="editMode = !editMode" 
                            :class="{'btn-secondary':!editMode,'btn-success':editMode}"
                            v-if="user.github_user == module.github_user || user.admin">
                                <i class="fa fa-edit" aria-hidden="true"></i> Edit Module
                        </button>
                        <module-panel :module="module"></module-panel>
                        <a :href="module.github_url" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-github" aria-hidden="true"></i> GitHub Repository</a>
                        <a :href="module.link" target="_blank" class="btn btn-outline-primary btn-block" v-if="module.link && module.link != module.github_url"><i class="fa fa-info-circle" aria-hidden="true"></i> More Info</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>
<script>

    import userStore from './../store/user.js';

    export default {
        props: {
            moduleId: {
                required: true,
                default: null
            } 
        },
        computed: {
            user() {
                return userStore.state.user;
            }
        },
        components: {
            'readmeViewer': require('./ReadmeViewer.vue'),
            'moduleEditForm': require('./ModuleEditForm.vue')
        },
        data() {
            return {
                editMode: false,
                module: false,
                loading: false,
            }
        },
        methods: {
            fetchModule() {
                var _this = this;
                _this.loading = true;
                this.$http.get("/api/module/" + this.moduleId).then((response) => {
                    _this.loading = false;
                    _this.module = response.data;
                }, (response) => {
                    _this.loading = false;
                    console.error(response);
                })
            }
        },
        created() {
            this.fetchModule();
            var _this = this;
            this.$on("SAVED", function(module) {
                _this.editMode = false;
                _this.module = module;
            })
            this.$on("CANCEL_EDIT", function(module) {
                _this.editMode = false;
            })
        }
    }
</script>

<style scoped>
    .edit-button {
        margin-bottom: 10px;
    }
</style>