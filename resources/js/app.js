require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import router from './router';
import store from './store';
import SweetAlert from './mixins/sweet_alert';
import App from './components/App.vue';

Vue.use(VueRouter);
Vue.use(SweetAlert);

const app = new Vue({
  el: '#app',
  components: {App},
  router,
  store,
});
