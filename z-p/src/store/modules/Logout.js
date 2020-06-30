import axios from 'axios'

export default {
    actions: {
        UserLogout({commit}, {userId, userToken}) {
            axios.get('http://zinderland/user.exit?user_id=' + userId + '&user_token=' + userToken)
                .then((response) => {
                    const qStatus = response.data.status;
                    if (qStatus === 'no') {
                        const qError = response.data.error;
                        commit('LogoutError', qError);
                    } else {
                        commit('LogoutSuccess');
                    }
                })
        }
    },
    mutations: {
        LogoutSuccess(state,) {
            state.Error = null;
            state.Success = true;
            localStorage.removeItem('user_token');
            localStorage.removeItem('user_id');
        },
        LogoutError(state, qError) {
            state.Error = qError;
            state.Success = false;
        }
    },
    state: {
        Error: null,
        Success: null,
    },
    getters: {
        GetUserLogoutState(state) {
            return state
        },
    }
}
