<template>
  <div>
    <google-map :center="getCenter" :zoom="15"
      style="width: 100%; height: 80vh;">
      <map-marker :options="getMarkerOptions"></map-marker>
    </google-map>
    <button @click="getCurrentLocation">Click</button>
  </div>
</template>

<script>
import {Map, Marker } from 'vue2-google-maps';

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

    this.watcher = navigator.geolocation.watchPosition((position) => {
      console.log(`Watch position with coordinate late: ${position.coords.latitude} and long: ${position.coords.longitude}`)
      this.center = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
      };
      this.centerOptions = { position: this.center, label: "Current Location.", title: "ME" }
    }, (err) => {
      console.log(`Failed to watch location ${err}`)
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
