<template>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">{{ heading }}</div>
  
            <div class="card-body">
                <div class="form-group">
                  <label for="email">{{ emailLabel }}</label>
                  <input type="email" name="email" id="email" class="form-control" v-model="email" required autofocus @keyup.enter="login">
                </div>
  
                <div class="form-group">
                  <label for="password">{{ passwordLabel }}</label>
                  <input type="password" name="password" id="password" class="form-control" v-model="password" @keyup.enter="login" required>
                </div>
  
                <button class="btn btn-primary" @click="login">{{ submitLabel }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        email: '',
        password: '',
        heading: 'Přihlášení',
        emailLabel: 'Emailová adresa',
        passwordLabel: 'Heslo',
        submitLabel: 'Přihlásit se'
      }
    },
    methods: {
      login() {
        this.$store.dispatch("login", {
            email: this.email,
            password: this.password
        })
      }
    }
  }
  </script>
  
  <style scoped>
  /* Styly pro komponentu Login.vue */
  </style>
  