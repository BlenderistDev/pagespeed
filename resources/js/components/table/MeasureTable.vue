<template lang="pug">
  div
      div(v-for="(serviceAudits, serviceKey) in showColumns" v-bind:key="serviceKey")
        AuditFilter(:serviceKey="serviceKey")
      button(v-on:click="fetchMeasurements()" class="btn btn-primary") Обновить
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
import { mapActions } from 'vuex';

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
    showColumns: function() {
      return this.$store.state.showColumns;
    },
  },
  methods: {
    ...mapActions([
      'fetchMeasurements',
      'fetchAudits',
    ]),
  }
}
</script>

<style>
  .table {
    border: 1px solid;
  }
  .measure-table {
    overflow: auto
  }
</style>