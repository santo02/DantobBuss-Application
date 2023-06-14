<template>
  <v-app>
    <h3 pa-3 ma-3>Pilih Nomor Kursi </h3>
    <v-card>
      <div v-for="item in schedule" :key="item.id">
        <div class="chair" style="width: 400px; margin: 100 auto;">
          <v-container v-if="item.type === 'Ekonomi'" class="grey text-center" style="width: 400px;">
            <v-row no-gutters>
              <v-col v-for="n in +item.number_of_seats" :key="n" cols="2" sm="4">
                <div v-if="n !== 3" :class="['pa- text-center  text-no-wrap rounded', {
                  'style': selectedChair === (n > 3 ? n - 1 : n),
                  'booked': bookingsChair.some(chair => chair.num_seats === (n > 3 ? n - 1 : n))
                }]" @click="selectedChair = (n > 3 ? n - 1 : n)">
                  <v-icon x-large>{{ selectedChair === (n > 3 ? n - 1 : n) ? icons.mdiSofaSingle :
                    icons.mdiSofaSingleOutline
                  }}</v-icon>
                  <h4>{{ n > 3 ? n - 1 : n }}</h4>
                </div>
                <div v-else>
                  <h4>
                    <v-icon x-large>{{ icons.mdiSteering }}</v-icon>
                  </h4>
                </div>
              </v-col>
            </v-row>
          </v-container>
          <v-container v-else class="grey text-center">
            <v-row no-gutters>
              <v-col v-for="n in +item.number_of_seats + 4" :key="n" :cols="getColSize(n)">
                <div v-if="n === 3">
                  <v-icon x-large>{{ icons.mdiSteering }}</v-icon>
                </div>
                <div v-else-if="n === 2 || n === 4 || n === 9 || n === 13">

                </div>
                <div v-else
                  :class="['pa-', 'text-center', 'text-no-wrap', 'rounded', { 'style': selectedChair === (n >= 4 && n <= 8 ? n - 3 : n >= 10 && n <= 12 ? n - 4 : n >= 13 ? n - 5 : n), 'booked': bookingsChair.some(chair => chair.num_seats === (n > 2 ? n - 1 : n)) }]"
                  @click="selectedChair = (n >= 4 && n <= 8 ? n - 3 : n >= 10 && n <= 12 ? n - 4 : n >= 13 ? n - 5 : n)">
                  <v-icon x-large>{{ selectedChair === (n >= 5 && n <= 8 ? n - 3 : n >= 10 && n <= 12 ? n - 4 : n >= 13 ? n
                    - 5 : n) ?
                    icons.mdiSofaSingle :
                    icons.mdiSofaSingleOutline }}</v-icon>
                  <h4>{{ n >= 5 && n <= 8 ? n - 3 : n >= 10 && n <= 12 ? n - 4 : n >= 13 ? n - 5 : n }}</h4>
                </div>
              </v-col>
            </v-row>
          </v-container>
        </div>

        <div class="check" v-if="selectedChair !== null">
          <v-container class="grey text-center">
            <v-card class="mb-3">
              <v-row>
                <v-col cols="2" sm="4">
                  <div class="pa-2" tile>
                    <h3>Seat</h3>
                    <h5>{{ selectedChair }}</h5>
                  </div>
                </v-col>
                <v-col cols="2" sm="4">
                  <div class="pa-2">
                    <v-btn class="mx-2" fab dark color="secondary" @click="selectSeat(selectedChair)">
                      <v-icon dark>
                        {{ icons.mdiChevronRight }}
                      </v-icon>
                    </v-btn>
                  </div>
                </v-col>
                <v-col cols="2" sm="4">
                  <div class="pa-2" tile>
                    <h3>Harga</h3>
                    <h5>Rp.{{ item.harga }}</h5>
                  </div>
                </v-col>
                <v-col cols="2" sm="6">
                  <div class="pa-2" tile>
                    <h3>Menaikkan</h3>
                    <h5>{{ item.derpature }}</h5>
                  </div>
                </v-col>
                <v-col cols="2" sm="6">
                  <div class="pa-2" tile>
                    <h3>Menurunkan</h3>
                    <h5>{{ item.arrival }}</h5>
                  </div>
                </v-col>
              </v-row>
            </v-card>
          </v-container>
        </div>
      </div>
    </v-card>
    <v-snackbar v-model="snackbar.show" :timeout="snackbar.timeout" :color="snackbar.color">
      {{ snackbar.message }} <!-- Menampilkan pesan snackbar -->
      <template v-slot:action> <!-- Menampilkan aksi/snackbar action -->
        <v-btn text @click="closeSnackbar">OK</v-btn>
        <!-- Menggunakan v-btn untuk aksi dan memanggil method closeSnackbar() -->
      </template>
    </v-snackbar>
  </v-app>
</template>



<script>
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';
import { mapState, mapActions } from 'vuex'
import { mdiCalendarClock, mdiAccountGroup, mdiAccount, mdiSofaSingleOutline, mdiSofaSingle, mdiChevronRight, mdiSteering } from '@mdi/js';

export default {
  setup() {
    return {

      icons: {
        mdiCalendarClock,
        mdiAccountGroup,
        mdiAccount,
        mdiSofaSingleOutline,
        mdiSofaSingle,
        mdiChevronRight,
        mdiSteering
      }
    }
  },

  data() {
    return {
      schedule: {},
      selectedChair: null,
      bookingsChair: [],
      snackbar: {
        show: false,
        message: '',
        timeout: 3000,
        color: 'error'
      }
    }
  },
  computed: {
    ...mapState(['busData', 'selectedSeat']),
    id_schedule() {
      return this.$store.state.busData.id_schedule
    },
    harga() {
      return this.$store.state.busData.harga
    }
  },

  mounted() {
    this.getSchedule();
    this.getbookingsChair()
  },

  methods: {
    getColSize(n) {
      if (n <= 3) {
        return 4; // Lebar kolom untuk bagian depan (2 kursi)
      } else if (n <= 5) {
        return 3; // Lebar kolom untuk baris kedua (4 kursi dengan spasi)
      } else if (n <= 9) {
        return 3; // Lebar kolom untuk baris ketiga (4 kursi dengan spasi)
      } else if (n <= 12) {
        return 3; // Lebar kolom untuk baris keempat (4 kursi dengan spasi)
      } else {
        return 3; // Lebar kolom untuk baris kelima (4 kursi rapat)
      }
    },
    getDisplayedSeatNumber(n) {
      // if (n === 2 || n === 6 || n === 9) {
      //   return ' '; // Mengembalikan spasi untuk kursi yang ingin ditampilkan sebagai spasi
      // } else {
      return n; // Mengembalikan nomor kursi asli
      // }
    },
    formatDate(date) {
      moment.locale('id');
      return moment(date).format('dddd, Do MMMM YYYY, hh:mm:ss');
    },
    ...mapActions(['setSelectedSeat']),

    selectSeat(seat) {
      // set tempat duduk yang dipilih ke state Vuex
      this.$store.dispatch('setSelectedSeat', seat)

      this.$router.push('/confirmasi-pemesanan')
    },

    getbookingsChair() {
      const access_token = localStorage.getItem('access_token');
      axios.get(`/api/bookings/show/schedules/${this.id_schedule}`, {
        headers: {
          'Authorization': `Bearer ${access_token}`
        }
      }).then(response => {
        this.bookingsChair = response.data.data.map((item) => {
          return {
            num_seats: item.num_seats,
          }
        });

        console.log(this.bookingsChair);
      }).catch(error => {
        console.log(error);
      });
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
        // this.number = response.data.data.number_of_seats;
        // console.log(this.number)
      }).catch(error => {
        console.log(error);
      });
    },
    closeSnackbar() {
      this.snackbar.show = false;
    },
  },
  watch: {
    // cek setiap kali nilai dari selectedChair berubah
    selectedChair(newValue) {
      // simpan data selectedSeat ke local storage
      localStorage.setItem('selectedSeat', JSON.stringify(newValue));

      // Jika newValue lebih besar dari 3, kurangi satu
      if (newValue > 3) {
        newValue === newValue - 1;
      }
      if (this.bookingsChair.some(chair => chair.num_seats === newValue)) {
        this.snackbar.message = 'Kursi telah dipilih orang lain';
        this.snackbar.show = true;
        this.selectedChair = null;
      }
    }
  }

}
</script>

<style scoped>
.chair {
  width: 400px;
  margin: 100px auto;
}

@media (max-width: 600px) {
  .chair {
    width: 100%;
    margin: 0 auto;
  }
}

.style {
  background-color: gainsboro;
  color: white;
  cursor: pointer;

}

.booked {
  background-color: rgb(173, 173, 173);
  color: black;
  position: relative;
}

.booked::before {
  content: "Telah di booking";
  position: absolute;
  color: #000;
  padding: 5px 10px;
  border-radius: 5px;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}
</style>
