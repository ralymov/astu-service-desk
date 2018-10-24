import router from '../router';

const namespaced = true;

export const state = {
  auth: getCookie('token') !== undefined && getCookie('token') !== null,
  user: {
    full_name: null,
    role: null,
    employee_id: null,
    id: null,
  }
};

export const mutations = {
  setAuth(state, value) {
    state.auth = value;
  },
  setUser(state, credentials) {
    state.user.role = credentials.role;
    state.user.id = credentials.id;
  }
};

export const getters = {
  isAuth: state => state.auth,
  user: state => state.user,
};

export const actions = {
  login({commit}, credentials) {
    commit('setAuth', true);
    commit('setUser', credentials);
    // localStorage.setItem('auth', credentials.access_token);
    // axios.defaults.headers.common['Authorization'] = 'Bearer ' + getCookie('access_token');
  },
  setUser({commit}, credentials) {
    commit('setUser', credentials);
  },
  logout({commit}) {
    //delete axios.defaults.headers.common['Authorization'];
    commit('setAuth', false);
    commit('setUser', {username: null, role: null});
    // localStorage.removeItem('auth');
    eraseCookie('token');
    router.replace({name: 'login'});
  },
};

export default {
  namespaced,
  state,
  getters,
  actions,
  mutations
}

function getCookie(name) {
  let matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function eraseCookie(name) {
  document.cookie = name + '=; Max-Age=-99999999;';
}
