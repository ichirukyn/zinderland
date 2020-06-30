<template>
    <div class="component">
        <button @click="Logout">Exit</button>
    </div>
</template>

<script>
    export default {
        name: "Profile",
        methods: {
            Logout: function () {
                let userId = localStorage.getItem('user_id');
                let userToken = localStorage.getItem('user_token');
                this.$store.dispatch("UserLogout", {userId, userToken}).then(() => {
                    this.$router.push({'name': 'Home'})
                });
            }
        },
    }
</script>

<style scoped>

</style>
