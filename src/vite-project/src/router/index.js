import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Tickets from '../views/Tickets.vue'
import TicketTemplate from '../views/TicketTemplate.vue'

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
    component: TicketTemplate
  },
  {
    path: '/tickettemplates/edit/:tplid',
    name: 'EditTicketTemplate',
    component: TicketTemplate
  },
]

const router = new VueRouter({
 // mode: 'history',
 // base: process.env.BASE_URL,
  routes
})

export default router
