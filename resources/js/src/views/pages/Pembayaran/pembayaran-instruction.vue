<template>
  <div class="payment-gateway">
    <div v-if="paymentInstructions.virtual_account_info.status == 'OPEN'">
      <h2>How to Pay</h2>
      <div v-if="paymentInstructions.virtual_account_info.status == 'OPEN'">
        <div class="payment-details">
          <p>
            <strong>Virtual Account Number:</strong>
            <span class="virtual-account-number">{{ paymentInstructions.virtual_account_info.virtual_account_number
            }}</span>
            <button class="copy-button" @click="copyVirtualAccountNumber">
              Copy
            </button>
          </p>
          <p><strong>Amount:</strong> {{ paymentInstructions.order.amount }}</p>
          <p><strong>Status:</strong> {{ paymentInstructions.virtual_account_info.status }}</p>
        </div>

        <v-expansion-panels>
          <v-expansion-panel v-for="instruction in paymentInstructions.payment_instruction" :key="instruction.channel">
            <v-expansion-panel-header>{{ instruction.channel }}</v-expansion-panel-header>
            <v-expansion-panel-content>
              <ol>
                <li v-for="step in instruction.step" :key="step">{{ step }}</li>
              </ol>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>
      </div>
    </div>
    <div>
      <div v-if="paymentInstructions.virtual_account_info.status == 'PAID'">
        <h1>Pembayaran Berhasil</h1>
        <p><strong>Invoice Number:</strong> {{ paymentInstructions.order.invoice_number }}</p>
        <p><strong>Amount:</strong> {{ paymentInstructions.order.amount }}</p>
        <p><strong>Status:</strong> {{ paymentInstructions.virtual_account_info.status }}</p>
        <p><strong>Expired in:</strong> {{ paymentInstructions.virtual_account_info.expired_in }}</p>
      </div>
    </div>
  </div>
</template>

<style>
/* Styles for the copy button */
.copy-button {
  margin-left: 10px;
  cursor: pointer;
}

/* Styles for the virtual account number */
.virtual-account-number {
  font-weight: bold;
  padding: 2px 5px;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  border-radius: 3px;
}

/* Rest of the styles remain the same */
/* ... */
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
