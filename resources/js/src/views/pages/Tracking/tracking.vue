<template>
  <div id="map"></div>
</template>

<script>
export default {
  data() {
    return {
      longitude: 34545,
      latitude: 122
    };
  },
  mounted() {
    // buat map
    const map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: this.latitude, lng: this.longitude },
      zoom: 20,
    });

    // buat marker
    const marker = new google.maps.Marker({
      position: { lat: this.latitude, lng: this.longitude },
      map: map,
    });

    // buat geolocation object
    const geolocation = navigator.geolocation;

    // update lokasi marker berdasarkan geolocation object setiap 2 detik
    const updateLocation = () => {
      this.latitude += 10; // tambahkan 10 pada latitude
      marker.setPosition({ lat: this.latitude, lng: this.longitude });
      map.setCenter({ lat: this.latitude, lng: this.longitude });
      console.log(this.latitude);
      console.log(this.longitude);
    };
    setInterval(updateLocation, 2000); // update setiap 2 detik
  },
};
</script>

<style>
#map {
  height: 400px;
}
</style>
