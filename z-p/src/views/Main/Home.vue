<template>
  <div class="component">



  <div v-if="GetUserAuthState">
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
}
</script>
