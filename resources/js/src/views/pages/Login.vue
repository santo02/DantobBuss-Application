<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card class="auth-card">
        <!-- logo -->
        <v-card-title class="d-flex align-center justify-center py-7">
          <router-link :to="{ name: 'pages-login' }" class="d-flex align-center">
            <v-img :src="require('@/assets/images/logos/logo.svg').default" max-height="30px" max-width="30px" alt="logo"
              contain class="me-3"></v-img>

            <h2 class="text-2xl font-weight-semibold">Dantob Buss</h2>
          </router-link>
        </v-card-title>

        <!-- title -->
        <v-card-text>
          <p class="text-1xl font-weight-semibold text--primary mb-2">Welcome to Dantob Buss App! 👋🏻</p>
          <p class="mb-2">Please sign-in to your account and start the adventure</p>
        </v-card-text>
        <v-card-text>
          <v-form>
            <v-text-field v-model="email" outlined label="Email" placeholder="john@example.com" hide-details
              :error-messages="errors.email" class="mb-1"></v-text-field>
            <label class="text-danger" v-if="errors.email" type="error" dismissible>
              Email tidak boleh kosong!
            </label>

            <v-text-field v-model="password" outlined :type="isPasswordVisible ? 'text' : 'password'" label="Password"
              class="mb-1 mt-3" :error-messages="errors.password" placeholder="********"
              :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline" hide-details
              @click:append="isPasswordVisible = !isPasswordVisible"></v-text-field>
            <label class="text-danger" v-if="errors.password" type="error" dismissible>
              Password tidak boleh kosong!
            </label>

            <div class="d-flex align-center justify-space-between flex-wrap">
              <v-checkbox label="Remember Me" hide-details class="me-3 mt-1"> </v-checkbox>

              <!-- forgot link -->
              <a href="javascript:void(0)" class="mt-1"> Forgot Password? </a>
            </div>

            <v-btn block color="primary" class="mt-6" @click.prevent="login"> Login </v-btn>
          </v-form>
        </v-card-text>

        <!-- create new account  -->
        <v-card-text class="d-flex align-center justify-center flex-wrap mt-2">
          <span class="me-2"> New on our platform? </span>
          <router-link :to="{ name: 'pages-register' }"> Create an account </router-link>
        </v-card-text>

        <!-- divider -->
        <v-card-text class="d-flex align-center mt-2">
          <v-divider></v-divider>
          <span class="mx-5">or</span>
          <v-divider></v-divider>
        </v-card-text>

        <!-- social links -->
        <v-card-actions class="d-flex justify-center">
          <v-btn v-for="link in socialLink" :key="link.icon" icon class="ms-1">
            <v-icon :color="$vuetify.theme.dark ? link.colorInDark : link.color">
              {{ link.icon }}
            </v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </div>
  </div>
</template>

<script>
import { mdiFacebook, mdiTwitter, mdiGithub, mdiGoogle, mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'
import axios from 'axios';

export default {
  setup() {
    const isPasswordVisible = ref(false)
    const email = ref('')
    const password = ref('')
    const socialLink = [
      {
        icon: mdiFacebook,
        color: '#4267b2',
        colorInDark: '#4267b2',
      },
      {
        icon: mdiTwitter,
        color: '#1da1f2',
        colorInDark: '#1da1f2',
      },
      {
        icon: mdiGithub,
        color: '#272727',
        colorInDark: '#fff',
      },
      {
        icon: mdiGoogle,
        color: '#db4437',
        colorInDark: '#db4437',
      },
    ]
    return {
      isPasswordVisible,
      email,
      password,
      socialLink,
      icons: {
        mdiEyeOutline,
        mdiEyeOffOutline,
      },
    }
  },
  data() {
    return {
      email: "",
      password: "",
      registrationSuccess: false,
      errors: {},
    };
  },
  methods: {
    login() {
      axios.post('/api/login', {
        email: this.email,
        password: this.password,
      })
        .then(response => {
          localStorage.setItem('access_token', response.data.access_token);
          localStorage.setItem('expires_at', response.data.expires_at);
          this.$router.push('/dashboard');
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            console.log(this.errors);
          } else if (error.response.status === 404) {
            this.errors = error.response.data.errors;
            console.log(this.errors);
          } else {
            this.errors = { general: ["Something went wrong. Please try again later."] };
          }
        });
    },
  }
}
</script>


<style lang="scss">
@import '~@resources/sass/preset/pages/auth.scss';
</style>
