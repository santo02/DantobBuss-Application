<template>
  <v-app>
    <v-row>
      <v-container>
        <v-img height="400px" src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg">
          <v-card-title>
            <v-btn small color="primary" class="btn-pesan">
              Pesan E-Ticket
            </v-btn>
          </v-card-title>
          <v-card-title class="text-title">
            <h5 class="white--text">Pelayanan terbaik untuk perjalanan kamu</h5>
          </v-card-title>
        </v-img>
      </v-container>
    </v-row>
    <v-container>
      <v-row>
        <v-col> <v-select v-model="dateFilter" label="Tanggal" clearable></v-select></v-col>
        <v-col><v-select v-model="routeFilter" label="Rute" clearable></v-select></v-col>
      </v-row>
    </v-container>
    <v-slide-group class="pa-4" multiple show-arrows>
      <v-slide-item v-for="n in 10" :key="n" v-slot="{ active, toggle }">
        <v-card :color="active ? 'secondary' : 'grey lighten-1'" class="ma-4" height="200" width="150" @click="toggle">
          <v-row class="fill-height" align="center" justify="center">
            <v-scale-transition>
              <v-icon v-if="active" color="white" size="48" v-text="'mdi-close-circle-outline'"></v-icon>
            </v-scale-transition>
          </v-row>
        </v-card>
      </v-slide-item>
    </v-slide-group>
    <h3 class="m-4">Operasional Mobil Bus Danau Toba</h3>
    <v-card v-for="item in schedules" :key="item.schedule_id" class="mb-2">
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
                <div class="col-md-5"><v-icon left>{{ icons.mdiCalendarClock }}</v-icon> {{ formatDate(item.tanggal) }}
                </div>
                <div class="col-md-3"><v-icon left>{{ icons.mdiAccount }}</v-icon> {{ item.name }}</div>
                <div class="col-md-2" v-for="(count, id) in bookingCounts" :key="id" v-if="item.schedule_id == id">
                  <small color="secondary">Tersedia : {{ item.number_of_seats - count  - 1 }} Kursi </small>
                  <!-- <small color="secondary" v-else>Tersedia : {{ item.number_of_seats - count - 1 }} Kursi </small> -->
                </div>
                <div class="col-md-2">
                  <v-btn color="secondary" @click="selectBus(item.schedule_id, item.harga)" class="ml-3"
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
  </v-app>
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
      schedules: [],
      bookingCounts: {},
      busData:{
        id_schedule: '',
        harga: ''
      },
      dateFilter: null,
      routeFilter: null

    }
  },
  methods: {
    ...mapActions(['setSelectedSeat']),
    selectBus(id_schedule, harga) {
      // set data bus yang dipilih ke state Vuex
      this.$store.dispatch('setBusData', {id_schedule, harga})

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

    getSchedule() {
      const access_token = localStorage.getItem('access_token');

      axios.get('/api/schedule/show/all', {
        headers: {
          'Authorization': `Bearer ${access_token}`
        }
      }).then(response => {
        this.schedules = response.data.data;
        this.st = response.data.total;
        this.bookingCounts = this.countBookings(response.data.total);

        console.log(this.schedules);
        console.log(this.st);
      }).catch(error => {
        console.log(error);
      });
    },
    countBookings(bookings) {
      const count = {};
      bookings.forEach((booking) => {
        if (count[booking.schedules_id]) {
          count[booking.schedules_id]++;
        } else {
          count[booking.schedules_id] = 1;
        }
      });
      return count;
    },
  },
  mounted() {
    this.getSchedule();
  }
}




</script>
<style>
@media only screen and (max-width: 480px) {
  .btn-pesan {
    margin-top: 160px;
    height: 15px;
    padding-left: 30px;
    width: 120px;
    font-size: 10px;
    height: 50px;
  }

  .text-title {
    position: absolute;
    text-align: center;
  }
}

@media only screen and (min-width: 481px) {
  .btn-pesan {
    margin-top: 160px;
    height: 15px;
    padding-left: 30px;
    width: 240px;
    height: 50px;
  }

  .text-title {
    position: absolute;
    margin-left: 60%;
  }
}
</style>
