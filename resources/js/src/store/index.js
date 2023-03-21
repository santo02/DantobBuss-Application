// store.js
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    paymentData: {}
  },
  mutations: {
    setPaymentData(state, data) {
      state.paymentData = data;
    }
  },
  actions: {
    setPaymentData(context, data) {
      context.commit('setPaymentData', data);
    }
  }
});

export default store;
