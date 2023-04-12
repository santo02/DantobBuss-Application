<template>
  <div>
    <h3 pa-3 ma-3>E-ticket</h3>
    <v-card width="500px" class="mx-auto p-3">
      <div class="container m-3">
        <div class=" text-center">
          <v-avatar size="40" class="mt-2 ml-2">
            <img :src="require('@/assets/images/logos/logo-KBT.png').default" max-height="50px" max-width="100px"
              alt="avatar">
          </v-avatar>
          <h5>KBT</h5>
          <h5>E-Ticket</h5>
          <h6>INV-EKBT-1206202309590</h6>
        </div>
        <v-simple-table class="p-3">
          <template>
            <thead>
              <tr>
                <th colspan="2" class="text-left">
                  <h2>Rincian Bus</h2>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Tipe</td>
                <td>: Economi</td>
              </tr>
              <tr>
                <td>Asal</td>
                <td>: Medan</td>
              </tr>
              <tr>
                <td>Tujuan </td>
                <td>: Tarutung</td>
              </tr>
              <tr>
                <th colspan="2">
                  <h2>Rincian Penumpang</h2>
                </th>
              </tr>
              <tr>
                <td>Nama</td>
                <td>: Santo L Harianja</td>
              </tr>
              <tr>
                <td>Umur</td>
                <td>: 23 Tahun</td>
              </tr>
              <tr>
                <td>Bangku </td>
                <td>: 6</td>
              </tr>
              <tr class="p-3">
                <td>Tarif </td>
                <td class="text-right"> <b> Rp. 80.000</b></td>
              </tr>
              <tr class="mt-3">
                <td>
                  <h3>Status Pembayaran</h3>
                </td>
                <td class="text-right">
                  <h3 class="text--primary">Lunas</h3>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </div>
    </v-card>
    <div class="mx-auto text-center mt-4" width="500px">
      <v-btn color="primary" width="500px" height="40px">Download</v-btn>
    </div>
  </div>
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
  computed: {
    ...mapState({
      selectedSeat: state => state.selectedSeat,
    }),
    id_schedule() {
      return this.$store.state.busData.id_schedule
    },
    harga() {
      return this.$store.state.busData.harga
    }

  },
  data() {
    return {
      schedule: {},
      jemput: false,
      passenger: {
        name: '',
        age: '',
        alamatJemput: "not request"
      },
      snackbar: false,
      items: ["Balige", "Tambunan", "Tampubolon", "Laguboti"]

    }
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
    ...mapActions(['setPassengerData']),
    submitData() {
      if (!this.passenger.name || !this.passenger.age) {
        // Tampilkan pesan error menggunakan Vuetify Snackbar
        this.snackbar = true;
        return;
      }
      // set data penumpang ke state Vuex
      this.$store.dispatch('setPassengerData', this.passenger)

      // redirect ke halaman berhasil
      this.$router.push('/pembayaran')
    }
  },
}
</script>


