<template>
  <div>
    <div id="map"></div>
    <div>
      <h2>Lokasi saat ini:</h2>
      <p>Tempat: {{ currentPlace }}</p>
    </div>
  </div>
</template>

<script>
import geolib from "geolib";

export default {
  data() {
    return {
      currentPlace: "",
      listener: null,
    };
  },
  methods: {
    tracking() {
      // koordinat longitude dan latitude
      const longitude = 34545;
      const latitude = 122;
      // buat map
      const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: latitude, lng: longitude },
        zoom: 18,
      });
      // buat marker
      const marker = new google.maps.Marker({
        position: { lat: latitude, lng: longitude },
        map: map,
      });
      // this.listener = setInterval(() => {

      //   // buat geolocation object
      //   const geolocation = navigator.geolocation;

      //   // update lokasi marker berdasarkan geolocation object
      //   // if (geolocation) {
      //   geolocation.getCurrentPosition((position) => {
      //     const currentLatitude = position.coords.latitude;
      //     const currentLongitude = position.coords.longitude;

      //     marker.setPosition({ lat: currentLatitude, lng: currentLongitude });
      //     map.setCenter({ lat: currentLatitude, lng: currentLongitude });

      //     // // Menggunakan geolib untuk mendapatkan nama tempat
      //     // const currentPlace = geolib.reverseGeocode(
      //     //   currentLatitude,F
      //     //   currentLongitude
      //     // );
      //     // if (currentPlace && currentPlace[0]) {
      //     //   this.currentPlace = currentPlace[0].city || currentPlace[0].country;
      //     // } else {
      //     //   this.currentPlace = "Tidak ada nama tempat ditemukan";
      //     // }
      //     // console.log(this.currentPlace);
      //   });
      // }, 1000);

      const geolocation = navigator.geolocation;
      this.listener = geolocation.watchPosition((position)=>{
        console.log(position);
        marker.setPosition({lat: position.coords.latitude, lng: position.coords.longitude});
        map.setCenter({lat: position.coords.latitude, lng: position.coords.longitude});
      });
    },
  },
  beforeDestroy() {
    const geolocation = navigator.geolocation;
    if(this.listener !== null){
      geolocation.clearWatch(this.listener);
    }
  },
  mounted() {



    console.log("Test");
    this.tracking();
    // }
  },
};
</script>

<style>
#map {
  height: 400px;
}
</style>
