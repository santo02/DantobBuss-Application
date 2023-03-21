<template>
  <v-card class="ml-3">
    <v-card-title>Tambah Mobil</v-card-title>
    <v-card-text>
      <v-form class="bg-light">
        <v-row>
          <v-col cols="12" md="3">
            <label for="firstname">Nomor Polisi</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-text-field id="police_number" v-model="mobil.police_number" outlined dense placeholder="Nomor Polisi"
              hide-details></v-text-field>
          </v-col>
          <v-col cols="12" md="3">
            <label for="firstname">Nomor Pintu</label>
          </v-col>
          <v-col cols="12" md="9">
            <v-text-field id="nomor_pintu" v-model="mobil.nomor_pintu" outlined dense placeholder="Nomor Pintu"
              hide-details></v-text-field>
          </v-col>

          <v-col cols="12" md="3">
            <label for="email">Type</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-select v-model="mobil.type" :items="['Economi', 'Executive',]" outlined dense placeholder="Type" hide
              details></v-select>
            <!-- <v-text-field id="type" v-model="mobil.type" outlined dense placeholder="type" hide-details></v-text-field> -->
          </v-col>

          <v-col cols="12" md="3">
            <label for="mobile">Supir</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-select v-model="mobil.driver" :items="supir" item-value="id" item-text="name" outlined dense
              placeholder="Pilih supir" @change="saveSelectedItemId"></v-select>
          </v-col>

          <v-col cols="12" md="3">
            <label for="mobile">Jumlah Seats</label>
          </v-col>
          <v-col cols="12" md="9">
            <v-text-field id="num_seats" v-model="mobil.number_of_seats" type="number" outlined dense
              placeholder="Jumlah Seats" hide-details></v-text-field>
          </v-col>

          <v-col cols="12" md="3">
            <label for="mobile">Status</label>
          </v-col>
          <v-col cols="12" md="9">
            <v-select v-model="mobil.status" :items="['Avaliable', 'Unavaliable',]" outlined dense
              placeholder="Status"></v-select>
          </v-col>

          <v-col offset-md="3" cols="12">
            <v-btn color="primary" @click.prevent="AddMobil">
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
    const police_number = ref('')
    const num_seats = ref('')
    const type = ref()
    const status = ref()
    const driver = ref()

    return {
      police_number,
      num_seats,
      type,
      status,
      driver,
      mobil: [
        'police_number',
        'type',
        'driver',
        'number_of_seats',
        'nomor_pintu',
        'merk',
        'status'
      ]
    }
  },
  data() {
    return {
      supir: [],
      driver: null,
      mobil: [],
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');
    axios.get('/api/supir/name/all', {

      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.supir = response.data.map((item) => {
        return {
          name: item.name,
          id: item.id,
        }

      });
      console.log(this.supir)
    }).catch(error => {
      console.log(error);
    });

  },
  methods: {
    AddMobil() {
      const access_token = localStorage.getItem('access_token');

      axios.post('/api/buss/add', {
        police_number: this.mobil.police_number,
        type: this.mobil.type,
        supir_id: this.mobil.driver,
        number_of_seats: this.mobil.number_of_seats,
        nomor_pintu: this.mobil.nomor_pintu,
        merk: 'KBT',
        status: this.mobil.status
      }, {
        headers: {
          'Authorization': `Bearer ${access_token}`
        }
      }).then(response => {
        this.$router.push({
          name: 'pages-mobil',
          query: { message: this.message },
        });
      }).catch((error) => {
        console.log(error.response.data.errors)
      })
    },
    saveSelectedItemId() {
      // Simpan selectedItem.id ke database di sini
      // console.log('Selected item id:', this.mobil.driver);
    }
  }
}
</script>
