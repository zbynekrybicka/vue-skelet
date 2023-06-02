<template>
  <div>
    <DashboardView v-if="isLoggedIn" />
    <LoginView v-if="!isLoggedIn" />
  </div>
</template>

<script>
import DashboardView from './DashboardView.vue';
import LoginView from './LoginView.vue';


export default {
    name: "HomeView",
    components: { DashboardView, LoginView },
    computed: {
      isLoggedIn() {
        return this.$store.getters.isLoggedIn
      }
    }
}
</script>
