<template>
  <v-card class="ml-3">
    <v-card-title>Tambah Loket</v-card-title>
    <v-card-text>
      <v-form class="bg-light">
        <v-row>
          <v-col cols="12" md="3">
            <label for="firstname">Nama Loket</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-text-field id="nama_loket" v-model="loket.nama_loket" outlined dense placeholder="Nama Loket"
              hide-details></v-text-field>
          </v-col>
          <v-col cols="12" md="3">
            <label for="firstname">Lokasi Loket</label>
          </v-col>
          <v-col cols="12" md="9">
            <v-text-field id="loak" v-model="loket.lokasi_loket" outlined dense placeholder="Lokasi Loket"
              hide-details></v-text-field>
          </v-col>

          <v-col cols="12" md="3">
            <label for="mobile">Admin Loket</label>
          </v-col>

          <v-col cols="12" md="9">
            <v-select v-model="loket.admin" :items="adminloket" item-value="id" item-text="name" outlined dense
              placeholder="Pilih Admin Loket" @change="saveSelectedItemId"></v-select>
          </v-col>

          <v-col offset-md="3" cols="12">
            <v-btn color="primary" @click.prevent="AddLoket"> Submit </v-btn>
            <v-btn type="reset" class="mx-2" outlined> Reset </v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      adminloket: [],
      admin: null,
      loket: [
        "nama_loket",
        "lokasi_loket",
        "admin",
      ],
    };
  },
  mounted() {
    const access_token = localStorage.getItem("access_token");
    axios
      .get("api/admin-loket/all/notAssociated", {
        headers: {
          Authorization: `Bearer ${access_token}`,
        },
      })
      .then((response) => {
        this.adminloket = response.data
        .filter((item) => item.status == 1) // Filter dengan supir.status = 1
        .map((item) => {
          return {
            name: item.name,
            id: item.id,
          };
        });
        console.log("ini", this.adminloket);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  methods: {
    AddLoket() {
      const access_token = localStorage.getItem("access_token");

      axios
        .post(
          "/api/loket/add",
          {
            nama_loket: this.loket.nama_loket,
            lokasi_loket: this.loket.lokasi_loket,
            admin_id: this.loket.admin,
          },
          {
            headers: {
              Authorization: `Bearer ${access_token}`,
            },
          }
        )
        .then((response) => {
          this.$router.push({
            name: "pages-loket",
            query: { message: this.message },
          });
        })
        .catch((error) => {
          console.log(error.response.data.errors);
        });
    },
    saveSelectedItemId() {
      // Simpan selectedItem.id ke database di sini
      console.log('Selected item id:', this.loket.admin);
    },
  },
};
</script>
