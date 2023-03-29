<template>
  <v-app>
    <v-row>
      <v-container>
        <v-img height="400px" src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg">
          <v-card-title>
            <v-btn small color="primary" class="btn-pesan">
              Pesan E-Ticket
            </v-btn>
          </v-card-title>
          <v-card-title class="text-title">
            <h5 class="white--text">Pelayanan terbaik untuk perjalanan kamu</h5>
          </v-card-title>
        </v-img>
      </v-container>
    </v-row>
    <v-slide-group class="pa-4" multiple show-arrows>
      <v-slide-item v-for="n in 10" :key="n" v-slot="{ active, toggle }">
        <v-card :color="active ? 'primary' : 'grey lighten-1'" class="ma-4" height="200" width="200" @click="toggle">
          <v-row class="fill-height" align="center" justify="center">
            <v-scale-transition>
              <v-icon v-if="active" color="white" size="48" v-text="'mdi-close-circle-outline'"></v-icon>
            </v-scale-transition>
          </v-row>
        </v-card>
      </v-slide-item>
    </v-slide-group>

  </v-app>
</template>
<script>

</script>
<style>
@media only screen and (max-width: 480px) {
  .btn-pesan {
    margin-top: 160px;
    height: 15px;
    padding-left: 30px;
    width: 120px;
    font-size: 10px;
    height: 50px;
  }

  .text-title {
    position: absolute;
    text-align: center;
  }
}

@media only screen and (min-width: 481px) {
  .btn-pesan {
    margin-top: 160px;
    height: 15px;
    padding-left: 30px;
    width: 240px;
    height: 50px;
  }

  .text-title {
    position: absolute;
    margin-left: 60%;
  }
}
</style>
