import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)
import VuexPersist from 'vuex-persistedstate'

export default new Vuex.Store({
  state: {
    busData: {},
    selectedSeat: null,
    passengerData: {},
    userRole: null,
  },
  mutations: {
    SET_BUS_DATA(state, data) {
      state.busData = data
    },
    SET_SELECTED_SEAT(state, seat) {
      state.selectedSeat = seat
    },
    SET_PASSENGER_DATA(state, data) {
      state.passengerData = data
    },
    SET_USER_ROLE(state, role) {
      state.userRole = role
    },

  },
  actions: {
    setBusData({
      commit
    }, data) {
      commit('SET_BUS_DATA', data)
    },
    setSelectedSeat({
      commit
    }, seat) {
      commit('SET_SELECTED_SEAT', seat)
    },
    setPassengerData({
      commit
    }, data) {
      commit('SET_PASSENGER_DATA', data)
    },
    SET_USER_ROLE(state, userRole) {
      state.userRole = userRole
    },
    //get role
    updateUserRole({
      commit
    }, token) {
      axios.get('/api/user/profile', {
          headers: {
            Authorization: 'Bearer ' + token
          }
        })
        .then(response => {
          const userRole = response.data.role.role

          commit('SET_USER_ROLE', userRole)
        })
        .catch(error => {
          console.log(error)
        })
    },
  },
  getters: {
    isAuthenticated(state) {
      return state.userRole !== ''
    },
    isAdmin(state) {
      return state.userRole === 'admin'
    },
    isDriver(state) {
      return state.userRole === 'driver'
    },
    isPassenger(state) {
      return state.userRole === 'passenger'
    },
  },

  plugins: [
    VuexPersist({
      key: 'Vuex-pesanan',
      storage: localStorage
    })
  ]
})
