<template>
  <div class="payment-gateway">
    <h2 class="title">How to Pay</h2>
    <div class="payment-details">
      <p class="detail">
        <strong>Virtual Account Number:</strong>
        <span class="virtual-account-number">{{ paymentInstructions.virtual_account_info.virtual_account_number }}</span>
        <v-btn class="copy-button" @click="copyVirtualAccountNumber" icon>
          <v-icon>mdi-content-copy</v-icon>
        </v-btn>
      </p>
      <p class="detail"><strong>Amount:</strong> {{ paymentInstructions.order.amount }}</p>
      <p class="detail"><strong>Status:</strong> {{ paymentInstructions.virtual_account_info.status }}</p>
    </div>

    <v-expansion-panels>
      <v-expansion-panel v-for="instruction in paymentInstructions.payment_instruction" :key="instruction.channel">
        <v-expansion-panel-header>{{ instruction.channel }}</v-expansion-panel-header>
        <v-expansion-panel-content>
          <ol class="instruction-list">
            <li v-for="step in instruction.step" :key="step">{{ step }}</li>
          </ol>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
  </div>
</template>

<style scoped>
.payment-gateway {
  max-width: 500px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f5f5f5;
  border: 1px solid #e0e0e0;
  border-radius: 5px;
}

.title {
  font-size: 24px;
  margin-bottom: 10px;
}

.payment-details {
  margin-bottom: 20px;
}

.detail {
  margin-bottom: 5px;
}

.virtual-account-number {
  font-weight: bold;
  padding: 2px 5px;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  border-radius: 3px;
}

.copy-button {
  margin-left: 10px;
  min-width: 36px;
  height: 36px;
  color: #757575;
}

.instruction-list {
  margin-top: 10px;
  padding-left: 20px;
}

/* Additional styles for Vuetify components */
.v-expansion-panels {
  margin-top: 20px;
}

</style>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      paymentInstructions: []
    };
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');
    let url = this.$route.params.howToPayApi
    axios.get(url, {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.paymentInstructions = response.data;
    }).catch(error => {
      console.log(error);
    });
  },
  methods: {
    copyVirtualAccountNumber() {
      const virtualAccountNumber = this.paymentInstructions.virtual_account_info.virtual_account_number;
      const tempInput = document.createElement('input');
      tempInput.value = virtualAccountNumber;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand('copy');
      document.body.removeChild(tempInput);
    }
  }
}
</script>
