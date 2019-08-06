import Datepicker from "common/Datepicker";

require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import router from './router';
import store from './store';
import SweetAlert from 'mixins/sweet_alert';
import Helper from 'mixins/helper';
import App from 'components/App.vue';
import FormSelect from 'components/common/dumb/FormSelect.vue';
import InputSearch from 'components/common/InputSearch.vue';
import SelectSearch from 'components/common/SelectSearch.vue';
import ConfirmationModal from "components/common/modals/ConfirmationModal";

import _ from 'lodash';
import {Chrome} from 'vue-color';
import Icon from 'vue-awesome/components/Icon';

import 'vue-awesome/icons/share';
import 'vue-awesome/icons/lock';
import 'vue-awesome/icons/check';
import 'vue-awesome/icons/comments';
import 'vue-awesome/icons/history';
import 'vue-awesome/icons/calculator';

Vue.use(VueRouter);
Vue.use(BootstrapVue);

Vue.mixin(SweetAlert);
Vue.mixin(Helper);


Vue.component('v-icon', Icon);
Vue.component('form-select', FormSelect);
Vue.component('input-search', InputSearch);
Vue.component('select-search', SelectSearch);
Vue.component('datepicker', Datepicker);
Vue.component('chrome-color', Chrome);
Vue.component('confirmation-modal', ConfirmationModal);

import * as StringFilter from './services/filters/strings';
import * as DateFilter from './services/filters/date';
Vue.filter('ui-as-time', StringFilter.asTime);
Vue.filter('ui-as-date', StringFilter.asDate);
Vue.filter('ui-normalize-date', DateFilter.normalizeDate);
Vue.filter('ui-get-site', StringFilter.getHostName);
Object.defineProperty(Vue.prototype, '_', {value: _});

const app = new Vue({
  el: '#app',
  components: {App},
  router,
  store,
});
