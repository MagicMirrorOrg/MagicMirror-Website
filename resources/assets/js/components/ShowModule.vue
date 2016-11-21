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