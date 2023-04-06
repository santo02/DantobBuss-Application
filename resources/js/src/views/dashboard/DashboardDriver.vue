<template>
  <v-app>

    <h3 class="m-4">Jadwal Hari ini,</h3>
    <div>
      <v-card v-for="item in todaySchedules" :key="item.schedule_id" class="mb-2">
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
                  }}
                  </div>
                  <div class="col-md-3"><v-icon left>{{ icons.mdiAccount }}</v-icon> {{ item.name }}</div>
                </div>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-card>
    </div>
    <h3 class="mt-3">Jadwal Pengoperasian Mobil Bus Kamu</h3>
    <v-data-table :headers="headers" :items="schedules" :items-per-page="10" class="elevation-1">
      <template v-slot:[`item.tanggal`]="{ item }">
        {{ formatDate(item.tanggal) }}
      </template>
      <template v-slot:[`item.detail`]="{ item }">
        <p class="text--primary" @click="selectBus(item.schedule_id)">
          Detail
        </p>
      </template>
    </v-data-table>
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
      },
      headers: [
        { text: 'Tanggal', value: 'tanggal' },
        { text: 'Keberangkatan', value: 'arrival'  },
        { text: 'Kedatangan', value: 'derpature'  },
        { text: 'Jumlah Kursi', value: 'number_of_seats' },
        { text: 'Detail', value: 'detail' }
      ]
    }
  },
  data() {
    return {
      schedules: [],
      bookingCounts: {},
      dateFilter: null,
      routeFilter: null

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

    getSchedule() {
      const access_token = localStorage.getItem('access_token');

      axios.get('/api/schedules/driver', {
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
  },
  mounted() {
    this.getSchedule();
  },
  computed: {
    todaySchedules() {
      const today = moment().format('YYYY-MM-DD');

      console.log(today);
      return this.schedules.filter((item) => moment(item.tanggal).format('YYYY-MM-DD') === today);
    }
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
