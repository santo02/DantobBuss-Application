import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [{
    path: '/',
    name: 'pages-login',
    component: () => import('@/views/pages/Login.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '/supir',
    name: 'pages-supir',
    component: () => import('@/views/pages/supir/list-supir.vue'),
    meta: {
      // requiresAuth: true,
      // requiresRole: 'admin'
    }
  },
  {
    path: '/admin-loket',
    name: 'pages-admin-loket',
    component: () => import('@/views/pages/Admin Loket/list-admin-loket.vue'),
    meta: {
      // requiresAuth: true,
      // requiresRole: 'admin'
    }
  },
  {
    path: '/add-admin-loket',
    name: 'pages-add-admin-loket',
    component: () => import('@/views/pages/Admin Loket/add-admin-loket.vue'),
  },
  {
    path: '/loket',
    name: 'pages-loket',
    component: () => import('@/views/pages/Loket/list-loket.vue'),
  },
  {
    path: '/add-loket',
    name: 'pages-add-loket',
    component: () => import('@/views/pages/Loket/add-loket.vue'),
  },
  {
    path: '/edit-loket/:id',
    name: 'pages-edit-lokets',
    component: () => import('@/views/pages/Loket/edit-loket.vue'),
  },
  {
    path: '/  -user/:id',
    name: 'pages-edit-user',
    component: () => import('@/views/pages/edit-user.vue'),
  },
  {
    path: '/add-supir',
    name: 'pages-add-supir',
    component: () => import('@/views/pages/supir/add-supir.vue'),
  },
  {
    path: '/mobil',
    name: 'pages-mobil',
    component: () => import('@/views/pages/Mobil/list-mobil.vue'),
  },
  {
    path: '/add-mobil',
    name: 'pages-add-mobil',
    component: () => import('@/views/pages/Mobil/add-mobil.vue'),
  },
  {
    path: '/edit-mobil/:id',
    name: 'pages-edit-mobil',
    component: () => import('@/views/pages/Mobil/edit-mobil.vue'),
  },
  {
    path: '/route',
    name: 'pages-routes',
    component: () => import('@/views/pages/Rute/list-route.vue'),
  },
  {
    path: '/add-route',
    name: 'pages-add-route',
    component: () => import('@/views/pages/Rute/add-route.vue'),
  },
  {
    path: '/edit-route/:id',
    name: 'pages-edit-route',
    component: () => import('@/views/pages/Rute/edit-route.vue'),
  },
  {
    path: '/schedule',
    name: 'pages-schedule',
    component: () => import('@/views/pages/Schedule/list-schedule.vue'),
  },
  {
    path: '/add-schedule',
    name: 'pages-add-schedule',
    component: () => import('@/views/pages/Schedule/add-schedule.vue'),
  },
  {
    path: '/edit-schedule/:id',
    name: 'pages-edit-schedule',
    component: () => import('@/views/pages/Schedule/edit-schedule.vue'),
  },
  {
    path: '/pemesanan',
    name: 'pages-pemesanan',
    component: () => import('@/views/pages/Pemesanan/pemesanan.vue'),
  },
  {
    path: '/costumize-pemesanan/',
    name: 'pages-costumize-pemesanan',
    component: () => import('@/views/pages/Pemesanan/costum_pesanan.vue'),
  },
  {
    path: '/confirmasi-pemesanan',
    name: 'pages-confirmation-bookings',
    component: () => import('@/views/pages/Pemesanan/confirmasi_pesanan.vue'),
  },
  {
    path: '/pembayaran',
    name: 'pembayaran',
    component: () => import('@/views/pages/Pembayaran/pembayaran-page.vue'),
  },
  {
    path: '/pembayaran-method',
    name: 'pembayaran-method',
    component: () => import('@/views/pages/Pembayaran/pembayaran-method.vue'),
  },
  {
    path: '/pembayaran-instruction/:howToPayApi',
    name: 'pembayaran-instruction',
    component: () => import('@/views/pages/Pembayaran/pembayaran-instruction.vue'),
    props: true
  },
  {
    path: '/all-bus',
    name: 'all-bus',
    component: () => import('@/views/pages/Pemesanan/pemesanan-by-penumpang.vue'),
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('@/views/dashboard/Dashboard.vue'),
  },
  {
    path: '/Beranda',
    name: 'dashboard-penumpang',
    component: () => import('@/views/dashboard/DashboardPenumpang.vue'),
  },
  {
    path: '/perjalanan-supir',
    name: 'perjalanan-supir',
    component: () => import('@/views/pages/Supir/riwayat-perjalanan-supir.vue'),
  },
  {
    path: '/riwayat-perjalanan',
    name: 'riwayat-perjalanan',
    component: () => import('@/views/pages/Pesanan/riwayat-perjalanan.vue'),
  },
  {
    path: '/penumpang',
    name: 'penumpang',
    component: () => import('@/views/pages/Supir/penumpang.vue'),
  },
  {
    path: '/pesananku',
    name: 'pesananku',
    component: () => import('@/views/pages/Pesanan/pesananku.vue'),
  },
  {
    path: '/e-ticket/:id',
    name: 'e-ticket',
    component: () => import('@/views/pages/Pesanan/e-Ticket.vue'),
  },
  {
    path: '/tracking/:schedule_id',
    name: 'tracking',
    component: () => import('@/views/pages/Tracking/tracking.vue'),
  },
  {
    path: '/catatan-keuangan',
    name: 'catatan-keuangan',
    component: () => import('@/views/pages/Keuangan/catatan-keuangan.vue'),
  },
  {
    path: '/detail-catatan-keuangan/:tanggal',
    name: 'detail-catatan-keuangan',
    component: () => import('@/views/pages/Keuangan/detail-catatan-keuangan.vue'),
  },
  {
    path: '/detail-keuangan-by-penumpang/:id',
    name: 'detail-keuangan-by-penumpang',
    component: () => import('@/views/pages/Keuangan/detail-keuangan.vue'),
  },
  {
    path: '/Komisi',
    name: 'komisi',
    component: () => import('@/views/pages/Komisi/komisi.vue'),
  },
  {
    path: '/detail-Komisi/:tanggal',
    name: 'detail-komisi',
    component: () => import('@/views/pages/Komisi/detail-komisi.vue'),
  },
  {
    path: '/penumpang-bus/:id',
    name: 'penumpang-bus',
    component: () => import('@/views/pages/Supir/penumpang-bus.vue'),
  },
  {
    path: '/typography',
    name: 'typography',
    component: () => import('@/views/typography/Typography.vue'),
  },
  {
    path: '/icons',
    name: 'icons',
    component: () => import('@/views/icons/Icons.vue'),
  },
  {
    path: '/cards',
    name: 'cards',
    component: () => import('@/views/cards/Card.vue'),
  },
  {
    path: '/simple-table',
    name: 'simple-table',
    component: () => import('@/views/simple-table/SimpleTable.vue'),
  },
  {
    path: '/form-layouts',
    name: 'form-layouts',
    component: () => import('@/views/form-layouts/FormLayouts.vue'),
  },
  {
    path: '/pages/account-settings',
    name: 'pages-account-settings',
    component: () => import('@/views/pages/account-settings/AccountSettings.vue'),
  },
  // {
  //   path: '/pages/login',
  //   name: 'pages-login',
  //   component: () => import('@/views/pages/Login.vue'),
  //   meta: {
  //     layout: 'blank',
  //   },
  // },
  {
    path: '/pages/register',
    name: 'pages-register',
    component: () => import('@/views/pages/Register.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '/error-404',
    name: 'error-404',
    component: () => import('@/views/Error.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '*',
    redirect: 'error-404',
  },
]



const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.isAuthenticated) {
    next({
      path: '/login'
    });
  } else if (to.meta.requiresRole && (store.state.isAdmin || store.state.isDireksi)) {
    next({
      path: '/home'
    });
  } else if (to.meta.requiresRole && store.state.isAdminKantor) {
    next({
      path: '/admin'
    });
  } else if (to.meta.requiresRole && store.state.isDriver) {
    next({
      path: '/drivers'
    });
  } else if (to.meta.requiresRole && store.state.isPassenger) {
    next({
      path: '/passengers'
    });
  } else {
    next();
  }
});
export default router
