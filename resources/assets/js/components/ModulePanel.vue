<template>

    <div class="card">
        <div class="card-header">
            <a :href="module.url"><h5 class="card-title">{{module.name}}</h5></a>
        </div>
        <img class="img-fluid" :src="'/image/' + module.image + '/400x400'" v-if="module.image">
        <a class="no-image-available" :href="module.url" v-if="!module.image"><span>No image available.</span></a>
        <div class="card-block">
            <p class="card-text">{{module.description}}</p>
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