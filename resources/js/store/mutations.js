export default {
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
  addFilter(state, filter) {
    Vue.set(state.filter, filter.field, filter.value);
  },
  addLessFilter(state, filter) {
    Vue.set(state.lessFilter, filter.field, filter.value);
  },
  addMoreFilter(state, filter) {
    Vue.set(state.moreFilter, filter.field, filter.value);
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
  },
}
