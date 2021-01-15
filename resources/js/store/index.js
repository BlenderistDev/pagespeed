
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import mutations from './mutations.js';
import actions from './actions.js';

export default new Vuex.Store({
  state: {
    showColumns: {},
    audits: {},
    auditResults: {},
    sort: {
      field: 'created_at',
      way: 'DESC',
      service: '',
    },
    page: {
      onPage: 10,
      page: 1,
      pageCount: 1,
    },
    filter: {},
    lessFilter: {},
    moreFilter: {},
    measurements: {},
    chartData: {
        mobile: [],
        desktop: [],
    },
  },
  getters: {
    columnsForService: state => service => state.showColumns[service],
    auditsForService: state => service => state.audits[service],
    getPage: state => state.page.page,
    getOnPage: state => state.page.onPage,
    getPageCount: state => state.page.pageCount,
    measurementsIdList: state => {
      const idList = [];
      state.measurements.forEach(measurement => {
        idList.push(measurement.id);
      });
      return idList;
    },
  },
  mutations: mutations,
  actions: actions,
});
