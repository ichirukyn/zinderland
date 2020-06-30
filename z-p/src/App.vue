<template>
    <div id="app">
        <component :is="layout">
            <router-view></router-view>
        </component>
    </div>
</template>

<script>
    import Vue from "vue";
    import vueHeadful from 'vue-headful';
    import MainLayout from "@/layouts/Main/MainLayout";
    import EmptyLayout from "@/layouts/Main/EmptyLayout";
    Vue.component('vue-headful', vueHeadful);

    export default {
        name: 'App',
        computed: {
            layout() {
                return ((this.$route.meta.layout || 'empty') + 'Layout');
            }
        },
        components: {
            MainLayout,
            EmptyLayout,
        }
    }
</script>

<style>
@import "assets/main.css";
</style>
