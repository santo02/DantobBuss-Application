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
    <v-data-table :headers="headers" :items="penumpang"  class="elevation-1">
    </v-data-table>
  </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';
import  {io} from "socket.io-client";

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
      total_penumpang: 0,
      StatusBus: "",
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
    },
  },

  mounted() {
    const access_token = localStorage.getItem('access_token');
    axios.get(`/api/bookings/show/schedules/${this.id_bus}`, {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.penumpang = response.data.data;
      console.log(this.penumpang)
      this.bus = response.data.data[0];
      this.StatusBus = response.data.data[0].status;
      this.total_penumpang = response.data.total;
    }).catch(error => {
      console.log(error);
    });
  },
  created() {
    navigator.geolocation.getCurrentPosition((position) => {
      this.center = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
      };
      this.centerOptions = { position: this.center, label: "Current Location.", title: "ME" }
    }, (err) => {
      console.log(`error : ${err.message.toString()}`)
    });

    this.socket = io("ws://localhost:8081", {
      query: `id=${this.id_bus}`
    });


    // if (this.StatusBus === 'in_progress') {
    this.watcher = navigator.geolocation.watchPosition((position) => {
      console.log(`Watch position with coordinate late: ${position.coords.latitude} and long: ${position.coords.longitude}`)
      this.center = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
      };
      this.centerOptions = { position: this.center, label: "Current Location.", title: "ME" };
      this.socket.emit("server-sent-location", this.center);
    }, (err) => {
      console.log(`Failed to watch location ${err}`)

    });

    this.socket.on("side-get-location", (message) => {
      console.log(message);
      this.carLocations = {
        ...this.carLocations,
        [message.data.driver_id]: { position: message.data.location, label: "Current Location Driver : ", title: message.data.driver_id },
      };
    });
    // }
  },
}
</script>
