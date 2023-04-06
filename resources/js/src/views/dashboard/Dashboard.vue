<template>
  <div>

    <div v-if="userRole == 'passenger'">
      <DashboardPenumpang></DashboardPenumpang>
    </div>
    <div v-if="userRole == 'driver'">
      <DashboardDriver></DashboardDriver>
    </div>
    <div v-if="userRole == 'admin'">
      <DashboardAdmin></DashboardAdmin>
    </div>
  </div>
</template>
<script>

import DashboardAdmin from './DashboardAdmin.vue';
import DashboardPenumpang from './DashboardPenumpang.vue';
import DashboardDriver from './DashboardDriver.vue';
export default {
  data(){
    return{}
  },
  components:{
    DashboardAdmin,
    DashboardPenumpang,
    DashboardDriver

  },
  computed: {
    userRole() {
      return this.$store.state.userRole
    },
  }
}
</script>
