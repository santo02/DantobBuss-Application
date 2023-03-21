<template>
  <v-card class="ml-3">
    <v-card-title>Schedule Baru</v-card-title>
    <v-card-text>
      <v-form class="bg-light">
        <v-row>
          <v-col cols="12" md="3">
            <label for="bus">Bus</label>
          </v-col>
          <v-col cols="12" md="9">
            <v-select v-model="schedule.bus_id" :items="bus" item-value="id" item-text="police_number" outlined dense
              placeholder="Pilih Bus" @change="saveSelectBus"></v-select>
          </v-col>

          <v-col cols="12" md="3">
            <label for="rute">Rute</label>
          </v-col>
          <v-col cols="12" md="9">
            <v-select v-model="schedule.route_id" :items="route" item-value="id" item-text="derpature" outlined dense
              placeholder="Pilih Rute" @change="saveSelectRoute"></v-select>
          </v-col>

          <v-col cols="12" md="3">
            <label for="rute">Tanggal</label>
          </v-col>
          <v-col cols="12" md="9">
            <v-text-field id="rute" v-model="schedule.tanggal" type="datetime-local" outlined dense placeholder="Kedatangan"
              hide-details></v-text-field>
          </v-col>

          <v-col cols="12" md="3">
            <label for="rute">Harga</label>
          </v-col>
          <v-col cols="12" md="9">
            <v-text-field id="rute" v-model="schedule.harga" type="number" outlined dense placeholder="Harga"
              hide-details></v-text-field>
          </v-col>


          <v-col offset-md="3" cols="12">
            <v-btn @click.prevent="AddSchedule" color="primary">
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
      schedule: [
        'bus_id',
        'route_id',
        'tanggal',
        'harga',
      ],
      bus: [],
      route: []
    }
  },
  data() {
    return {
      bus: [],
      route: []
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');
    // rute
    axios.get('api/routes/show/all', {

      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.route = response.data.data.map((item) => {
        return {
          id: item.id,
          derpature: item.derpature + " - "  + item.arrival,
          arrival: item.arrival,
        }
      });
      // console.log(this.route)
    }).catch(error => {
      console.log(error);
    });
    // bus
    axios.get('api/buss/show/all', {

      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.bus = response.data.data.map((item) => {
        return {
          id: item.id,
          police_number: item.police_number + "("+item.nomor_pintu + ")"
        }
      });
      console.log(this.bus)
    }).catch(error => {
      console.log(error);
    });

  },
  methods: {
    saveSelectBus() {

      console.log('Selected item id:', this.schedule.bus_id);
    },
    saveSelectRoute() {

      console.log('Selected item id:', this.schedule.route_id);
    },
    AddSchedule() {

      const access_token = localStorage.getItem('access_token');

      axios.post('api/schedule/add', {
        bus_id: this.schedule.bus_id,
        route_id: this.schedule.route_id,
        tanggal: this.schedule.tanggal,
        harga: this.schedule.harga,
      }, {
        headers: {
          'Authorization': `Bearer ${access_token}`
        }
      }).then(response => {
        console.log(this.schedule);
        this.$router.push({
          name: 'pages-schedule',

          query: { message: this.message },
        });
      }).catch((error) => {
        console.log(error.response.data.errors)
      })
    }
  }
}
</script>
