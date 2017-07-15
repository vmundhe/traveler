<template>
    <div class="trip_list">
        <div class="row">
            <div class="trip_item" v-for="trip in trips">
                <div class="col-6">
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
        </div>
    </div>
</template>
<script type="text/javascript">
import { get } from '../../helpers/api'
export default {
    data() {
        return {
            trips: []
        }
    },
    created() {
        get('/api/trips')
            .then((res) => {
            console.log(res);
                this.trips = res.data.trips
            })
    }
}
</script>
