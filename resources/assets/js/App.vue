<template>
    <div class="container">
        <div class="navbar navbar-toggleable-md fixed-top navbar-inverse bg-primary">
            <div class="navbar-brand">
                <router-link to="/">Traveler</router-link>
            </div>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link to="/login" v-if="guest">Sign In</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/register" v-if="guest">Register</router-link>
                </li>
                <li class="nav-item"  v-if="auth">
                    <router-link to="/trips/create">Publish Trip</router-link>
                </li>
                <li class="nav-item" v-if="auth">
                    <a @click.stop="logout">Logout</a>
                </li>
            </ul>
        </div>
        <router-view></router-view>
    </div>
</template>
<script type="text/javascript">
    import Auth from './store/auth'
    import { post } from './helpers/api'
    export default {
        created() {
            Auth.initialize()
        },
        data() {
            return {
                authState: Auth.state
            }
        },
        computed: {
            auth() {
                if(this.authState.api_token) {
                    return true
                }
                return false
            },
            guest() {
                return !this.auth
            }
        },
        methods: {
            logout() {
                post('/api/logout')
                    .then((res) => {
                        if(res.data.logged_out) {
                            Auth.remove()
                            this.$router.push('/login')
                        }
                    })
            }
        }
    }
</script>