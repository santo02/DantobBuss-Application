<template>
  <v-card class="ml-3">
    <v-card-title>Tambah Rute</v-card-title>
    <v-card-text>
      <v-form class="bg-light">
        <v-row>
          <v-col cols="12" md="3">
            <label for="depature">Keberangkatan</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-text-field id="depature" v-model="routes.derpature" outlined dense placeholder="Keberangkatan"
              hide-details></v-text-field>
          </v-col>

          <v-col cols="12" md="3">
            <label for="username">Kedatangan</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-text-field id="Username" v-model="routes.arrival" type="text" outlined dense placeholder="Kedatangan"
              hide-details></v-text-field>
          </v-col>


          <v-col offset-md="3" cols="12">
            <v-btn @click.prevent="AddRoute" color="primary">
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
// import { ref } from '@vue/composition-api'
import axios from 'axios'

export default {
  setup() {
    return {
      routes: [
        'derpature',
        'arrival',
      ]
    }
  },
  data() {
    return {}
  },
  methods: {
    AddRoute() {

      const access_token = localStorage.getItem('access_token');

      axios.post('api/routes/add', {
        derpature: this.routes.derpature,
        arrival: this.routes.arrival,
      }, {
        headers: {
          'Authorization': `Bearer ${access_token}`
        }
      }).then(response => {
        console.log(this.routes);
        this.$router.push({
          name: 'pages-routes',

          query: { message: this.message },
        });
      }).catch((error) => {
        console.log(error.response.data.errors)
      })
    }
  }
}
</script>
