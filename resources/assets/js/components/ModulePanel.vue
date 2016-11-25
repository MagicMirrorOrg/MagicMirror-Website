<template>

    <div class="card" v-if="module">
        <div class="card-header">
            <router-link :to="module.uri"><h5 class="card-title">{{module.name}}</h5></router-link>
        </div>
        <router-link :to="module.uri"><img class="img-fluid" :src="'/image/' + module.image + '/400x400'" v-if="module.image"></router-link>
        <router-link class="no-image-available" :to="module.uri" v-if="!module.image"><span>No image available.</span></router-link>
        <div class="card-block">
            <router-link class="card-text category-name" :to="{ path: '/modules', query: { category: module.category.id }}">{{module.category.name}}</router-link>
            <p class="card-text">{{module.description}}</p>
            <p class="card-text tags">
                <a href="#"  >{{tag}}</a>    
                <router-link    :to="{ path: '/modules', query: { tag: tag }}" 
                                class="tag tag-default" 
                                v-for="tag in module.tags">
                                
                                {{tag}}
                                
                </router-link>
            </p>
        </div>
        <div class="card-footer text-muted">
            <button class="btn btn-sm btn-secondary pull-right" @click.prevent="toggleLike()">
                <i class="fa fa-heart" :class="{'text-danger': module.liked}"></i> {{module.likes}}
            </button>
            <small class="text-muted">
                <i class="fa fa-eye"></i> {{module.views}}      
            </small>
        </div>
        

    </div>
</template>

<script>
    export default {
        props: ['module'],
        methods: {
            toggleLike() {
                console.log('Toggle like');
                this.$set(this.module, 'liked', !this.module.liked);
                if (this.module.liked) {
                     this.$set(this.module, 'likes', this.module.likes + 1);
                } else {
                    this.$set(this.module, 'likes', this.module.likes - 1);
                }

                this.$http.post("/api/module/" + this.module.id + '/liked', {likes: this.module.liked}).then((response) => {
                    console.log(response);
                }, (response) => {
                    console.error(response);
                })

            }
        }
    }
</script>

<style lang="sass" scoped>
.card {
    .card-header {
        h5 {
            margin: 0;
            font-size: 1.2rem;
            
            text-decoration: none;
        }
        a, a:hover {
            color: black;
            text-decoration: none;
        }
    }
    img {
        width: 100%;
        background-color: #eee;
    }
    .no-image-available {
        display:block;
        position: relative;
        background-color: #eee;
        font-size: 12px;
        color: #ccc;
        height: 0;
        padding-bottom: 50%;
        span {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
    }
    .card-text {
        font-size: 1rem;
    }
    .category-name {
        color: #aaa;
        text-transform: uppercase;
        font-size: 0.8rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .tag {
        margin-right: 2px;
        margin-bottom: 2px;
        padding: 3px;
        border-radius: 2px;
        color: #aaa;
        background-color: #eee;
        text-transform: uppercase;
        font-size: 0.65rem;

    }
    .tag:hover {
        color: white;
        background-color: #666;
    }
}
</style>