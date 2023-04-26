<template>
  <div>
    <h2>Komisi</h2>
    <v-text-field type="date" label="Pilih tanggal" placeholder="Pilih Tanggal" v-model="selectedDate"
      style="width: 300px;" solo />
    <template>
      <v-simple-table class="table-primary">
        <template v-slot:default>
          <tbody>
            <tr colspan="3">
              <th class="text-center pt-3">
                <h3>Surat Jalan <br> Bintang Tapanuli</h3>
                <p>Kantor pusat : Jl D.I Panjaitan No.24 Tarutung Telp (0633) 21090 4902039<br>
                  Tarutung : Telp (0633) 21090. Loket Terminal Telp. (0633) 7325354 <br>
                  Perwakilan Medan : Jl.Sisimangaraja No.27 Km. 6,5 Medan Telp. (061) 77823226-76329910</p>
              </th>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </template>
    <v-data-table :headers="headers" :items="filteredItems">
      <template #item.Tanggal="{ item }">
        {{ formatDate(item.tanggal) }}
      </template>
      <template #item.total="{ item }">
        Rp.{{ item.total }}
      </template>
      <template #item.Detail="{ item }">
        <router-link :to="{ name: 'detail-komisi', params: { tanggal: item.tanggal } }">
          Detail
        </router-link>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import moment from 'moment'
import axios from 'axios'
import 'moment/locale/id'

export default {
  data() {
    return {
      selectedDate: null,
      ListByDate: [],
      search: '',
      headers: [
        {
          text: 'Tanggal',
          align: 'start',
          value: 'Tanggal',
        },
        { text: 'Total Pemasukan', value: 'total' },
        // { text: 'Total Setoran Admin Loket', value: 0 },
        // { text: 'Komisi Adm/agen', value: 'total' },
        // { text: 'Komisi Perusahaan', value: 'total' },
        { text: 'Detail', value: 'Detail', sortable: false },
      ],
      filteredItemsList: []
    }
  },
  mounted() {
    const access_token = localStorage.getItem('access_token')

    axios
      .get('/api/Keuangan/index', {
        headers: {
          Authorization: `Bearer ${access_token}`,
        },
      })
      .then((response) => {
        this.ListByDate = response.data.data
      })
      .catch((error) => {
        console.log(error)
      })
  },
  methods: {
    formatDate(date) {
      return moment(date).format('dddd, Do MMMM YYYY')
    },
  },
  computed: {
    filteredItems() {
      if (!this.selectedDate) {
        return this.ListByDate
      } else {
        return this.ListByDate.filter(
          (item) =>
            moment(item.tanggal).format('YYYY-MM-DD') === this.selectedDate
        )
      }
    },
    komisi() {
      let komisi = 0;
      komisi = (10 / 100) * +this.ListByDate.total;
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
  },
    watch: {
      selectedDate(newVal, oldVal) {
        if (!newVal) {
          this.filteredItemsList = this.ListByDate
        } else {
          this.filteredItemsList = this.ListByDate.filter(
            (item) => moment(item.tanggal).format('YYYY-MM-DD') === newVal
          )
        }
      },
    },
  }
</script>
<style scope>
.table-primary tr th {
  background-color: var(--v-primary-base);
  color: white;
  width: 300px;
}
</style>
