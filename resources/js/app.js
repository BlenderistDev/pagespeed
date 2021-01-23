require('./bootstrap');

window.Vue = require('vue');

Vue.component('measurements', require('./components/Measurements.vue').default);
Vue.component('app', require('./components/App.vue').default);
Vue.component('admin', require('./components/admin/admin.vue').default);
Vue.component('domain', require('./components/domain/Domain.vue').default);

import Vue from 'vue';
window.Vue = Vue;

import VueRouter from 'vue-router'
import VueRandomColor from 'vue-randomcolor'

Vue.use(VueRandomColor)
Vue.use(VueRouter);

import store from './store/index.js';
import router from  './router';

new Vue({
    el: '#app',
    store: store,
    router: router,
});

