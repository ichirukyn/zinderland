import Vue from 'vue';
import Router from 'vue-router';

import Home from '@/views/Main/Home';
import NotFoundPage from '@/views/Main/NotFoundPage';
import Auth from '@/views/Users/Auth';
import Profile from "./views/Users/Profile";

Vue.use(Router);

const ifNotAuthenticated = (to, from, next) => {
  if (!localStorage.getItem('user_token')) {
    next();
    return;
  }
  next('/');
};

// const ifAuthenticated = (to, from, next) => {
//   if (store.getters.isAuthenticated) {
//     next()
//     return
//   }
//   next('/login')
// }

export default new Router({
  routes: [
    // Main
    {
      path: '/',
      name: 'Home',
      meta: {layout: 'Main'},
      component: Home,
    },
    {
      path: '/Profile',
      name: 'Profile',
      meta: {layout: 'Main'},
      component: Profile,
    },
    // Auth
    {
      path: '/auth',
      name: 'Auth',
      meta: {layout: 'Main'},
      component: Auth,
      beforeEnter: ifNotAuthenticated
    },
    {
      path: '*',
      name: 'NotFoundPage',
      meta: {layout: 'Admin'},
      component: NotFoundPage,
    },
  ]

})
