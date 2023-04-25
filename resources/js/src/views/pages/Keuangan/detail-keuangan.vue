<template>
  <div>
    <h2>Catatan Keuangan</h2>
    <!-- <v-text-field label="Pilih tanggal" placeholder="Pilih Tanggal" v-model="selectedDate" solo /> -->
    <v-data-table  :headers="headers" :items="ListPenumpang">
      <template v-slot:body.append>
        <tr>
          <td>
            <h2>Total</h2>
          </td>
          <td colspan="8" style="text-align: right;">
            <h3 style="color: red;">Rp.{{ totalSemua }}</h3>
          </td>
        </tr>
      </template>
    </v-data-table>
    <template>
      <v-simple-table class="mt-4 table-primary">
        <template v-slot:default>
          <thead>
            <tr>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="judul">Komisi</td>
              <td>10% * Rp.{{ totalSemua }}</td>
              <td>Rp.{{ komisi }}</td>
            </tr>
            <tr>
              <td class="judul">Kantor</td>
              <td>1 * Rp.53.0000</td>
              <td>Rp.{{ kantor }}</td>

            </tr>
            <tr>
              <td class="judul">Administrasi</td>
              <td> 1 * Rp.5.0000 </td>
              <td> Rp.{{ admin }} </td>
            </tr>
            <tr>
              <td>Total Setoran admin loket</td>
              <td></td>
              <td><h4>Rp.{{ totalSemua - (komisi + kantor + admin) }}</h4></td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </template>
  </div>
</template>

<script>
import moment from 'moment'
import axios from 'axios';
import 'moment/locale/id';

export default {

  data() {
    return {
      schedule_id: this.$route.params.id,
      ListPenumpang: [],
      harga: 0,
      headers: [
        {
          text: 'Nama',
          align: 'start',
          value: 'name',
        },
        { text: 'Bangku', value: 'num_seats' },
        { text: 'Umur', value: 'age' },
        { text: 'No Telepon', value: 'phone_number' },
        { text: 'Penjumputan', value: 'alamatJemput' },
        { text: 'Metode', value: 'method' },
        { text: 'Harga', value: 'harga' },
      ],
      selectedDate: ''
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get(`/api/Detail-keuangan-ByPassenger/${this.schedule_id}`, {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.ListPenumpang = response.data.data;

      this.harga = +this.ListPenumpang[0].harga;
    }).catch(error => {
      console.log(error);
    });
  },
  methods: {
    formatDate(date, format = 'dddd, Do MMMM YYYY') {
      return moment(date).format(format);
    }
  },
  computed: {
    totalSemua() {
      let total = 0;
      total = this.ListPenumpang.length * this.harga;
      return total;
    },
    komisi() {
      let komisi = 0;
      komisi = (10 / 100) * +this.totalSemua;
      return komisi;
    },
    kantor() {
      let kantor = 0;
      kantor = 1 * 53000;
      return kantor;
    },
    admin() {
      let admin = 0;
      admin = 1 * 5000;
      return admin;
    },
    filteredList() {
      return this.ListByDate.filter(item => {
        return moment(item.tanggal).format('YYYY-MM-DD') === moment(this.selectedDate).format('YYYY-MM-DD');
      });
    }
  }
}
</script>
<style scope>
.table-primary tr .judul {
  background-color: var(--v-primary-base);
  color: white;
  width: 300px;
}
</style>
