<template>
  <v-card>
    <v-card-title>
      <v-btn class="mb-3" :to="{ name: 'pages-add-admin-loket' }" color="primary">
        Tambah Admin Loket
      </v-btn>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="mdi-magnify" label="Cari" hide-details></v-text-field>
    </v-card-title>
    <v-data-table :headers="headers" :items="adminLoket" :search="search">
      <template #item.edit="{ item }">
        <v-btn small color="primary" :to="{ name: 'pages-edit-schedule', params: { id: item.id } }">
          <v-icon center>{{ icons.mdiPencil }}</v-icon>
        </v-btn>
      </template>
      <template #item.status="{ item }">
        <v-switch v-model="item.status" color="secondary" inset></v-switch>
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
      icons: {
        mdiPencil,
        mdiTrashCanOutline
      }
    }
  },

  data() {
    return {
      adminLoket: [],
      search: '',
      headers: [
        { text: 'Nama Lengkap', align: '', sortable: false, value: 'name' },
        { text: 'Email', value: 'email' },
        { text: 'No.Handphone', value: 'phone_number' },
        { text: 'Jenis Kelamin', value: 'gender' },
        { text: 'Alamat', value: 'address' },
        { text: 'Edit', value: 'edit', align: 'center', sortable: false },
        { text: 'Status', value: 'status', align: 'center', sortable: false }
      ],
    }
  },

  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get('/api/admin-loket/all', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    })
    .then(response => {
      this.adminLoket = response.data;
      console.log(this.adminLoket);
    })
    .catch(error => {
      console.log(error);
    });
  }
}
</script>
