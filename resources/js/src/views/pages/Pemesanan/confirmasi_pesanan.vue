<template>
  <div>
    <h3 pa-3 ma-3>Konfirmasi Pesanan</h3>
    <v-card v-for="item in schedule" :key="item.id">
      <div class="container mt-3">

        <div class="text-center">
          <h2>{{ item.derpature }} -> {{ item.arrival }}</h2>
          <h5>{{ formatHour(item.tanggal) }}</h5>
          <h5>{{ formatDate(item.tanggal) }}</h5>
        </div>
        <div class="d-flex justify-end">
          <div v-if="userRole == 'passenger'" class="d-flex justify-start align-center">
            <label for="pesan-orang-lain" class="mr-2">Pesan untuk orang lain</label>
            <v-switch v-model="autoFill" inset color="secondary" id="pesan-orang-lain"></v-switch>
          </div>
        </div>
        <div>
          <v-col cols="12" md="3">
            <label for="name">Nama Lengkap</label>
          </v-col>
          <v-col>
            <v-text-field id="name" v-model="passenger.name" outlined dense placeholder="Nama Lengkap" required
              hide-details :rules="[(v) => !!v || 'Nama harus diisi']"></v-text-field>
          </v-col>
        </div>
        <div>
          <v-col cols="12" md="3">
            <label for="Nomor Handphone">Nomor Handphone</label>
          </v-col>

          <v-col>
            <v-text-field id="Nomor Handphone" v-model="passenger.number_phone" type="number" outlined dense
              placeholder="Nomor Handphone" required hide-details
              :rules="[(v) => !!v || 'Nomor Handphone harus diisi']"></v-text-field>
          </v-col>
        </div>

        <div v-if="userRole == 'admin_loket'">
          <h4>Dijemput</h4>
          <p>
            Apabila penumpang tidak memilih request penjemputan, maka penumpang akan
            datang ke loket yang dipilih oleh penumpang. Namun, apabila penumpang memilih
            Request Penjemputan maka penumpang akan diarahkan kelokasi rekomendasi sistem
            dengan posisi terdekat dari sekitaran alamat yang dicantumkan sistem.
          </p>
          <v-col v-if="!jemput" cols="12">
            <v-text-field v-model="item.derpature" outlined dense readonly hide-details></v-text-field>
          </v-col>
        </div>
        <div v-if="userRole == 'passenger'">
          <h4>Dijemput</h4>
          <p>
            Request penjemputan akan diarahkan ke lokasi rekomendasi sistem dengan posisi
            terdekat dari sekitaran alamat yang dicantumkan penumpang.
          </p>
          <v-switch v-model="jemput" color="primary"></v-switch>
          <v-col v-if="jemput" cols="12">
            <v-autocomplete filled solo clearable v-model="passenger.alamatJemput" :items="items"
              label="Pilih Lokasi Penjemputan"></v-autocomplete>
          </v-col>
        </div>
      </div>
      <div class="check">
        <v-container class="grey text-center">
          <v-card class="mb-3">
            <v-row>
              <v-col cols="2" sm="4">
                <div class="pa-2" tile>
                  <h3>Seat</h3>
                  <h5>{{ selectedSeat }}</h5>
                </div>
              </v-col>
              <v-col cols="2" sm="4">
                <div class="pa-2">
                  <v-btn class="mx-2" fab dark color="secondary" @click="submitData">
                    <v-icon dark>
                      {{ icons.mdiChevronRight }}
                    </v-icon>
                  </v-btn>
                </div>
              </v-col>
              <v-col cols="2" sm="4">
                <div class="pa-2" tile>
                  <h3>Harga</h3>
                  <h5>{{ item.harga | toRupiah}}</h5>
                </div>
              </v-col>
              <v-col cols="2" sm="6">
                <div class="pa-2" tile>
                  <h3>Menaikkan</h3>
                  <h5>{{ item.derpature }}</h5>
                </div>
              </v-col>
              <v-col cols="2" sm="6">
                <div class="pa-2" tile>
                  <h3>Menurunkan</h3>
                  <h5>{{ item.arrival }}</h5>
                </div>
              </v-col>
            </v-row>
          </v-card>
        </v-container>
      </div>
    </v-card>
    <v-snackbar ref="snackbar" v-model="snackbar" color="error" relative outlined top>
      Nama lengkap dan umur harus di isi!
      <template v-slot:action="{ attrs }">
        <v-btn color="error" text v-bind="attrs" @click="snackbar = false"> Close </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import "moment/locale/id";
import { mapState, mapActions } from "vuex";
import {
  mdiCalendarClock,
  mdiAccountGroup,
  mdiAccount,
  mdiSofaSingleOutline,
  mdiSofaSingle,
  mdiChevronRight,
} from "@mdi/js";
export default {
  setup() {
    return {
      icons: {
        mdiCalendarClock,
        mdiAccountGroup,
        mdiAccount,
        mdiSofaSingleOutline,
        mdiSofaSingle,
        mdiChevronRight,
      },
    };
  },
  computed: {
    ...mapState({
      selectedSeat: (state) => state.selectedSeat,
    }),
    id_schedule() {
      return this.$store.state.busData.id_schedule;
    },
    harga() {
      return this.$store.state.busData.harga;
    },

    userRole() {
      return this.$store.state.userRole;
    },
  },
  filters: {
    toRupiah(value) {
      const formatter = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
      });
      return formatter.format(value);
    },
  },
  data() {
    return {
      schedule: {},
      jemput: false,
      passenger: {
        name: "",
        age: "",
        alamatJemput: "",
      },
      snackbar: false,
      items: ["Balige", "Tambunan", "Tampubolon", "Laguboti"],
      loket: [
        "Loket Balige",
        "Loket Tarutung",
        "Loket Terminal Tarutung ",
        "Loket Porsea",
        "Loket Medan",
      ],
      autoFill: false,
      user: {}
    };
  },

  mounted() {
    this.getSchedule();
    console.log(this.autoFill)
    // Mengisi data nama dan nomor hp jika autoFill bernilai true
    if (!this.autoFill) {
      console.log("hiiiii");
      const access_token = localStorage.getItem("access_token");

      axios
        .get("api/user/profile", {
          headers: {
            Authorization: `Bearer ${access_token}`,
          },
        })
        .then((response) => {
          this.user = response.data;
          this.passenger.name = this.user.name;
          this.passenger.number_phone = this.user.phone_number;
        })
        .catch((error) => {
          console.log(error);
        });
    }
    else {
      //user will filled manual the input text


    }
  },
  watch: {
    autoFill: function (val) {
      if (val) {
        this.passenger.name = "";
        this.passenger.number_phone = "";
      }
      else {
        this.passenger.name = this.user.name;
        this.passenger.number_phone = this.user.phone_number;
      }
    }

  },
  methods: {
    formatDate(date) {
      moment.locale("id");
      return moment(date).format("dddd, Do MMMM YYYY");
    },
    formatHour(date) {
      moment.locale("id");
      return moment(date).format("hh:mm");
    },
    getSchedule() {
      const access_token = localStorage.getItem("access_token");
      let uri = `/api/schedule/show/${this.id_schedule}`;
      axios
        .get(uri, {
          headers: {
            Authorization: `Bearer ${access_token}`,
          },
        })
        .then((response) => {
          this.schedule = response.data.data;
          console.log(this.schedule);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    ...mapActions(["setPassengerData"]),
    submitData() {
      if (this.jemput) {
        if (!this.passenger.name || !this.passenger.number_phone) {
          // Tampilkan pesan error menggunakan Vuetify Snackbar
          this.snackbar = true;
          return;
        }
        // set data penumpang ke state Vuex
        this.$store.dispatch("setPassengerData", {
          name: this.passenger.name,
          number_phone: this.passenger.number_phone,
          alamatJemput: this.passenger.alamatJemput,
        });
      } else {
        if (!this.passenger.name || !this.passenger.number_phone) {
          // Tampilkan pesan error menggunakan Vuetify Snackbar
          this.snackbar = true;
          return;
        }
        // set data penumpang ke state Vuex
        this.$store.dispatch("setPassengerData", {
          name: this.passenger.name,
          number_phone: this.passenger.number_phone,
          alamatJemput: this.schedule[0].derpature,
        });
      }
      // redirect ke halaman berhasil
      this.$router.push("/pembayaran");
    },
  },
};
</script>
