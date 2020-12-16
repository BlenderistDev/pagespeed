export default {
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
    filter: {
      field: '',
      value: '',
    },
    measurements: {},
  },
  getters: {
    columnsForService: state => service => {
      return state.showColumns[service];
    },
    auditsForService: state => service => {
      return state.audits[service];
    },
    measurementsIdList: state => {
      const idList = [];
      state.measurements.forEach(measurement => {
        idList.push(measurement.id);
      });
      return idList;
    },
    getPage: state => state.page.page,
    getOnPage: state => state.page.onPage,
    getPageCount: state => state.page.pageCount,
  },

  actions: {
    fetchAudits({ commit }) {
      return axios.get('/api/audits').then((result) => {
        commit('setAudits', result.data);
        const showColumns = {};
        for (const service in result.data) {
          showColumns[service] = [];
          for (const auditKey in result.data[service]) {
            showColumns[service].push(result.data[service][auditKey].name);
          }
        }
        commit('setShowColumns', showColumns);
      });
    },
    sort({dispatch, commit}, sort) {
      commit('setSort', sort);
      dispatch('fetchMeasurements');
    },
    fetchMeasurements({commit, dispatch, state}) {
      return axios.post('/api/measurements', {
        page: state.page,
        filter: state.filter,
        sort: state.sort,
      }).then((result) => {
        commit('setMeasurements', result.data.data);
        commit('setPageCount', result.data.last_page);
        dispatch('fetchAuditResults');
      })
    },
    fetchAuditResults({commit, dispatch, getters}) {
      return axios.post('/api/audit-results', {
        idList: getters.measurementsIdList,
      }).then((response) => {
        commit('setAuditResults', response.data);
      });
    },
    setPage({commit, dispatch}, page) {
      commit('setPage', page);
      dispatch('fetchMeasurements');
    },
    setFilter({commit, dispatch}, filter) {
      commit('setFilter', filter);
      dispatch('fetchMeasurements');
    },
  },

  mutations: {
    updateShowColumns(state, params) {
        Vue.set(state.showColumns, params.service, params.columns);
    },
    setShowColumns(state, showColumns) {
        state.showColumns = showColumns;
    },
    setAudits(state, audits) {
        state.audits = audits;
    },
    setSort(state, sort) {
      state.sort = sort;
    },
    setFilter(state, filter) {
      state.filter = filter;
    },
    setPage(state, page) {
      Vue.set(state.page, 'page', page);
    },
    setPageCount(state, pageCount) {
      Vue.set(state.page, 'pageCount', pageCount);
    },
    setMeasurements(state, measurements) {
      state.measurements = measurements;
    },
    setAuditResults(state, auditResults) {
      state.auditResults = auditResults;
    }
  }
}