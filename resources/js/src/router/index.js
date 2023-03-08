import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
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
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('@/views/dashboard/Dashboard.vue'),
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

export default router
