<template>
  <v-card>
    <v-card-title>
      <v-btn class="mb-3" :to="{ name: 'pages-add-supir' }" color="primary">
        Tambah supir
      </v-btn>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="mdi-magnify" label="Cari" hide-details></v-text-field>
    </v-card-title>
    <v-data-table :headers="headers" :items="supir" :search="search">
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
      supir: [
        'name',
        'email',
        'username',
        'phone_number',
        'address',
        'gender'
      ],
      icons: {
        mdiPencil,
        mdiTrashCanOutline
      }
    }
  },
  data() {
    return {
      supir: [],
      search: '',
      headers: [
        {
          text: 'Nama Lengkap',
          align: '',
          sortable: false,
          value: 'name',

        },
        { text: 'Email', value: 'email' },
        { text: 'No.Handphone', value: 'phone_number' },
        { text: 'Jenis Kelamin', value: 'gender' },
        { text: 'Alamat', value: 'address' },
        { text: 'Action', value: 'action', align: 'center', sortable: false }
      ],
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get('/api/supir/all', {

      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.supir = response.data;
      // console.log(this.supir)
    }).catch(error => {
      console.log(error);
    })
  }
}
</script>
