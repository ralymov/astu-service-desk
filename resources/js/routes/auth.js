import store from '../store';

import Login from '../components/auth/Login.vue';

const redirect = (to, from, next) => {
  if (store.getters['auth/isAuth']) {
    next({path: '/'});
  }
  
  next();
};

export default [
  {
    name: 'login',
    path: '/login',
    component: Login,
    beforeEnter: redirect,
    meta: {
      guestGuard: true,
      title: 'Вход',
    },
  }
];
