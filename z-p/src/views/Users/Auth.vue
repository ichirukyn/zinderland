<template>
    <div class="component">
        <div v-if="GetUserAuthState.Error" class="alert alert-danger" role="alert">
            Ошибка в логине или пароле!
        </div>
        <div v-if="GetUserAuthState.Success" class="alert alert-success" role="alert">
            Успешно!
        </div>
        <div class="form">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Login" v-model="userLogin">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" v-model="userPass">
            </div>
            <button class="btn bg-dark text-white" @click="AuthMethod">Sing up</button>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default {
        name: "Auth",
        data() {
            return {
                userLogin: '',
                userPass: ''
            }
        },
        computed: mapGetters(["GetUserAuthState"]),
        methods: {
            AuthMethod() {
                let userLogin = this.userLogin;
                let userPass = this.userPass;
                this.$store.dispatch("Auth", {userLogin, userPass}).then(() => {
                    this.$router.push('/')
                });
            }
        },
    }
</script>
