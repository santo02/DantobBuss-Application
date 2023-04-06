<template>
  <v-card>
    <v-card-title>
      <v-btn class="mb-3" :to="{ name: 'pages-add-mobil' }" color="primary">
        Tambah Mobil
      </v-btn>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="mdi-magnify" label="Cari" hide-details></v-text-field>
    </v-card-title>
    <v-data-table :headers="headers" :items="buss" :search="search">
      <template #item.action="{ item }">
        <v-btn small color="primary" :to="{ name: 'pages-edit-schedule', params: { id: item.id } }"><v-icon center>{{
          icons.mdiPencil }}</v-icon></v-btn>
        <v-btn small color="error" @click="deleteSchedule(item.id)"><v-icon>{{ icons.mdiTrashCanOutline
        }}</v-icon></v-btn>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
import axios from 'axios';
import { mdiPencil, mdiTrashCanOutline } from '@mdi/js';
export default {
  setup() {
    return {
      buss: [
        'police_number',
        'name',
        'number_of_seats',
        'type',
        'status',
      ],
      icons: {
        mdiPencil,
        mdiTrashCanOutline
      }
    }
  },
  data() {
    return {
      buss: [],
      supir: [],
      search: '',
      headers: [
        {
          text: 'Nomor Polisi',
          align: '',
          sortable: false,
          value: 'police_number',

        },
        { text: 'Nomor Pintu', value: 'nomor_pintu' },
        { text: 'Supir', value: 'driver.name' },
        { text: 'Jumlah Seat', value: 'number_of_seats' },
        { text: 'Type', value: 'type' },
        { text: 'status', value: 'status' },
        { text: 'Action', value: 'action', align: 'center', sortable: false }
      ],
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get('/api/buss/show/all', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.buss = response.data.data;
      console.log(this.buss)
    }).catch(error => {
      console.log(error);
    });
  }
}
</script>
