<template>
  <div class="layout">
    <div class="navbar navbar-expand-lg bg-dark">
      <router-link to="/" class="alert-link navbar-brand">Zinderland</router-link>
    </div>

    <main class="app-content">
      <div class="content-bg p-3 m-2">
        <router-view></router-view>
      </div>
    </main>


  </div>
</template>

<script>
import { mapGetters} from 'vuex'

export default {
  name: "MainLayout",
  computed: mapGetters(["GetUserAuthState"]),
  mounted() {
    // this.$store.dispatch("AllUsers");
  }
}
</script>

<style scoped>

</style>
