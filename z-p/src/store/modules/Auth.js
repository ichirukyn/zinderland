import axios from 'axios'

export default {
  actions: {
    Auth({ commit }, userLogin, userPass) {
      axios.get('http://zinderland/user.auth?user_login=' + userLogin + '&user_pass=' + userPass)
      .then((response) => {
        const qStatus = response.data.status;
        commit('AuthSuccess', qStatus)
      })
      .catch((response) => {
        const qStatus = response.data.status;
        commit('AuthError', qStatus);
      });
    }
  },
  mutations: {
    AuthSuccess(state, qStatus) {
      state.isAuth = qStatus
    },
    AuthError(state, qStatus) {
      state.isAuth = qStatus
    }
  },
  state: {
    isAuth: false,
  },
  getters: {
    GetUserAuthState(state) {
      return state.isAuth
    },
  }
}
