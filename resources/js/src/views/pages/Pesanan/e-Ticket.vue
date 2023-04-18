<template>
  <div>
    <h3 pa-3 ma-3>E-ticket</h3>
    <v-card width="500px" class="mx-auto p-3" ref="card">
      <div class="container m-3">
        <div class=" text-center">
          <v-avatar size="40" class="mt-2 ml-2">
            <img :src="require('@/assets/images/logos/logo-KBT.png').default" max-height="50px" max-width="100px"
              alt="avatar">
          </v-avatar>
          <h5>KBT</h5>
          <h5>E-Ticket</h5>
          <!-- <h6>INV-EKBT-1206202309590</h6> -->
        </div>
        <v-simple-table class="p-3">
          <template>
            <thead>
              <tr>
                <th colspan="2" class="text-left">
                  <h2>Rincian Bus</h2>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Tipe</td>
                <td>: {{ this.ticket.type }}</td>
              </tr>
              <tr>
                <td>Asal</td>
                <td>: {{ this.ticket.derpature }}</td>
              </tr>
              <tr>
                <td>Tujuan </td>
                <td>: {{ this.ticket.arrival }}</td>
              </tr>
              <tr>
                <th colspan="2">
                  <h2>Rincian Penumpang</h2>
                </th>
              </tr>
              <tr>
                <td>Nama</td>
                <td>: {{ this.ticket.name }}</td>
              </tr>
              <tr>
                <td>Umur</td>
                <td>: {{ this.ticket.age }}</td>
              </tr>
              <tr>
                <td>Bangku </td>
                <td>: {{ this.ticket.num_seats }}</td>
              </tr>
              <tr class="p-3">
                <td>Tarif </td>
                <td class="text-right"> <b> Rp.{{ this.ticket.harga }}</b></td>
              </tr>
              <tr class="mt-3">
                <td>
                  <h3>Status Pembayaran</h3>
                </td>
                <td class="text-right">
                  <h3 class="text--primary">{{ this.ticket.status }}</h3>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </div>
    </v-card>
    <div class="mx-auto text-center mt-4" width="500px">
      <v-btn color="primary" width="500px" height="40px" @click="downloadCard">Download</v-btn>

    </div>
  </div>
</template>



<script>
import jsPDF from 'jspdf';
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id';
import { mapState, mapActions } from 'vuex'
import { mdiCalendarClock, mdiAccountGroup, mdiAccount, mdiSofaSingleOutline, mdiSofaSingle, mdiChevronRight } from '@mdi/js';
export default {
  setup() {
    return {

    }
  },
  computed: {
  },
  data() {
    return {
      ticket: ''
    }
  },

  mounted() {
    this.getTIckets();

  },

  methods: {
    getTIckets() {
      const access_token = localStorage.getItem('access_token');

      axios.get(`/api/pesanan/ticket/${this.$route.params.id}`, {
        headers: {
          'Authorization': `Bearer ${access_token}`
        }
      }).then(response => {
        this.ticket = response.data.data[0]
        console.log(this.ticket)
      }).catch(error => {
        console.log(error);
      });
    },
    downloadCard() {
      // Ambil elemen HTML dari class 'v-card' menggunakan $refs
      const cardElement = this.$refs.card.$el;

      // Buat file PDF dari konten 'v-card' menggunakan JavaScript
      const pdf = new jsPDF();
      pdf.addHTML(cardElement, () => {
        // Buat URL objek dari file PDF yang telah dibuat
        const pdfURL = pdf.output('dataurlstring');

        // Buka URL objek dalam tab baru untuk melakukan download
        window.open(pdfURL, '_blank');
      });
    }
  },
}
</script>


