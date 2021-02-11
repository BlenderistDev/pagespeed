<template lang="pug">
div
  div(v-for="(serviceAudits, serviceKey) in showColumns" :key="serviceKey")
    AuditFilter(:serviceKey="serviceKey")
  button(@click="fetchMeasurements()" class="btn btn-primary") Обновить
  .measure-table
    table(class="table table-striped table-bordered")
      MeasureTableHeader
      MeasureTableBody
  TablePagination
</template>

<script>

import TablePagination from './TablePagination.vue';
import MeasureTableHeader from './MeasureTableHeader.vue';
import MeasureTableBody from './MeasureTableBody.vue';
import AuditFilter from './AuditFilter.vue';
import { mapActions, mapState } from 'vuex';

export default {
  components: {
    TablePagination,
    MeasureTableHeader,
    MeasureTableBody,
    AuditFilter,
  },
  created: function () {
    this.fetchAudits();
    this.fetchMeasurements();
  },
  computed: {
    ...mapState([
      'showColumns'
    ])
  },
  methods: {
    ...mapActions([
      'fetchMeasurements',
      'fetchAudits',
    ]),
  }
}
</script>

<style scoped>
  .table {
    border: 1px solid;
  }
  .measure-table {
    overflow: auto
  }
</style>