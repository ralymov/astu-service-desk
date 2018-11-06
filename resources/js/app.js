require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import router from './router';
import store from './store';
import SweetAlert from './mixins/sweet_alert';
import Helper from './mixins/helper';
import App from './components/App.vue';
import FormSelect from './components/common/dumb/FormSelect.vue';
import InputSearch from './components/common/InputSearch.vue';
import SelectSearch from './components/common/SelectSearch.vue';
import _ from 'lodash';
import vSelect from 'vue-select';
import {Chrome} from 'vue-color'

Vue.use(VueRouter);
Vue.use(BootstrapVue);

Vue.mixin(SweetAlert);
Vue.mixin(Helper);

Vue.component('form-select', FormSelect);
Vue.component('input-search', InputSearch);
Vue.component('select-search', SelectSearch);
Vue.component('v-select', vSelect);
Vue.component('chrome-color', Chrome);

Object.defineProperty(Vue.prototype, '_', {value: _});

const app = new Vue({
  el: '#app',
  components: {App},
  router,
  store,
});
