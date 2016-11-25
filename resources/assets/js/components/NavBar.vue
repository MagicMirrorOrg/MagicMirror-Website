<template>
    <nav class="navbar navbar-light navbar-full ">
        <div class="container">
            <router-link to="/" class="navbar-brand">MagicMirror<span>²</span></router-link>
            <ul class="nav navbar-nav">
                <li class="nav-item"><router-link to="/modules" class="nav-link"><i class="fa fa-fw fa-cubes" aria-hidden="true"></i> Modules</router-link></li>
                <li class="nav-item" v-if="user"><router-link to="/module/add" class="nav-link"><i class="fa fa-fw fa-plus-circle" aria-hidden="true"></i> Add Module</router-link></li>
            </ul>
            <ul class="nav navbar-nav float-lg-right">
               
                    <li class="nav-item" v-if="!user"><a href="/login" class="btn btn-outline-primary"><i class="fa fa-github" aria-hidden="true"></i> Login with GitHub</a></li>

                    <div v-if="user">
                        <img :src="user.avatar" class="rounded-circle avatar">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="responsiveNavbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ user.name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="responsiveNavbarDropdown">
                                <router-link :to="{ path: '/modules', query: { user: user.github_user }}" class="dropdown-item"><i class="fa fa-fw fa-cubes" aria-hidden="true"></i> My Modules</router-link>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" @click.prevent="logout()">
                                    <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> Logout
                                </a>
                            </div>
                        </li>
                    <div>
            </ul>
        </div>
    </nav>
</template>
<script>

    import userStore from './../store/user.js';

    export default {
        computed: {
            user() {
                return userStore.state.user;
            }
        },
        methods: {
            logout() {
                userStore.dispatch('logout');
            }
        }
    }
</script>