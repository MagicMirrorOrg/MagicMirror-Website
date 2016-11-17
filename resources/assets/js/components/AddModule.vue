<template>
    <div class="container add-module">
        <div class="row">
            <div class="col-md-12">

                <div class="list-group">
                    <a href="#" class="list-group-item" v-for="repository in repositories">
                        <h4 class="list-group-item-heading">{{repository.name}}</h4>
                        <p class="list-group-item-text">{{repository.description}}</p>
                    </a>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                repositories: []
            }
        },
        methods: {
            fetchRepositories() {
                var _this = this;
                this.$http.get('/api/me/repositories').then((response) => {
                    _this.repositories = response.data;
                }, (response) => {
                    console.error(response);
                })
                            }
        },
        mounted() {
            this.fetchRepositories();
        }
    }
</script>