require('./bootstrap');

Vue.component('app', require('./App.vue').default);

import Vue from 'vue';
window.Vue = Vue;

import VueRandomColor from 'vue-randomcolor'
Vue.use(VueRandomColor)

import store from './store/index.js';
import router from  './router.js';

new Vue({
    el: '#app',
    store: store,
    router: router,
});

