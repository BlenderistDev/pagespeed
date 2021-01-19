/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.component('measurements', require('./components/Measurements.vue').default);
Vue.component('app', require('./components/App.vue').default);
Vue.component('admin', require('./components/admin/admin.vue').default);
Vue.component('domain', require('./components/domain/Domain.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue';

window.Vue = Vue;
import VueRouter from 'vue-router'

import VueRandomColor from 'vue-randomcolor'

Vue.use(VueRandomColor)

import Measurements from './components/Measurements.vue'
import Domain from './components/domain/Domain.vue'

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'table',
            component: Measurements
        },
        {
            path: '/domain/:domain',
            name: 'domain',
            component: Domain,
            props: true,
        },
    ],
});


import store from './store/index.js';

new Vue({
    el: '#app',
    store: store,
    router: router,
});

