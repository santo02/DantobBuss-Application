<template>
  <div>
    <h3 pa-3 ma-3>Konfirmasi Pesanan</h3>
    <v-card v-for="item in schedule" :key="item.id">
      <div class="container mt-3">
        <div class=" text-center">
          <h2>{{ item.derpature }} -> {{ item.arrival }}</h2>
          <h5>{{ formatHour(item.tanggal) }}</h5>
          <h5>{{ formatDate(item.tanggal) }}</h5>
        </div>
        <div>
          <v-col cols="12" md="3">
            <label for="name">Nama Lengkap</label>
          </v-col>
          <v-col>
            <v-text-field id="name" v-model="name" outlined dense placeholder="Nama Lengkap" hide-details></v-text-field>
          </v-col>
        </div>
        <div>
          <v-col cols="12" md="3">
            <label for="umur">Umur</label>
          </v-col>

          <v-col>
            <v-text-field id="umur" v-model="umur" type="number" outlined dense placeholder="Umur"
              hide-details></v-text-field>
          </v-col>
        </div>
        <div>
          <h4>Dijemput</h4>
          <p>
            Request penjemputan akan diarahkan ke lokasi rekomendasi sistem dengan posisi terdekat dari sekitaran alamat
            yang dicantumkan penumpang.
          </p>
          <v-switch v-model="people" color="primary" value="jemput"></v-switch>
          <v-col v-if="people === 'jemput'" cols="12" md="3">
            <label for="alamat">Alamat Jemput</label>
          </v-col>
          <v-col v-if="people === 'jemput'">
            <v-text-field id="alamat" v-model="alamatJemput" outlined dense placeholder="Alamat Jemput"
              hide-details></v-text-field>
            <v-spacer></v-spacer>
          </v-col>

        </div>

      </div>
      <div class="check">
        <v-container class="grey text-center">
          <v-card class="mb-3">
            <v-row>
              <v-col cols="2" sm="4">
                <div class="pa-2" tile>
                  <h3>Seat</h3>
                  <h5>{{ seat }}</h5>
                </div>
              </v-col>
              <v-col cols="2" sm="4">
                <div class="pa-2">
                  <v-btn class="mx-2" fab dark color="secondary">
                    <router-link :to="{ name: 'pembayaran' }" @click="sendDataToPembayaran">
                      <v-icon dark>
                        {{ icons.mdiChevronRight }}
                      </v-icon>
                    </router-link>
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
    </v-card>
  </div>
</template>



<script>
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';

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
      seat: `${this.$route.params.seat}`,
      schedule: {},
      people: '',
      alamatJemput: '',
      name: '',
      umur: ''
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
      let uri = `/api/schedule/show/${this.$route.params.id}`;
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
    sendDataToPembayaran() {
      const paymentData = {
        seat: this.seat,
        schedule: this.schedule,
        people: this.people,
        alamatJemput: this.alamatJemput,
        name: this.name,
        umur: this.umur
      };
      this.$store.dispatch('setPaymentData', paymentData);
      this.$router.push({ name: 'pembayaran' });
    }
  }
}
</script>


