<template>
  <v-app>
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
            <v-card-title class="text-h6">{{ item.derpature }} - {{ item.arrival }}</v-card-title>
            <div class="text-h6 mt-4 mr-5 harga" style="color:#FF4C51;">
              Rp.{{ item.harga }}
            </div>
          </div>
          <div class="d-flex justify-content-between ml-5">
            <h6>{{ item.nomor_pintu }} </h6>
            <h6 class="text--primary ml-5">{{ item.type }} </h6>
          </div>
          <v-row no-gutters class="my-3">
            <v-col cols="12" class="detail">
              <div class="row">
                <div class="col-md-3"><v-icon left>{{ icons.mdiCalendarClock }}</v-icon> {{ formatDate(item.tanggal)
                }}</div>
                <div class="col-md-2"><v-icon left>{{ icons.mdiAccount }}</v-icon> {{ item.name }}</div>
                <div class="col-md-2" v-for="(count, id) in bookingCounts" :key="id" v-if="item.schedule_id == id">
                  <small color="secondary">Tersedia : {{ item.number_of_seats - count - 1 }} Kursi </small>
                  <!-- <small color="secondary" v-else>Tersedia : {{ item.number_of_seats - count - 1 }} Kursi </small> -->
                </div>
                <v-row class="col-md-2 d-flex justify-space-around">
                  <div class="col-md-2">
                    <v-btn color="secondary" @click="selectBus(item.schedule_id, item.harga)" class="ml-3"
                      style="color: white; font-weight:bold;">
                      Pesan
                    </v-btn>
                  </div>
                </v-row>
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
      busData: {
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
      return moment(date).format('dddd, Do MMMM YYYY, hh:mm');
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

  .detail {
    font-size: 12px;
  }
}
</style>
