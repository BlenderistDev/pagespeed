import VueRouter from "vue-router";
import Measurements from "./pages/Measurements.vue";
import Domain from "./pages/Domain.vue";
import RegularAudits from "./pages/RegularAudits.vue";

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
  ],
});
