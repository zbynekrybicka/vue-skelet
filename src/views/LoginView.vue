<template>
    <div>
        <Login v-if="!userId" />
        <Autenticate v-if="userId" />
    </div>
  </template>
  
  <script>
import Autenticate from '@/components/Autenticate.vue';
import Login from '@/components/Login.vue';

export default {
    computed: {
        userId() {
            return this.$store.getters.authenticationData?.id
        }
    },
    components: { Login, Autenticate }
}
</script>

<style scoped>
/* Styly pro komponentu Login.vue */
</style>
