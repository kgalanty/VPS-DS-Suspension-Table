import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Tickets from '../views/Tickets.vue'
import NewTicketTemplate from '../views/NewTicketTemplate.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/tickettemplates',
    name: 'Tickets',
    component: Tickets
  },
  {
    path: '/tickettemplates/new',
    name: 'NewTicketTemplate',
    component: NewTicketTemplate
  },
]

const router = new VueRouter({
 // mode: 'history',
 // base: process.env.BASE_URL,
  routes
})

export default router
