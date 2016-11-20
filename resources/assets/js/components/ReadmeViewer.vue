<template>
    <div>
        <div class="readme">
            <div v-if="readme" v-html="compiledReadme" class="readme-content"></div>
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
            }
        },
        computed: {
            compiledReadme() {
                return marky(this.readme, {
                    highlightSyntax: false,
                    serveImagesWithCDN: true,
                });
            }
        },
        methods: {
            fetchReadme() {
                console.log("Fetch Readme");
                var _this = this;

                var url = "/api/module/" + _this.module.id + "/readme";
                _this.loading = true;
                this.$http.get(url).then((response) => {
                    _this.loading = false;
                    _this.readme = response.data;
                    console.log(response);
                }, (response) => {
                    _this.loading = false;
                    console.error(response);
                })
            }
        },
        mounted() {
            console.log("Mounted");
            this.fetchReadme();
        }
    
    }
</script>