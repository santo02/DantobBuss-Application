<template>
  <v-card class="ml-3">
    <v-card-title>Tambah Supir</v-card-title>
    <v-card-text>
      <v-form class="bg-light">
        <v-row>
          <v-col cols="12" md="3">
            <label for="name">Nama Lengkap</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-text-field id="name" v-model="supir.name" outlined dense placeholder="Nama Lengkap"
              hide-details></v-text-field>
          </v-col>

          <v-col cols="12" md="3">
            <label for="email">Email</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-text-field id="email" v-model="supir.email" outlined dense placeholder="Email" hide-details></v-text-field>
          </v-col>

          <v-col cols="12" md="3">
            <label for="username">Username</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-text-field id="Username" v-model="supir.username" type="text" outlined dense placeholder="Username"
              hide-details></v-text-field>
          </v-col>

          <v-col cols="12" md="3">
            <label for="phone_number">No Handphone</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-text-field id="phone_number" v-model="supir.phone_number" type="number" outlined dense
              placeholder="No Handphone" hide-details></v-text-field>
          </v-col>

          <v-col cols="12" md="3">
            <label for="mobile">Jenis Kelamin</label>
          </v-col>
          <v-col cols="12" md="9">
            <v-select v-model="supir.gender" :items="['Laki-laki', 'Perempuan']" outlined dense
              placeholder="Jenis Kelamin"></v-select>
          </v-col>

          <v-col cols="12" md="3">
            <label for="address">Alamat</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-textarea id="address" v-model="supir.address" type="text" outlined dense placeholder="Alamat"
              hide-details></v-textarea>
          </v-col>
          <v-col offset-md="3" cols="12">
            <v-btn @click.prevent="AddDriver" color="primary">
              Submit
            </v-btn>
            <v-btn type="reset" class="mx-2" outlined>
              Reset
            </v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import { ref } from '@vue/composition-api'
import axios from 'axios'

export default {
  setup() {
    const firstname = ref('')
    const email = ref('')
    const mobile = ref()
    const password = ref()
    const role_user = ref()
    const checkbox = ref(false)
    return {
      firstname,
      email,
      mobile,
      password,
      checkbox,
      role_user,
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
      supir: [
        
      ],


    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get('api/user/profile', {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.role_user = response.data.role.role;
      console.log(this.role_user)
    }).catch(error => {
      console.log(error);
    })
  },
  methods: {
    AddDriver() {

      const access_token = localStorage.getItem('access_token');

      axios.post('/api/registrasi/supir', {
        name: this.supir.name,
        email: this.supir.email,
        username: this.supir.username,
        phone_number: this.supir.phone_number,
        address: this.supir.address,
        gender: this.supir.gender
      }, {
        headers: {
          'Authorization': `Bearer ${access_token}`
        }
      }).then(response => {
        this.$router.push({
          name: 'pages-supir',
          query: { message: this.message },
        });
      }).catch((error) => {
        console.log(error.response.data.errors)
      })
    }
  }
}
</script>
