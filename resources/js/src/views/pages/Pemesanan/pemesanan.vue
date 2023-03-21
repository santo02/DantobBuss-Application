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

    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card flat>
          <v-card-text v-for="eco in economi" :key="eco.id">
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
                  <v-card-title class="text-h6 mb-0">{{ eco.merk }} ({{ eco.police_number }})</v-card-title>
                  <div class="text-h6 mt-4 mr-5" style="color:#FF4C51;">
                    Rp.{{ eco.harga }}
                  </div>
                </div>

                <v-card-text class="d-flex justify-space-between flex-column flex-sm-row fill-height">
                  <div><v-icon left>{{ icons.mdiCalendarClock }}</v-icon> {{ formatDate(eco.tanggal) }}</div>
                  <div><v-icon left>{{ icons.mdiAccount }}</v-icon> {{ eco.name }}</div>
                  <div><v-icon left>{{ icons.mdiAccountGroup }}</v-icon> {{ eco.number_of_seats }}</div>
                  <router-link style="text-decoration:none;"
                    :to="{ name: 'pages-costumize-pemesanan', params: { id: eco.schedule_id } }"> <v-btn color="secondary"
                      style="color: white; font-weight:bold;">
                      Pesan
                    </v-btn></router-link>
                </v-card-text>
              </v-col>
            </v-row>
            <!-- </v-card> -->
          </v-card-text>
        </v-card>
      </v-tab-item>

      <v-tab-item>
        <v-card flat>
          <v-card-text v-for="exe in executive" :key="exe.id">
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
                  <div><v-icon left>{{ icons.mdiAccountGroup }}</v-icon> {{ exe.number_of_seats }}</div>
                  <router-link style="text-decoration:none;"
                    :to="{ name: 'pages-costumize-pemesanan', params: { id: exe.schedule_id } }"> <v-btn color="secondary"
                      style="color: white; font-weight:bold;">
                      Pesan
                    </v-btn></router-link>
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
      items: [
        'Appetizers', 'Entrees',
      ],
      economi: [],
      executive: [],
    }
  },
  methods: {
    formatDate(date) {
      moment.locale('id');
      return moment(date).format('dddd, Do MMMM YYYY, hh:mm:ss');
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get('/api/schedule/type/economi', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.economi = response.data.data;

      console.log(this.economi);


    }).catch(error => {
      console.log(error);
    });

    axios.get('/api/schedule/type/executive', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.executive = response.data.data;

      console.log(this.executive);


    }).catch(error => {
      console.log(error);
    });
  }
}
</script>
