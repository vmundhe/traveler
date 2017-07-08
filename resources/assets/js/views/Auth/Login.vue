<template>
   <form class="form" @submit.prevent="login">
    <h1 class="form_title">Sign In</h1>
    <div class="form-group">
     <input type="text" class="form-control" placeholder="Email" v-model="form.email">
     <small class="form_error" v-if="error.email">{{error.email[0]}}</small>
    </div>
    <div class="form-group">
     <input type="password" class="form-control" placeholder="Password" v-model="form.password">
     <small class="form_error" v-if="error.password">{{error.password[0]}}</small>
    </div>
    <div class="form-group">
     <button :disabled="isProcessing" class="btn btn-primary">Sign In</button>
    </div>
   </form>
</template>
<script type="text/javascript">
    import { post } from '../../helpers/api'
    import Auth from '../../store/auth'
    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                error: {},
                isProcessing: false
            }
        },
        methods: {
            login() {
                this.isProcessing = true
                this.error = {}
                post('api/login', this.form)
                    .then((res) => {
                        if(res.data.authenticated) {
                            Auth.set(res.data.api_token, res.data.user_id)
                            this.$router.push('/')
                        }
                        this.isProcessing = false
                    })
                    .catch((err) => {
                        if(err.response.status === 422) {
                            this.error = err.response.data
                        }
                    this.isProcessing = false;
                    })
            }
        }
    }
</script>
