import Vue from 'vue'
import Vuex from 'vuex'
import UserAuth from './modules/Auth'
import UserLogout from './modules/Logout'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        UserAuth,
        UserLogout
    }
})
