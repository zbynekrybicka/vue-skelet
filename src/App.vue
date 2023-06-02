<template>
  <nav v-if="isLoggedIn">
    <router-link to="/">Nástěnka</router-link> |
    <a href="#" @click.prevent="logout">Odhlásit se</a>
  </nav>
  <div class="container">
    <Success v-if="success" />
    <Preloader v-if="loading" />
    <router-view/>
  </div>
</template>

<script>
import Success from '@/components/Success.vue'
import Preloader from '@/components/Preloader.vue'

export default {
  name: "App",
  components: { Success, Preloader },
  computed: {
    isLoggedIn() {
      return this.$store.getters.isLoggedIn
    },
    success() {
      return this.$store.getters.success
    },
    loading() {
      return this.$store.getters.loading
    }
  },
  methods: {
    logout() {
      this.$store.commit('logout')
    }
  },
  created() {
    this.$store.dispatch('loadAuthToken')
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
