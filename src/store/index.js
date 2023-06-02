import { createStore } from 'vuex'
import axios from 'axios'


export default createStore({
  state: {
    authToken: null,
    authenticationData: null,
    loading: false,
    data: null,
    success: false,
  },
  getters: {
    loading(state) {
      return state.loading
    },
    success(state) {
      return state.success
    },
    authenticationData(state) {
      return state.authenticationData
    },
    isLoggedIn(state) {
      return !!state.authToken && !!state.data
    },    
  },
  mutations: {
    setLoading(state, isLoading) {
      state.loading = isLoading
    },
    success(state) {
      state.success = true
      setTimeout(() => {
        state.success = false
      }, 3000)
    },    
    setAuthenticationData(state, authenticationData) {
      state.authenticationData = authenticationData
    },
    setAuthToken(state, authToken) {
      state.authToken = authToken
      localStorage.setItem('budovani-znacky-authToken', authToken)
    },
    getAll(state, data) {
      state.data = data
    },
    logout(state) {
      state.authToken = null
      state.data = null
      localStorage.removeItem('budovani-znacky-authToken')
    },    
  },
  actions: {
    login({ commit }, { email, password }) {
      commit('setLoading', true)
      return axios
        .post(window.API_URL + '/login', { email, password })
        .then((response) => {
          commit('setAuthenticationData', response.data)
          commit("success")
        })
        .catch((error) => {
          console.error(error)
        })
        .finally(() => {
          commit('setLoading', false)
        })
    },
    authenticate({ commit, dispatch, state }, code) {
      commit('setLoading', true)
      return axios
        .post(window.API_URL + '/authenticate', { code, ...state.authenticationData })
        .then((response) => {
          commit('setAuthToken', response.data)
          commit("success")
          dispatch('loadAll')
        })
        .catch((error) => {
          console.error(error)
        })
        .finally(() => {
          commit('setLoading', false)
        })
    },
    loadAuthToken({ commit, dispatch }) {
      const authToken = localStorage.getItem('budovani-znacky-authToken')
      if (authToken) {
        commit('setAuthToken', authToken)
        dispatch('loadAll')
      }
    },
    loadAll({ commit, state }) {
      commit('setLoading', true)
      return axios
        .get(window.API_URL + '/all', {
          headers: {
            Authorization: `Bearer ${state.authToken}`,
          },
        })
        .then((response) => {
          commit('getAll', response.data)
          commit("success")
        })
        .catch((error) => {
          console.error(error)
        })
        .finally(() => {
          commit('setLoading', false)
        })
    },    
  },
  modules: {
  }
})
