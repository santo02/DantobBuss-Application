<template>
  <div>
    <google-map :center="getCenter" :zoom="15" style="width: 100%; height: 80vh">
      <map-marker :options="getMarkerOptions"></map-marker>
      <map-marker :options="getCarOptions"></map-marker>
    </google-map>
  </div>
</template>

<script>
import axios from "axios";
import { Map, Marker } from "vue2-google-maps";
import { io } from "socket.io-client";

export default {
  name: "App",
  components: {
    "google-map": Map,
    "map-marker": Marker,
  },
  computed: {
    getCenter: function () {
      return this.center;
    },
    getMarkerOptions: function () {
      return this.centerOptions;
    },
    getCarOptions: function () {
      return this.carOptions;
    },
  },
  created() {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        this.centerOptions = {
          position: this.center,
          label: "Current Location.",
          title: "ME",
        };
      },
      (err) => {
        console.log(`error : ${err.message.toString()}`);
      }
    );

    this.watcher = navigator.geolocation.watchPosition(
      (position) => {
        console.log(
          `Watch position with coordinate late: ${position.coords.latitude} and long: ${position.coords.longitude}`
        );
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        this.centerOptions = {
          position: this.center,
          label: "Posisi Anda",
          title: "ME",
        };
      },
      (err) => {
        console.log(`Failed to watch location ${err}`);
      }
    );
  },
  mounted() {
    const access_token = localStorage.getItem("access_token");

    axios
      .get(`/api/schedule/show/${this.$route.params.schedule_id}`, {
        headers: {
          Authorization: `Bearer ${access_token}`,
        },
      })
      .then((response) => {
        this.schedule = response.data.data[0];
        this.socket = io("ws://localhost:8081", {
          query: `id=${crypto.randomUUID()}`,
        });

        this.socket.on("side-hello", (data) => {
          console.log(`receive data from socket : ${data.toString()}`);
          console.log(data);
          console.log(`${this.schedule.supir_id}#----#${this.schedule.schedule_id}`);
          this.socket.on(
            `${this.schedule.supir_id}#----#${this.schedule.schedule_id}`,
            (message) => {
              console.log(message);
              this.carOptions = {
                position: message.data.location.center,
                label: `${this.schedule.nomor_pintu}`,
                title: "DRIVER",
                icon: {
                  url:
                    "https://www.clipartmax.com/png/middle/198-1986353_google-map-car-icon.png",
                  scaledSize: { width: 40, height: 40 },
                  labelOrigin: { x: 16, y: -10 },
                },
              };
            }
          );
        });
        console.log(this.schedule);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  unmounted() {
    if (this.watcher !== null) {
      console.log(`unmounted the watcher`);
      navigator.geolocation.clearWatch(this.watcher);
    }
  },
  methods: {},

  data() {
    return {
      schedule: null,
      mapItems: null,
      center: { lat: -33.9, lng: 151.1 },
      centerOptions: {},
      watcher: null,
      socket: null,
      carOptions: {},
    };
  },
};
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
