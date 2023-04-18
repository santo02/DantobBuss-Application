<template>
  <v-card>
    <v-card-title>
      <v-btn class="mb-3" :to="{ name: 'pages-add-schedule' }" color="primary">
        Schedule Baru
      </v-btn>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="mdi-magnify" label="Cari" hide-details></v-text-field>
    </v-card-title>
    <v-data-table :headers="headers" :items="schedule" :search="search">
      <template #item.edit="{ item }">
        <v-btn small color="primary" :to="{ name: 'pages-edit-schedule', params: { id: item.id } }"><v-icon center>{{
          icons.mdiPencil }}</v-icon></v-btn>
      </template>
      <template #item.delete="{ item }">
        <v-btn small color="error" @click="deleteSchedule(item.id)"><v-icon>{{ icons.mdiTrashCanOutline
        }}</v-icon></v-btn>
      </template>
    </v-data-table>
  </v-card>
</template>


<script>
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';
import { mdiPencil, mdiTrashCanOutline } from '@mdi/js';

export default {
  setup() {
    return {
      buss: [],
      icons: {
        mdiPencil,
        mdiTrashCanOutline
      }

    }
  },
  data() {
    return {
      search: '',
      headers: [
        {
          text: 'Nomor pintu',
          align: '',
          sortable: false,
          value: 'nomor_pintu',

        },
        { text: 'Nomor Polisi', value: 'police_number' },
        { text: 'Supir', value: 'name' },
        { text: 'Asal', value: 'arrival' },
        { text: 'Tujuan', value: 'derpature' },
        { text: 'Tanggal', value: 'tanggal' },
        { text: 'Harga', value: 'harga' },
        { text: 'Status', value: 'status' },
        { text: 'Edit', value: 'edit', align: 'center', sortable: false },
        { text: 'Delete', value: 'delete', align: 'center', sortable: false }
      ],
      schedule: [],
    }
  },
  methods: {
    formatDate(date) {
      // moment.locale('id');
      return moment(date).format('dddd, Do MMMM YYYY');
    }
  },
  getColor(status) {
    if (status == "Avaliable") return 'red'
    // else if (calories > 200) return 'orange'
    else return 'green'
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get('/api/schedule/show/all', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.schedule = response.data.data;
      console.log(this.schedule);


    }).catch(error => {
      console.log(error);
    });
  }
}
</script>
