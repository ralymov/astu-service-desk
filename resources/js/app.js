require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import router from './router';
import store from './store';
import SweetAlert from './mixins/sweet_alert';
import App from './components/App.vue';
import FormSelect from './components/common/dumb/FormSelect.vue';
import InputSearch from './components/common/InputSearch.vue';
import _ from 'lodash';
import vSelect from 'vue-select';

Vue.use(VueRouter);
Vue.use(BootstrapVue);

Vue.mixin(SweetAlert);

Vue.component('form-select', FormSelect);
Vue.component('input-search', InputSearch);
Vue.component('v-select', vSelect);

Object.defineProperty(Vue.prototype, '_', {value: _});

const app = new Vue({
  el: '#app',
  components: {App},
  router,
  store,
});
