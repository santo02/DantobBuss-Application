<template>
  <v-card>
    <v-card-text>
      <v-btn class="mb-3" :to="{ name: 'pages-add-route' }" color="primary">
        Tambah Rute
      </v-btn>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-uppercase">
                Keberangkatan
              </th>

              <th class="text-center text-uppercase">
                Kedatangan
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in route" :key="item.id">
              <td>{{ item.derpature }}</td>
              <!-- <td>ke</td> -->
              <td class="text-center">
                {{ item.arrival }}
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from 'axios';
import {mdiSwapHorizontalBold } from '@mdi/js'
export default {
  setup() {
    return {
      route: [
        'derpature',
        'arrival',
      ],
      icons:{
        mdiSwapHorizontalBold
      }

    }
  },
  data() {
    return {
      route: [],
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
