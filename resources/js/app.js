require('./bootstrap');

window.Vue = require('vue');

Vue.component('app', require('./App.vue').default);

import Vue from 'vue';
window.Vue = Vue;

import VueRouter from 'vue-router'
import VueRandomColor from 'vue-randomcolor'

Vue.use(VueRandomColor)
Vue.use(VueRouter);

import store from './store/index.js';
import router from  './router.js';

new Vue({
    el: '#app',
    store: store,
    router: router,
});

