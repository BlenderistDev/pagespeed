/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('admin', require('./components/admin/admin.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue';
import VueRouter from 'vue-router'
import Vuex from 'vuex';

import RegularAuditForm from './components/admin/RegularAuditForm.vue';
import RegularAuditList from './components/admin/RegularAuditList.vue';

const routes = [
    { path: '/regular-audit/list', component: RegularAuditList },
    { path: '/regular-audit/form', component: RegularAuditForm }
  ]

  const router = new VueRouter({
    routes // сокращённая запись для `routes: routes`
  })

window.Vue = Vue;
window.VueRouter = VueRouter;
window.Vuex = Vuex;

Vue.use(VueRouter)
Vue.use(Vuex);

import store from './store/store.js';

const app = new Vue({
    el: '#app',
    router,
    store: new Vuex.Store(store),
});

