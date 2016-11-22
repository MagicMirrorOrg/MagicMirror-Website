<template>

    <div class="card">
        <div class="card-header">
            <a :href="module.url"><h5 class="card-title">{{module.name}}</h5></a>
        </div>
        <a :href="module.url"><img class="img-fluid" :src="'/image/' + module.image + '/400x400'" v-if="module.image"></a>
        <a class="no-image-available" :href="module.url" v-if="!module.image"><span>No image available.</span></a>
        <div class="card-block">
            <p class="card-text category-name">{{module.category.name}}</p>
            <p class="card-text">{{module.description}}</p>
            <p class="card-text tags">
                <a href="#" class="tag tag-default" v-for="tag in module.tags">{{tag}}</a>    
            </p>
        </div>
        <div class="card-footer text-muted text-xs-right">
            <small class="text-muted">
                <i class="fa fa-heart"></i> 0 &nbsp;
                <i class="fa fa-eye"></i> {{module.views}}      
            </small>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['module']
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