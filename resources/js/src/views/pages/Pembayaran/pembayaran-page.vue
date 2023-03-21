<template>

  <div>
    <h3>Halaman B</h3>
    <p>Nama: {{ dataFromPageA.nama }}</p>
    <p>Umur: {{ dataFromPageA.umur }}</p>
    <p>Alamat Jemput: {{ dataFromPageA.alamatJemput }}</p>
  </div>
</template>
<script>
import { mapState } from 'vuex';

export default {
  // Import lainnya

};
</script>
