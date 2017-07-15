<template>
    <div class="trip_show">
        <div class="trip_row">
            <div class="trip_image">
                <div class="trip_box">
                    <img class="preview" :src="`/images/${trip.image}`" v-if="trip.image">
                </div>
            </div>
            <div class="trip_details">
                <div class="trip_details_inner">
                    <small>Submitted by: {{trip.user.name}}</small>
                    <h1 class="trip_title">{{trip.title}}</h1>
                    <p class="trip_description">{{trip.description}}</p>
                    <div v-if="authState.api_token && authState.user_id === trip.user_id">
                        <router-link :to="`/trips/${trip.id}/edit`" class="btn btn-primary">
                            Edit
                        </router-link>
                        <button class="btn btn-danger" @click="remove" :disabled="isRemoving">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Auth from '../../store/auth'
    import { get, del } from '../../helpers/api'
    export default {
        data() {
            return {
                authState: Auth.state,
                isRemoving: false,
                trip: {
                    user: {}
                }
            }
        },
        created() {
            get(`/api/trips/${this.$route.params.id}`)
                .then((res) => {
                    this.trip = res.data.trip
                })
        },
        methods: {
            remove() {
                this.isRemoving = false,
                del(`/api/trips/${this.$route.params.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/')
                        }
                    })
            }
        }
    }
</script>
