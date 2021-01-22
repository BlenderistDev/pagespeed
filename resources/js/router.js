import VueRouter from "vue-router";
import Measurements from "./components/Measurements";
import Domain from "./components/domain/Domain";

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
  ],
});
