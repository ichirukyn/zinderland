import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/views/Main/Home'
import NotFoundPage from '@/views/Main/NotFoundPage'
import Auth from '@/views/Users/Auth'

Vue.use(Router);

export default new Router({
  routes: [
    // Main
    {
      path: '/',
      name: 'Home',
      meta: {layout: 'Main'},
      component: Home,
    },
    // Auth
    {
      path: '/auth',
      name: 'Auth',
      meta: {layout: 'Main'},
      component: Auth,
    },
    {
      path: '*',
      name: 'NotFoundPage',
      meta: {layout: 'Admin'},
      component: NotFoundPage,
    },
  ]

})
