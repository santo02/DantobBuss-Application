<template>
  <div>
    <h3 pa-3 ma-3>Pembayaran</h3>
    <v-card v-for="item in schedule" :key="item.id">
      <div class="container mt-3">
        <div class=" text-center">
          <h2>{{ item.derpature }} -> {{ item.arrival }}</h2>
          <h5>{{ formatHour(item.tanggal) }}</h5>
          <h5>{{ formatDate(item.tanggal) }}</h5>
          <h5>{{ item.harga }}</h5>
        </div>
        <template class="text-center">
          <v-container class="grey lighten-5">
            <v-row no-gutters>
              <v-col cols="12" sm="4">
                <v-card class="pa-2" outlined tile>
                  <h5>Nama</h5>
                  <h6>{{ passengerData.name }}</h6>
                </v-card>
              </v-col>
              <v-col cols="12" sm="4">
                <v-card class="pa-2" outlined tile>
                  <h5>Umur</h5>
                  <h6>{{ passengerData.age }}</h6>
                </v-card>
              </v-col>
              <v-col cols="12" sm="4">
                <v-card class="pa-2" outlined tile>
                  <h5>No.Tempat duduk</h5>
                  <h6>{{ selectedSeat }}</h6>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </template>
        <v-container>
          <v-banner elevation="4">
            <v-row align="center" color="black" justify="center" @click="showPaymentMethods = !showPaymentMethods">
              <v-col cols="auto">
                <v-icon size="22">{{ icons.mdiCreditCard }}</v-icon>
              </v-col>
              <v-col>
                <span class="text-subtitle-1 ml-2">Pilih metode Pembayaran</span>
              </v-col>
              <v-col cols="auto">
                <v-icon size="22">{{ icons.mdiChevronRight }}</v-icon>
              </v-col>
            </v-row>
            <v-row v-if="showPaymentMethods">
              <v-col>
                <v-radio-group v-model="selectedMethod">
                  <!-- tunai -->
                  <div v-if="userRole == 'admin'">
                    <v-banner>
                      <v-row>
                        <v-col cols="auto">
                          <v-icon size="22" color="primary">{{ icons.mdiCashCheck }}</v-icon>
                        </v-col>
                        <v-col @click="togglePaymentcash">
                          Tunai
                        </v-col>
                        <v-col cols="auto">
                          <v-icon size="22">{{ icons.mdiChevronRight }}</v-icon>
                        </v-col>
                      </v-row>
                    </v-banner>
                    <v-col v-if="showPaymentcash">
                      <v-col>
                        <v-btn color="primary" @click.prevent="BayarCash">Bayar</v-btn>
                      </v-col>
                    </v-col>

                  </div>

                  <!-- nontunai -->
                  <div v-if="userRole == 'passenger'">
                    <v-banner>
                      <v-row>
                        <v-col cols="auto">
                          <v-icon size="22" color="primary">{{ icons.mdiWalletOutline }}</v-icon>
                        </v-col>
                        <v-col @click="togglePaymentNoncash">
                          NonTunai
                        </v-col>
                        <v-col cols="auto">
                          <v-icon size="22">{{ icons.mdiChevronRight }}</v-icon>
                        </v-col>
                      </v-row>
                    </v-banner>
                    <v-col v-if="showPaymentNoncash">
                      <v-col class="ml-3">
                        <v-row>
                          <v-col cols="auto">
                            <v-col>
                              <v-btn color="primary" @click.prevent="BayarNontunai">Bayar Sekarang</v-btn>
                            </v-col>
                          </v-col>
                        </v-row>
                      </v-col>
                    </v-col>
                  </div>
                </v-radio-group>
              </v-col>
            </v-row>
          </v-banner>
        </v-container>
      </div>
    </v-card>
  </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';
import { mapState } from 'vuex';

import { mdiChevronRight, mdiCreditCard, mdiCashCheck, mdiWalletOutline } from '@mdi/js';

export default {
  data() {
    return {
      showPaymentMethods: false,
      showPaymentcash: false,
      showPaymentNoncash: false,
      selectedMethod: null,
      amount: null,
      schedule: {},
      icons: {
        mdiChevronRight,
        mdiCreditCard,
        mdiCashCheck,
        mdiWalletOutline
      },

      bookings: [
        'schedules_id',
        'name',
        'age',
        'num_seats',
        'alamat_jemput',
        'status',
        'harga'
      ],
    }
  },
  computed: {
    ...mapState(['selectedSeat']),
    passengerData() {
      return this.$store.state.passengerData
    },
    id_schedule() {
      return this.$store.state.busData.id_schedule
    },
    harga() {
      return this.$store.state.busData.harga
    },
    userRole() {
      return this.$store.state.userRole
    },
  },
  mounted() {
    this.getSchedule();
  },

  methods: {
    formatDate(date) {
      moment.locale('id');
      return moment(date).format('dddd, Do MMMM YYYY');
    },
    formatHour(date) {
      moment.locale('id');
      return moment(date).format('hh:mm');
    },
    togglePaymentcash() {
      this.showPaymentcash = !this.showPaymentcash;
      this.showPaymentNoncash = false
    },
    togglePaymentNoncash() {
      this.showPaymentNoncash = !this.showPaymentNoncash;
      this.showPaymentcash = false
    },
    getSchedule() {
      const access_token = localStorage.getItem('access_token');
      let uri = `/api/schedule/show/${this.id_schedule}`;
      axios.get(uri, {
        headers: {
          'Authorization': `Bearer ${access_token}`
        }
      }).then(response => {
        this.schedule = response.data.data;
        console.log(this.schedule);
      }).catch(error => {
        console.log(error);
      });
    },
    BayarCash() {
      const access_token = localStorage.getItem('access_token');

      axios.post('api/bookings/nontunai', {
        schedules_id: this.busData,
        name: this.passengerData.name,
        age: this.passengerData.age,
        num_seats: this.selectedSeat,
        alamatJemput: this.passengerData.alamatJemput,
        harga: this.schedule.harga,
        status: 'berhasil',
      }, {
        headers: {
          'Authorization': `Bearer ${access_token}`
        }
      }).then(response => {
        console.log(this.bookings);
        this.$router.push({
          name: 'dashboard',
          query: { message: this.message },
        });
      }).catch((error) => {
        console.log(error.response.data.errors)
      })
    },
    BayarNontunai() {
      const access_token = localStorage.getItem('access_token');

      axios.post('api/bookings/nontunai', {
        schedules_id: this.id_schedule,
        name: this.passengerData.name,
        age: this.passengerData.age,
        num_seats: this.selectedSeat,
        alamatJemput: this.passengerData.alamatJemput,
        harga: this.harga,
      }, {
        headers: {
          'Authorization': `Bearer ${access_token}`
        }
      }).then(response => {
        console.log(response.data);
        const { payment: { url } } = response.data.data.response;

        window.open(url, "_blank");
      }).catch((error) => {
        console.log(error)
        // console.log("Gagal")
      })
    }
    ,
  },


}
</script>
