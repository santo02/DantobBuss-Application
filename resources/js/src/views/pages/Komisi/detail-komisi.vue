<template>
  <div>
    <h2>Detail Komisi</h2>
    <!-- <v-text-field label="Pilih tanggal" placeholder="Pilih Tanggal" v-model="selectedDate" style="width: 300px;" solo /> -->
    <h5 align="right" class="mb-2">Tanggal : {{ formatDate(tanggal) }}</h5>
    <v-data-table :headers="headers" :items="ListByDate">
      <template #item.tanggal="{ item }">
        {{ formatDate(item.tanggal) }}
      </template>
      <template #item.Detail="{ item }">
        <router-link :to="{ name: 'detail-keuangan-by-penumpang', params: { id: item.schedule_id } }">Detail</router-link>
      </template>
      <template #item.total="{ item }">
        Rp.{{ item.total }}
      </template>
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
              <td>{{ jumlahSchedule }} * Rp.53.0000</td>
              <td>Rp.{{ kantor }}</td>

            </tr>
            <tr>
              <td class="judul">Administrasi</td>
              <td> {{ jumlahSchedule }} * Rp.5.0000 </td>
              <td> Rp.{{ admin }} </td>
            </tr>
            <tr>
              <td>Total Setoran admin loket</td>
              <td></td>
              <td>
                <h4>Rp.{{ totalSemua - (komisi + kantor + admin) }}</h4>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
      <h4 class="mt-4">Pembagian Komisi</h4>
      <v-simple-table class="mt-4 table-primary">
        <template v-slot:default>
          <thead>
            <tr>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="judul">Perusahaan</td>
              <td>(60% * Rp.{{ komisi }}) + {{ kantor }} + {{ admin }}</td>
              <td>RP.{{ perusahaan }}</td>
            </tr>
            <tr>
              <td class="judul">Admin/Agen</td>
              <td> 40% * Rp.{{komisi}}</td>
              <td>Rp.{{ AdminAgen }}</td>
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
      tanggal: this.$route.params.tanggal,
      ListByDate: [],
      jumlahSchedule: '',
      headers: [
        {
          text: 'Tanggal',
          align: 'start',
          value: 'tanggal',
        },
        { text: 'Nomor Polisi', value: 'police_number' },
        { text: 'Nomor Pintu', value: 'nomor_pintu' },
        { text: 'Kedatangan', value: 'arrival' },
        { text: 'Keberangkatan', value: 'derpature' },
        { text: 'Tipe', value: 'type' },
        { text: 'Nama Supir', value: 'name' },
        { text: 'Detail', value: 'Detail', sortable: false, },
        { text: 'Total', value: 'total' },
      ],
      selectedDate: ''
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token');

    axios.get(`/api/Detail-keuangan-Bydate/${this.tanggal}`, {
      headers: {
        'Authorization': `Bearer ${access_token}`
      }
    }).then(response => {
      this.ListByDate = response.data.data;
      this.jumlahSchedule = this.ListByDate.length;
      this.ListByDate.forEach(item => {
        item.total = item.jumlah_booking * item.harga;
      });
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
    komisi() {
      let komisi = 0;
      komisi = (10 / 100) * this.totalSemua;
      return komisi;
    },
    kantor() {
      let kantor = 0;
      kantor = this.jumlahSchedule * 53000;
      return kantor;
    },
    admin() {
      let admin = 0;
      admin = this.jumlahSchedule * 5000;
      return admin;
    },
    perusahaan() {
      let perusahaan = 0;
      perusahaan = (60 / 100 * +this.komisi) + +this.kantor + +this.admin
      return perusahaan;
    },
    AdminAgen() {
      let AdminAgen = 0;
      AdminAgen = (40/ 100 * +this.komisi)
      return AdminAgen;
    },
    filteredList() {
      return this.ListByDate.filter(item => {
        return moment(item.tanggal).format('YYYY-MM-DD') === moment(this.selectedDate).format('YYYY-MM-DD');
      });
    },
    totalSemua() {
      return this.ListByDate.reduce((acc, item) => {
        return acc + item.total;
      }, 0);
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
