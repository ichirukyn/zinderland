<template>
    <div class="component">


        <div v-if="isAuth !== null">
            Начать игру!
        </div>
        <div v-else>
            Регистрация
            <router-link to="/auth">Авторизация</router-link>
        </div>

    </div>
</template>

<script>

    export default {
        name: 'Home',
        data() {
            return {
                isAuth: null
            }
        },
        methods: {
            Logout: function () {
                let userId = localStorage.getItem('user_id');
                let userToken = localStorage.getItem('user_token');
                this.$store.dispatch("Auth", {userId, userToken}).then(() => {
                    this.$router.push({'name': 'Home'})
                });
            }
        },
        created() {
            this.isAuth = localStorage.getItem('user_token');
            console.log(this.isAuth);
        },
        beforeMount() {
            this.isAuth = localStorage.getItem('user_token');
            console.log(this.isAuth);
        },
        mounted() {
            this.isAuth = localStorage.getItem('user_token');
            console.log(this.isAuth);
        },
        updated() {
            this.isAuth = localStorage.getItem('user_token');
            console.log(localStorage.getItem('user_token'));
        },
    }
</script>
