<template>
    <div class="layout">
        <div class="navbar navbar-expand-lg bg-dark">
            <router-link to="/" class="alert-link navbar-brand" exact-active-class="activeLink">Zinderland</router-link>
        </div>

        <main class="app-content">
            <div class="content-bg p-3 m-2">
                <router-view></router-view>
            </div>
        </main>


    </div>
</template>

<script>
    export default {
        name: "MainLayout",
        mounted() {
        }
    }
</script>

<style scoped>

</style>
