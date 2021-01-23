export default {
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
  sort({ dispatch, commit }, sort) {
    commit('setSort', sort);
    dispatch('fetchMeasurements');
  },
  fetchMeasurements({ commit, dispatch, state }) {
    return axios.post('/api/measurements', {
      page: state.page,
      filter: state.filter,
      lessFilter: state.lessFilter,
      moreFilter: state.moreFilter,
      sort: state.sort,
    }).then((result) => {
      commit('setMeasurements', result.data.data);
      commit('setPageCount', result.data.last_page);
      dispatch('fetchAuditResults');
    })
  },
  fetchAuditResults({ commit, getters }) {
    return axios.post('/api/audit-results', {
      filter: {
        measurements_id: getters.measurementsIdList,
      }
    }).then((response) => {
      commit('setAuditResults', response.data);
    });
  },
  setPage({ commit, dispatch }, page) {
    commit('setPage', page);
    dispatch('fetchMeasurements');
  },
  addFilter({ commit, dispatch }, filter) {
    commit('addFilter', filter);
    dispatch('fetchMeasurements');
  },
  addLessFilter({ commit, dispatch }, filter) {
    commit('addLessFilter', filter);
    dispatch('fetchMeasurements');
  },
  addMoreFilter({ commit, dispatch }, filter) {
    commit('addMoreFilter', filter);
    dispatch('fetchMeasurements');
  },
}
