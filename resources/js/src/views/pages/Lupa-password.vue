<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card class="auth-card">
        <!-- logo -->
        <v-form ref="form" @submit.prevent="submitEmail">
          <div class="body1">
            <h3 class="judul" color="primary">Lupa Password</h3>
            <p class="body">
              Masukkan alamat email yang terkait dengan akun Anda dan kami akan
              mengirimkan tautan untuk mengatur ulang kata sandi Anda
            </p>
            <v-text-field
              v-model="email"
              outlined
              label="Email"
              placeholder="john@example.com"
              hide-details
              :error-messages="errors.email"
              class="mb-1"
            ></v-text-field>
            <label class="text-danger" v-if="errors.email" type="error" dismissible>
              Email harus di isi!
            </label>
            <center>
              <v-btn
                type="submit"
                color="primary"
                class="mt-6 btn-kirim"
                :loading="isLoading"
              >
                <template v-if="!isLoading"> Kirim </template>
                <template v-if="isLoading">
                  <v-progress-circular
                    indeterminate
                    size="24"
                    color="white"
                  ></v-progress-circular>
                </template>
              </v-btn>
            </center>
          </div>
        </v-form>
      </v-card>
    </div>
  </div>
</template>

<script>
import { ref } from "@vue/composition-api";
import axios from "axios";
import Swal from "sweetalert2";

// import doku from "../../utils/doku";

export default {
  setup() {
    const email = ref("");
    return {
      email,
    };
  },
  data() {
    return {
      email: "",
      errors: {},
      isLoading: false,
    };
  },
  methods: {
    submitEmail() {
      this.isLoading = true;
      Swal.fire({
        icon: "error",
        title: "Login Gagal",
        text: "Email dan Password tidak boleh kosong!",
        confirmButtonText: "Ok",
        confirmButtonColor: "#d33",
      });
      this.isLoading = false;
    },
  },
};
</script>

<style lang="scss" scoped>
@import "~@resources/sass/preset/pages/auth.scss";

.body1 {
  padding: 40px;
}
.judul {
  margin-bottom: 40px;
  text-align: center;
}
.body {
  margin-bottom: 40px;
  text-align: center;
}
.btn-kirim {
  width: 50%;
  text-align: center;
  margin-top: 20px;
  margin-bottom: 30px;
}
</style>
