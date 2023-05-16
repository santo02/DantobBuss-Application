<template>
  <v-card>
    <v-card-title>
      <v-btn class="mb-3" :to="{ name: 'pages-add-route' }" color="primary">
        Tambah Rute
      </v-btn>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="mdi-magnify" label="Cari" hide-details></v-text-field>
    </v-card-title>
    <v-data-table :headers="headers" :items="route" :search="search">
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
import { mdiSwapHorizontalBold, mdiPencil, mdiTrashCanOutline } from '@mdi/js'
export default {
  setup() {
    return {
      route: [
        'derpature',
        'arrival',
        'harga',
        'type',
      ],
      icons: {
        mdiSwapHorizontalBold,
        mdiPencil,
        mdiTrashCanOutline
      }

    }
  },
  data() {
    return {
      route: [],
      supir: [],
      search: '',
      headers: [
        {
          text: 'Keberangkatan',
          align: '',
          sortable: false,
          value: 'derpature',

        },
        { text: 'Kedatangan', value: 'arrival' },
        { text: 'Type', value: 'type' },
        { text: 'Harga', value: 'harga' },
        { text: 'Action', value: 'action', align: 'center', sortable: false }
      ],
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get('/api/routes/show/all', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.route = response.data.data;
      console.log(this.route)
    }).catch(error => {
      console.log(error);
    });
  }
}
</script>
