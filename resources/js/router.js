import Vue from 'vue';
import Router from 'vue-router';
import store from './store';
import routeImporter from './modules/importers/routeImporter';
import NotFound from 'components/common/dumb/NotFound.vue';

Vue.use(Router);

const routes = routeImporter(require.context('./routes', false, /.*\.js$/));
routes.push(
  {path: '/404', component: NotFound, meta: {title: 'Страница не найдена'}},
  {path: '*', redirect: '/404'},
);

const router = new Router({
  linkActiveClass: 'active',
  mode: 'history',
  routes,
});

router.beforeEach((to, from, next) => {
  if (!to.meta.guestGuard && !store.getters['auth/isAuth'] && to.path !== '/404') {
    next({name: 'login'});
  }
  
  document.title = to.meta.title || 'Service desk';
  
  next();
});

export default router;
