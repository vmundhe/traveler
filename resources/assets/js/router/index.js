import Vue from 'vue'
import VueRouter from 'vue-router'

import Register from '../views/Auth/Register.vue'
import Login from '../views/Auth/Login.vue'
import TripIndex from '../views/Trip/Index.vue'
import TripShow from '../views/Trip/Show.vue'
import TripForm from '../views/Trip/Form.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {path: '/', component: TripIndex},
        {path: '/trips/create', component: TripForm, meta: { mode: 'create' }},
        {path: '/trips/:id/edit', component: TripForm, meta: { mode: 'edit' }},
        {path: '/trips/:id', component: TripShow},
        {path: '/register', component: Register},
        {path: '/login', component: Login}
    ]
})

export default router
