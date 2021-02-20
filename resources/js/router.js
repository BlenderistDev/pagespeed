import Vue from 'vue';
import VueRouter from "vue-router";
import Measurements from "./pages/Measurements.vue";
import Domain from "./pages/Domain.vue";
import RegularAudits from "./pages/RegularAudits.vue";
import Audit from './pages/Audit.vue'

Vue.use(VueRouter);

export default new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'table',
      component: Measurements
    },
    {
      path: '/domain/',
      name: 'domain',
      component: Domain,
      props: true,
    },
    {
      path: '/regular-audits/',
      name: 'regular',
      component: RegularAudits
    },
    {
      path: '/audit/:id',
      name: 'audit',
      component: Audit,
      props: true
    },
  ],
});
