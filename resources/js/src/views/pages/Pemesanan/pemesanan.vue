<template>
  <v-card>
    <v-tabs v-model="tab" fixed-tabs>
      <v-tab color="primary">
        Ekonomi
      </v-tab>
      <v-tab>
        Eksekutif
      </v-tab>
    </v-tabs>
    <v-container>
      <v-row>
        <v-col> <v-select v-model="dateFilter" label="Tanggal" clearable></v-select></v-col>
        <v-col><v-select v-model="routeFilter" label="Rute" clearable></v-select></v-col>
      </v-row>
    </v-container>
    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card flat>
          <v-card v-for="eco in economi" :key="eco.schedule_id" class="mb-2">
            <v-row no-gutters>
              <v-col cols="auto">
                <v-avatar size="40" class="mt-2 ml-2">
                  <img :src="require('@/assets/images/logos/logo-KBT.png').default" max-height="50px" max-width="100px"
                    alt="avatar">
                </v-avatar>
              </v-col>
              <v-col>
                <div class="d-flex justify-content-between">
                  <v-card-title class="text-h6 mb-0">{{ eco.merk }} ({{ eco.police_number }})</v-card-title>
                  <div class="text-h6 mt-4 mr-5" style="color:#FF4C51;">
                    Rp.{{ eco.harga }}
                  </div>
                </div>
                <v-row no-gutters class="my-3">
                  <v-col cols="12">
                    <div class="row">
                      <div class="col-md-5"><v-icon left>{{ icons.mdiCalendarClock }}</v-icon> {{ formatDate(eco.tanggal)
                      }}</div>
                      <div class="col-md-3"><v-icon left>{{ icons.mdiAccount }}</v-icon> {{ eco.name }}</div>
                      <div class="col-md-2" v-for="(count, id) in bookingCounts" :key="id" v-if="eco.schedule_id == id">
                        <small color="secondary">Tersedia : {{ eco.number_of_seats - count - 1 }} Kursi </small>
                      </div>
                      <div class="col-md-2">
                        <v-btn color="secondary" @click="selectBus(eco.schedule_id, eco.harga)" class="ml-3"
                          style="color: white; font-weight:bold;">
                          Pesan
                        </v-btn>
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
        <v-card flat>
          <v-card-text v-for="exe in executive" :key="exe.schedule_id">
            <!-- <v-card class="mt-2"> -->
            <v-row no-gutters>
              <v-col cols="auto">
                <v-avatar size="40" class="mt-2 ml-2">
                  <img :src="require('@/assets/images/logos/logo-KBT.png').default" max-height="50px" max-width="100px"
                    alt="avatar">
                </v-avatar>
              </v-col>
              <v-col>
                <div class="d-flex justify-space-between flex-row">
                  <v-card-title class="text-h6 mb-0">{{ exe.merk }} ({{ exe.police_number }})</v-card-title>
                  <div class="text-h6 mt-4 mr-5" style="color:#FF4C51;">
                    Rp.{{ exe.harga }}
                  </div>
                </div>

                <v-card-text class="d-flex justify-space-between flex-column flex-sm-row fill-height">
                  <div><v-icon left>{{ icons.mdiCalendarClock }}</v-icon> {{ formatDate(exe.tanggal) }}</div>
                  <div><v-icon left>{{ icons.mdiAccount }}</v-icon> {{ exe.name }}</div>
                  <div class="col-md-2" v-for="(countsExe, id) in bookingCounts" :key="id" v-if="exe.schedule_id == id">
                    <small color="secondary">Tersedia : {{ exe.number_of_seats - countsExe - 1 }} Kursi </small>
                  </div>
                  <v-btn color="secondary" @click="selectBus(exe.schedule_id, exe.harga)"
                    style="color: white; font-weight:bold;">
                    Pesan
                  </v-btn>
                </v-card-text>
              </v-col>
            </v-row>
            <!-- </v-card> -->
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';
import { mapActions } from 'vuex';


import { mdiCalendarClock, mdiAccountGroup, mdiAccount } from '@mdi/js';
export default {
  setup() {
    return {
      icons: {
        mdiCalendarClock,
        mdiAccountGroup,
        mdiAccount
      }
    }
  },

  data() {
    return {
      tab: null,
      economi: [],
      executive: [],
      bookingCounts: {},
      bookingCountsExe: {},
      hasbookedEco: '',
      hasbookedExe: '',
      dateFilter: null,
      routeFilter: null,
    }
  },
  computed: {

  },
  methods: {
    ...mapActions(['setSelectedSeat']),
    selectBus(id_schedule, harga) {
      // set data bus yang dipilih ke state Vuex
      this.$store.dispatch('setBusData', { id_schedule, harga })

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
    countBookings(bookings) {
      const counts = {};
      bookings.forEach((booking) => {
        if (counts[booking.schedules_id]) {
          counts[booking.schedules_id]++;
        } else {
          counts[booking.schedules_id] = 1;
        }
      });
      return counts;
    },
    countBookingsExe(bookings) {
      const countsExe = {};
      bookings.forEach((booking) => {
        if (countsExe[booking.schedules_id]) {
          countsExe[booking.schedules_id]++;
        } else {
          countsExe[booking.schedules_id] = 1;
        }
      });
      return countsExe;
    },
  },

  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get('/api/schedule/type/economi', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.economi = response.data.data;
      this.bookingCounts = this.countBookings(response.data.total);
    }).catch(error => {
      console.log(error);
    });

    axios.get('/api/schedule/type/executive', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.executive = response.data.data;
      this.bookingCountsExe = this.countBookingsExe(response.data.total);
    }).catch(error => {
      console.log(error);
    });
  }
}
</script>
