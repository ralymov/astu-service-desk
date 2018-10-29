require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import router from './router';
import store from './store';
import SweetAlert from './mixins/sweet_alert';
import App from './components/App.vue';
import _ from 'lodash';

Vue.use(VueRouter);
Vue.use(SweetAlert);
Vue.use(BootstrapVue);

Object.defineProperty(Vue.prototype, '_', { value: _ });

const app = new Vue({
  el: '#app',
  components: {App},
  router,
  store,
});
