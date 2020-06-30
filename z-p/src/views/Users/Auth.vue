<template>
  <div class="component">
    <form @submit.prevent="Auth" class="form">

      <input type="text" class="form-control m-2" placeholder="Login" v-model="userLogin">
      <input type="password" class="form-control m-2" placeholder="Password" v-model="userPass">
      <input type="submit" class="btn m-2" value="Sing up">

    </form>
  </div>
</template>

<script>
export default {
  name: "Auth",
  data() {
    return {
      userLogin: '',
      userPass: ''
    }
  },
  methods: {
    Auth() {
      let userLogin = this.userLogin;
      let userPass = this.userPass;
      this.Auth(userLogin, userPass)
    }
  }
}
</script>
