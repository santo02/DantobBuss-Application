<template>
  <div>
    <h2>Riwayat Perjalanan</h2>
    <v-tabs v-model="tab" fixed-tabs>
      <v-tab>
        Selesai
      </v-tab>
      <v-tab>
        Dibatalkan
      </v-tab>
    </v-tabs>
    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card flat>
          <v-card v-for="item in pesanan" :key="item.schedule_id" class="mb-2">
            <v-row no-gutters>
              <v-col cols="auto">
                <v-avatar size="40" class="mt-2 ml-2">
                  <img :src="require('@/assets/images/logos/logo-KBT.png').default" max-height="50px" max-width="100px"
                    alt="avatar">
                </v-avatar>
              </v-col>
              <v-col>
                <div class="d-flex justify-content-between">
                  <v-card-title class="text-h6 mb-0">{{ item.merk }} ({{ item.police_number }})</v-card-title>
                  <div class="text-h6 mt-4 mr-5" style="color:#FF4C51;">
                    Rp.{{ item.harga }}
                  </div>
                </div>
                <v-row no-gutters class="my-3">
                  <v-col cols="12">
                    <div class="row">
                      <div class="col-md-5"><v-icon left>{{ icons.mdiCalendarClock }}</v-icon> {{ formatDate(item.tanggal)
                      }}</div>
                      <div class="col-md-3"><v-icon left>{{ icons.mdiAccount }}</v-icon> {{ item.name }}</div>
                      <div class="col-md-2">
                        <!-- <v-btn color="secondary" @click="selectBus(eco.schedule_id)" class="ml-3"
                          style="color: white; font-weight:bold;">
                          Pesan
                        </v-btn> -->
                      </div>
                    </div>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-card>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        batal
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';
import { mapActions } from 'vuex';


import { mdiCalendarClock, mdiAccountGroup, mdiAccount } from '@mdi/js';
export default {
  data() {
    return {
      tab: null,
      pesanan: []
    }
  },
  setup() {
    return {
      icons: {
        mdiCalendarClock,
        mdiAccountGroup,
        mdiAccount
      }
    }
  },
  methods: {
    ...mapActions(['setSelectedSeat']),
    selectBus(idSchedulues) {
      // set data bus yang dipilih ke state Vuex
      this.$store.dispatch('setBusData', idSchedulues)

      // pindah ke komponen selanjutnya (pilih tempat duduk)
      this.$router.push('/costumize-pemesanan')
    },
    isSelected(seatNumber) {
      // check apakah tempat duduk sudah dipilih sebelumnya
      return this.$store.state.selectedSeat === seatNumber
    },
    formatDate(date) {
      moment.locale('id');
      return moment(date).format('dddd, Do MMMM YYYY, hh:mm:ss');
    },
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get('/api/bookings/my', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.pesanan = response.data;
    }).catch(error => {
      console.log(error);
    });
  }
}
</script>
