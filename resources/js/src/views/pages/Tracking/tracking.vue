<template>
  <div>
    <google-map :center="getCenter" :zoom="15" style="width: 100%; height: 80vh;">
      <div v-for="(car, i) in getCars" v-bind:key="i">
        <map-marker :options="car"></map-marker>
      </div>
    </google-map>
  </div>
</template>

<script>
import { Map, Marker } from 'vue2-google-maps';
import  {io} from "socket.io-client";

export default {
  name: 'App',
  components: {
    'google-map': Map,
    'map-marker': Marker
  },
  computed: {
    getCenter: function () {
      return this.center;
    },
    getMarkerOptions: function () {
      return this.centerOptions;
    },
    getCars: function () {
      let cars = [];
      console.log(`Console here`);
      console.log(this.carLocations);
      const temp = { ...this.carLocations };
      Object.keys(temp).forEach((item) => {
        cars.push(temp[item]);
      })
      return cars;
    }
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
      query: `id=${crypto.randomUUID()}`
    });

    this.socket.on("side-hello", (data) => {
      console.log(`receive data from socket : ${data.toString()}`)
      console.log(data);

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
          [message.data.driver_id]: { position: message.data.location, label: "Current Location.", title: message.data.driver_id },
        };
      });
    });

  },
  unmounted() {
    if (this.watcher !== null) {
      console.log(`unmounted the watcher`);
      navigator.geolocation.clearWatch(this.watcher);
    }
  },
  methods: {
    getCurrentLocation() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        this.centerOptions = { position: this.center, label: "Current Location.", title: "ME" }
      }, (err) => {
        console.log(`error : ${err.message.toString()}`)
      });
    },
  },

  data() {
    return {
      mapItems: null,
      center: { lat: -33.9, lng: 151.1 },
      centerOptions: {},
      watcher: null,
      socket: null,
      carLocations: {},
    };
  },
}
</script>

<style scoped>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
