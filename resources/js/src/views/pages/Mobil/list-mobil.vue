<template>
  <v-card>
    <v-card-text>
      <v-btn class="mb-3" :to="{ name: 'pages-add-mobil' }" color="primary">
        Tambah Mobil
      </v-btn>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-uppercase">
                Nomor Polisi
              </th>
              <th class="text-center text-uppercase">
                Supir
              </th>
              <th class="text-center text-uppercase">
                Jumlah seats
              </th>
              <th class="text-center text-uppercase">
                Type
              </th>
              <th class="text-center text-uppercase">
                Status
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in buss" :key="item.id">
              <td>{{ item.police_number }}</td>
              <td class="text-center">
                {{ item.name }}
              </td>
              <td class="text-center">
                {{ item.number_of_seats }}
              </td>
              <td class="text-center">
                {{ item.type }}
              </td>
              <td class="text-center">
                {{ item.status }}
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

    }
  },
  data() {
    return {
      buss: [],
      supir: [],
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
