<template>
    <div class="row">
        <div class="user">
            <div class="user_picture">
                Profile Picture
            </div>
            <h4 class="user_name">{{user}}</h4>
        </div>
        <div class="trip_list">
            <div>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" @click="myTrips">My Trips</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" @click="allTrips">All Trips</a>
                    </li>
                </ul>
            </div>
            <div class="trip_item" v-if="trips" v-for="trip in trips">
                <div class="col-5">
                    <h6>Submitted By: {{user}}</h6>
                    <router-link class="trip_inner" :to="`/trips/${trip.id}`">
                        <img class="preview_index" :src="`/images/${trip.image}`" v-if="trip.image">
                        <h4 class="trip_title">{{trip.title}}</h4>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                Date: {{trip.trip_date}}
                            </li>
                            <li class="list-inline-item">
                                Duration: {{trip.trip_duration}} days
                            </li>
                        </ul>
                    </router-link>
                </div>
            </div>
            <div class="no_trips" v-else>No trips to show. Please publish a trip.</div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import { get } from '../../helpers/api'
    export default {
        data() {
            return {
                trips: [],
                user: ''
            }
        },
        created() {
            this.myTrips()
        },
        methods: {
            myTrips() {
                get('/api/trips')
                    .then((res) => {
                        this.user = res.data.user
                        this.trips = res.data.userTrips
                    })
            },
            allTrips() {
                get('/api/trips')
                    .then((res) => {
                        this.user = res.data.user
                        this.trips = res.data.trips
                    })
            },
        }
    }
</script>
