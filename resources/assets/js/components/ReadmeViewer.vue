<template>
    <div>
        <div class="readme">
            <div v-if="loading" class="readme-loading">
                <i class="fa fa-spinner fa-pulse fa-fw"></i> Loading readme &hellip;
            </div>
            <div v-if="error" class="readme-error" @click="fetchReadme()">
                <i class="fa fa-frown-o"></i> Whoops! I couldn't find the readme for this module &hellip;
            </div>
            <div v-if="readme" class="readme-content"><div v-html="compiledReadme"></div></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['module'],
        data() {
            return {
                loading: false,
                readme: false,
                error: false
            }
        },
        computed: {
            compiledReadme() {
                var pkg = {
                    name: this.module.github_name,
                    description: this.module.description,
                    repository: {
                        type: "git",
                        url: this.module.github_url
                    }
                }

                return marky(this.readme, {
                    highlightSyntax: false,
                    package: pkg,
                    debug: false
                });

            }
        },
        methods: {
            fetchReadme() {
                var _this = this;

                var url = "/api/module/" + _this.module.id + "/readme";
                _this.loading = true;
                _this.error = false;

                this.$http.get(url).then((response) => {
                    _this.loading = false;
                    _this.readme = response.data;
                    console.log(response);
                }, (response) => {
                    _this.loading = false;
                    _this.error = true;
                    console.error(response);
                })
            }
        },
        mounted() {
            this.fetchReadme();
        }
    
    }
</script>

<style lang="sass">
    .readme {
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        .readme-loading,
        .readme-error {
            text-align: center;
            padding: 50px;
            background-color: #f9f9f9;
            color: #999;
        }
        .readme-content {
            color: #666;
            background-color: #f9f9f9;
            padding: 20px;
            a {
                color: #000;
                
            }
            a:hover {
                color: #000;
                text-decoration: underline;
            }
            .deep-link-icon {
                display: none;
            }
            img {
                max-width: 100%;
            }
            pre {
                code {
                    display: block;
                    background-color: #eee;
                    padding: 10px;
                }
            }
            table {
                border: 1px solid #ddd;
                margin: 10px 0;
                th,
                td {
                    padding: 5px;
                }
            }
        }
    }
</style>