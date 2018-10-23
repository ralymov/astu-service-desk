import Vue from 'vue';
import Vuex from 'vuex';
import auth from './store/auth';

Vue.use(Vuex);

export default new Vuex.Store({
  // strict: true,
  
  modules: {
    auth
  },
  
  state: {
    user: {},
    meta: {},
    routes: {},
  },
  
  mutations: {
    setUser: (state, user) => {
      state.user = user;
    },
    setMeta: (state, meta) => {
      state.meta = meta;
    },
    setRoutes: (state, routes) => {
      state.routes = routes;
    },
  },
});
