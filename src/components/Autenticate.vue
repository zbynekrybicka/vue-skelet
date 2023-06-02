<template>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">{{ heading }}</div>
  
            <div class="card-body">
                <div class="form-group" v-if="authenticationData.qrcode">
                  <label>Zkopírujte QR kód do aplikace Google Autenticator a opište příslušný autorizační kód.</label>
                  <img :src="authenticationData.qrcode" />                                    
                </div>

                <div class="form-group">
                  <label for="code">{{ codeLabel }}</label>
                  <input type="text" name="code" id="code" class="form-control" v-model="code" required autofocus  @keyup.enter="authenticate">
                </div>
  
                <button class="btn btn-primary" @click="authenticate">{{ submitLabel }}</button>
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
        code: '',
        heading: 'Autorizace',
        codeLabel: 'Autorizační kód',
        submitLabel: 'Odeslat'
      }
    },
    methods: {
      authenticate() {
        this.$store.dispatch('authenticate', this.code)
      }
    },
    computed: {
        authenticationData() {
            return this.$store.getters.authenticationData
        }
    }
  }
  </script>
  
  <style scoped>
  /* Styly pro komponentu Authenticate.vue */
  </style>
  