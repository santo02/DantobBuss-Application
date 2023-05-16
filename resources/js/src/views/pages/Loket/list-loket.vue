<template>
  <v-card>
    <v-card-title>
      <v-btn class="mb-3" :to="{ name: 'pages-add-loket' }" color="primary">
        Tambah Loket
      </v-btn>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="mdi-magnify" label="Cari" hide-details></v-text-field>
    </v-card-title>
    <v-data-table :headers="headers" :items="loket" :search="search">
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
      loket: [
        'nama_loket',
        'lokasi_loket',
        'admin loket',
        'email',
      ],
      icons: {
        mdiPencil,
        mdiTrashCanOutline
      }
    }
  },
  data() {
    return {
      loket: [],
      search: '',
      headers: [
        {
          text: 'Nama Loket',
          align: '',
          sortable: false,
          value: 'nama_loket',

        },
        { text: 'Lokasi Loket', value: 'lokasi_loket' },
        { text: 'Admin loket', value: 'name' },
        { text: 'email', value: 'email' },
      ],
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get('/api/loket/all', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.loket = response.data;
      console.log(this.loket)
    }).catch(error => {
      console.log(error);
    });
  }
}
</script>
