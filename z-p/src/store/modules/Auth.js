import axios from 'axios'

export default {
    actions: {
        Auth({commit}, {userLogin, userPass}) {
            axios.get('http://zinderland/user.auth?user_login=' + userLogin + '&user_pass=' + userPass)
                .then((response) => {
                    const qStatus = response.data.status;
                    if (qStatus === 'no') {
                        const qError = response.data.error;
                        commit('AuthError', qError);
                    } else {
                        const UserToken = response.data.response.user_token;
                        const UserId = response.data.response.user_id;
                        commit('AuthSuccess', {UserToken, UserId});
                    }
                })
        }
    },
    mutations: {
        AuthSuccess(state, {UserToken, UserId}) {
            state.Error = null;
            state.Success = true;
            localStorage.setItem('user_token', UserToken);
            localStorage.setItem('user_id', UserId);
        },
        AuthError(state, qError) {
            state.Error = qError;
            state.Success = false;
        }
    },
    state: {
        Error: null,
        Success: null,
    },
    getters: {
        GetUserAuthState(state) {
            return state
        },
    }
}
