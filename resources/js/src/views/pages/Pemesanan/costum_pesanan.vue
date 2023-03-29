<template>
  <v-card>
    <h3 pa-3 ma-3>Costumise Pesanan</h3>

    <div v-for="item in schedule" :key="item.id">
      <v-container class="grey text-center">
        <v-row no-gutters>
          <v-col v-for="n in +item.number_of_seats" :key="n" cols="2" sm="4">
            <div v-if="n != 3" :class="['pa- text-center  text-no-wrap rounded', {
              'style': selectedChair === n,
              'booked': bookingsChair.some(chair => chair.num_seats === n)
            }]" @click="selectedChair = n">
              <v-icon x-large>{{ selectedChair === n ? icons.mdiSofaSingle : icons.mdiSofaSingleOutline }}</v-icon>
              <h4>{{ n }}</h4>
            </div>
            <div v-else>
              <h4>Supir</h4>
            </div>
          </v-col>
        </v-row>
      </v-container>
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
</template>



<script>
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';
import { mapState, mapActions } from 'vuex'
import { mdiCalendarClock, mdiAccountGroup, mdiAccount, mdiSofaSingleOutline, mdiSofaSingle, mdiChevronRight } from '@mdi/js';

export default {
  setup() {
    return {

      icons: {
        mdiCalendarClock,
        mdiAccountGroup,
        mdiAccount,
        mdiSofaSingleOutline,
        mdiSofaSingle,
        mdiChevronRight
      }
    }
  },

  data() {
    return {
      schedule: {},
      selectedChair: null,
      bookingsChair: [],
    }
  },
  computed: {
    ...mapState(['busData', 'selectedSeat'])
  },

  mounted() {
    this.getSchedule();
    this.getbookingsChair()
  },

  methods: {
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
      axios.get(`/api/bookings/show/schedules/${this.busData}`, {
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
      let uri = `/api/schedule/show/${this.busData}`;
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
    }
  },
  watch: {
    // cek setiap kali nilai dari selectedChair berubah
    selectedChair(newValue) {
      // simpan data selectedSeat ke local storage
      localStorage.setItem('selectedSeat', JSON.stringify(newValue));

      if (this.bookingsChair.some(chair => chair.num_seats === newValue)) {
        alert('Kursi telah dipilih orang lain');
        this.selectedChair = null;
      }
    }
  }
}
</script>

<style scoped>
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
