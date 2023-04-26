<template>
  <div>
    <h3>Detail Penumpang</h3>
    <div class="d-flex justify-content-between">
      <div>
        <h5>Status bus: </h5>
        <v-btn v-if="bus.status == 'in_progress'" rounded small color="warning" class="ml-3 status text-capitalize"
          style="color: white; font-weight:bold;" @click="updateBusStatus(bus.schedules_id)">
          Sdang berjalan
        </v-btn>
        <v-btn v-if="bus.status == 'complete'" rounded small color="primary" class="ml-3 status text-capitalize"
          style="color: white; font-weight:bold;" @click="updateBusStatus(bus.schedules_id)">
          Selesai
        </v-btn>
        <v-btn v-if="bus.status == 'not_started'" rounded small color="info" class="my-2  status text-capitalize"
          style="color: white; font-weight:bold;" @click="updateBusStatus(bus.schedules_id)">
          Belum Berangkat
        </v-btn>
      </div>
      <div class="ml-auto p-2" align="right">
        <p>{{ bus.derpature }} - {{ bus.arrival }}</p>
        <p>{{ formatDate(bus.tanggal) }}</p>
      </div>
    </div>
    <h5>Total Penumpang : {{ total_penumpang }}</h5>
    <v-data-table :headers="headers" :items="penumpang" class="elevation-1">
    </v-data-table>
  </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';

export default {
  setup() {
    return {
      headers: [
        { text: 'Nama', value: 'name' },
        { text: 'Bangku', value: 'num_seats' },
        { text: 'Umur', value: 'age' },
        { text: 'Penjemputan', value: 'alamatJemput' },
        { text: 'Metode', value: 'method' },
        { text: 'Harga', value: 'harga' },
      ]
    }
  },

  data() {
    return {
      id_bus: this.$route.params.id,
      penumpang: [],
      bus: {},
      total_penumpang: 0
    }
  },

  methods: {
    formatDate(date) {
      moment.locale('id');
      return moment(date).format('dddd, Do MMMM YYYY, hh:mm:ss');
    },

    async updateBusStatus(schedule_id) {
      const access_token = localStorage.getItem('access_token');
      try {
        const response = await axios.put(`/update-status/${schedule_id}`, {}, {
          headers: {
            'Authorization': `Bearer ${access_token}`
          }
        });
        console.log(response.data);
        // update status bus pada halaman
        this.bus.status = response.data.status;
      } catch (error) {
        console.log(error);
      }
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');
    axios.get(`/api/bookings/show/schedules/${this.id_bus}`, {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.penumpang = response.data.data;
      this.bus = response.data.data[0];
      console.log(this.penumpang)
      this.total_penumpang = response.data.total;
    }).catch(error => {
      console.log(error);
    });
  },
}
</script>
