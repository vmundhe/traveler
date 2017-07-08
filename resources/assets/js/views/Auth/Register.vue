<template>
    <form class="form" @submit.prevent="register">
        <h1 class="form_title">Create a New Account</h1>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Name" v-model="form.name">
            <small class="form_error" v-if="error.name">{{error.name[0]}}</small>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" v-model="form.email">
            <small class="form_error" v-if="error.email">{{error.email[0]}}</small>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" v-model="form.password">
            <small class="form_error" v-if="error.password">{{error.password[0]}}</small>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Confirm Password" v-model="form.password_confirmation">
        </div>
        <div class="form-group">
            <button :disabled="isProcessing" class="btn btn-primary">Register</button>
        </div>
    </form>
</template>
<script type="text/javascript">
    import { post } from '../../helpers/api'
    export default {
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                error: {},
                isProcessing: false
            }
        },
        methods: {
            register() {
                this.isProcessing = true
                this.error = {}
                post('api/register', this.form)
                    .then((res) => {
                        if(res.data.registered) {
                            this.$router.push('/login')
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
