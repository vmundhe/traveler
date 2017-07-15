<template>
    <div class="trip_show">
        <div class="trip_header">
            <h3 class="trip_header_action">{{action}} Trip</h3>
            <div>
                <button class="btn btn-primary" @click="save" :disabled="isProcessing">Save</button>
                <button class="btn" @click="$router.back()" :disabled="isProcessing">Cancel</button>
            </div>
        </div>
        <div class="trip_row">
            <div class="trip_image">
                <div class="trip_box">
                    <image-upload v-model="form.image"></image-upload>
                    <small class="form_error" v-if="error.image">{{error.image[0]}}</small>
                </div>
            </div>
            <div class="trip_details">
                <div class="trip_details_inner">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Title" v-model="form.title">
                        <small class="form_error" v-if="error.title">{{error.title[0]}}</small>
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" placeholder="Start Date" v-model="form.trip_date">
                        <small class="form_error" v-if="error.trip_date">{{error.trip_date[0]}}</small>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Trip duration in number" v-model="form.trip_duration">
                        <small class="form_error" v-if="error.trip_duration">{{error.trip_duration[0]}}</small>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control form__description" placeholder="Please enter your trip details..." v-model="form.description"></textarea>
                        <small class="form_error" v-if="error.description">{{error.description[0]}}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import { get, post } from '../../helpers/api'
    import { toMulipartedForm } from '../../helpers/form'
    import ImageUpload from '../../components/ImageUpload.vue'

    export default {
        components: {
            ImageUpload
        },
        data() {
            return {
                form: {},
                error: {},
                isProcessing: false,
                initializeURL: `/api/trips/create`,
                storeURL: `/api/trips`,
                action: 'Create'
            }
        },
        created() {
            if(this.$route.meta.mode === 'edit') {
                this.initializeURL = `/api/trips/${this.$route.params.id}/edit`
                this.storeURL = `/api/trips/${this.$route.params.id}?_method=PUT`
                this.action = 'Update'
            }
            get(this.initializeURL)
                .then((res) => {
                    Vue.set(this.$data, 'form', res.data.form)
                })
        },
        methods: {
            save() {
                const form = toMulipartedForm(this.form, this.$route.meta.mode)
                post(this.storeURL, form)
                    .then((res) => {
                        if(res.data.saved) {
                            this.$router.push(`/trips/${res.data.id}`)
                        }
                        this.isProcessing = false
                    })
                    .catch((err) => {
                        if(err.response.status === 422) {
                            this.error = err.response.data
                        }
                        this.isProcessing = false
                    })
            }
        }
    }
</script>
