import Vue from 'vue'
import VueRouter from 'vue-router'
import Graph from '../views/Graph.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Graph',
    component: Graph
  },
  {
    path: '/table',
    name: 'Table',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/Table.vue')
  }
]

const router = new VueRouter({
  routes
})

export default router
