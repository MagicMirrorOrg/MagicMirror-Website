<template>
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
                    <readme-viewer :module="module"></readme-viewer>
                </div>
                <div class="col-md-3">
                    <module-panel :module="module"></module-panel>
                    <a :href="module.github_url" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-github" aria-hidden="true"></i> GitHub Repository</a>
                    <a :href="module.link" target="_blank" class="btn btn-outline-primary btn-block" v-if="module.link && module.link != module.github_url"><i class="fa fa-info-circle" aria-hidden="true"></i> More Info</a>
                </div>
            </div>
            
            <hr>
            <pre>{{module}}</pre>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['module']
    }
</script>