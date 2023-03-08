<template>
  <v-card>
    <v-card-text>
      <!-- <v-alert v-if="message " closable title="Alert title" type="success">Hello</v-alert> -->
      <v-btn class="mb-3" :to="{ name: 'pages-add-supir' }" color="primary">
        Tambah supir
      </v-btn>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-uppercase">
                Nama Lengkap
              </th>
              <th class="text-center text-uppercase">
                Email
              </th>
              <th class="text-center text-uppercase">
                Nomor Handphone
              </th>
              <th class="text-center text-uppercase">
                Jenis Kelamin
              </th>
              <th class="text-center text-uppercase">
                Alamat
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in supir" :key="item.id">
              <td>{{ item.name }}</td>
              <td class="text-center">
                {{ item.email }}
              </td>
              <td class="text-center">
                {{ item.phone_number }}
              </td>
              <td class="text-center">
                {{ item.gender }}
              </td>
              <td class="text-center">
                {{ item.address }}
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
      supir: [
        'name',
        'email',
        'username',
        'phone_number',
        'address',
        'gender'
      ]
    }
  },
  data() {
    return {
      supir: [],
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
