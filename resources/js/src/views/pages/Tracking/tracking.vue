<template>
  <div>
    <google-map :center="center" :zoom="15" style="width: 100%; height: 80vh">
      <map-marker :position="center" :options="centerMarkerOptions"></map-marker>
      <map-marker :position="carPosition" :options="carMarkerOptions"></map-marker>
      <map-polyline :path="polylinePath" :options="polylineOptions"></map-polyline>
    </google-map>
  </div>
</template>

<script>
import axios from "axios";
import { Map, Marker, Polyline } from "vue2-google-maps";
import { io } from "socket.io-client";

export default {
  name: "App",
  components: {
    "google-map": Map,
    "map-marker": Marker,
    "map-polyline": Polyline,
  },
  data() {
    return {
      schedule: null,
      center: { lat: -33.9, lng: 151.1 },
      carPosition: null,
      centerMarkerOptions: {
        label: "Posisi Anda",
        title: "Posisi Kamu",
        icon: {
          url: "https://eticketingkbt.online/images/pin-user.gif",
          scaledSize: { width: 60, height: 60 },
          labelOrigin: { x: 16, y: -10 },
        },
      },
      carMarkerOptions: {
        label: "Mobil",
        title: "Mobil",
        icon: {
          url: "https://eticketingkbt.online/images/icon_mobil.jpg",
          scaledSize: { width: 50, height: 50 },
          labelOrigin: { x: 16, y: -10 },
        },
      },
      polylinePath: [],
      polylineOptions: {
        strokeColor: "#FF0000",
        strokeOpacity: 1.0,
        strokeWeight: 2,
      },
    };
  },
  created() {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
      },
      (error) => {
        console.log(`Failed to get current position: ${error.message}`);
      }
    );

    this.watcher = navigator.geolocation.watchPosition(
      (position) => {
        console.log(`Watch position with coordinates lat: ${position.coords.latitude}, lng: ${position.coords.longitude}`);
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
      },
      (error) => {
        console.log(`Failed to watch position: ${error.message}`);
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
        this.socket = io("wss://socket.eticketingkbt.online", {
          query: `id=${crypto.randomUUID()}`,
        });

        this.socket.on("side-hello", (data) => {
          console.log(`Received data from socket: ${data.toString()}`);
          console.log(data);
          console.log(`${this.schedule.supir_id}#----#${this.schedule.schedule_id}`);
          this.socket.on(`${this.schedule.supir_id}#----#${this.schedule.schedule_id}`, (message) => {
            console.log(message);
            this.carPosition = message.data.location.center;

            // Update the polyline path when the car position changes
            this.updatePolylinePath();
          });
        });
      })
      .catch((error) => {
        console.log(error);
      });
  },
  beforeUnmount() {
    if (this.watcher !== null) {
      console.log(`Unmounting the watcher`);
      navigator.geolocation.clearWatch(this.watcher);
    }
  },
  methods: {
    updatePolylinePath() {
      if (this.center && this.carPosition) {
        this.polylinePath = [this.center, this.carPosition];
      } else {
        this.polylinePath = [];
      }
    },
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
