<template lang="pug">
  div
      div(v-for="(serviceAudits, serviceKey) in showColumns" v-bind:key="serviceKey")
        AuditFilter(:serviceKey="serviceKey")
      .row
        .col-md-4.mr-auto
          FilterForm(field="domain")
        .col-auto
          button(v-on:click="getMeasurments()" class="btn btn-primary") Обновить
      .measure-table
        table(class="table table-striped table-bordered")
          MeasureTableHeader(
              :audits="audits"
              :showColumns="showColumns"
              :sortField="sortField"
              :sortWay="sortWay"
              v-on:sort="sortMeasurements($event)"
              v-on:sortByAudit="sortMeasurementsByAudit($event)"
          )
          MeasureTableBody(
            :audits="audits",
            :auditResults="auditResults"
            :showColumns="showColumns"
          )
      TablePagination(v-on:page-change="changePage($event)"
        v-bind:count="allCount"
        v-bind:onPage="onPage"
        v-bind:page="page"
      )
</template>

<script>

import TablePagination from './TablePagination.vue';
import FilterForm from './FilterForm.vue';
import MeasureTableHeader from './MeasureTableHeader.vue';
import MeasureTableBody from './MeasureTableBody.vue';
import AuditFilter from './AuditFilter.vue';
import { mapActions } from 'vuex';

export default {
  components: {
    TablePagination,
    FilterForm,
    MeasureTableHeader,
    MeasureTableBody,
    AuditFilter,
  },
  data: function() {
    return {
      audits: [],
      auditResults: [],
      measurements: [],

      // showColumns: {},

      filter: '',
      sortField: 'created_at',
      sortWay: 'DESC',
      sortServiceName: '',

      page: 1,
      onPage: 10,
      allCount: 0,
    }
  },
  created: function () {
    this.fetchMeasurements();
    this.fetchAudits();
  },
  computed: {
    showColumns: function() {
      return this.$store.state.showColumns;
    },
    measureIdList: function() {
      const measureIdList = [];
      for (const key in this.measurements) {
        measureIdList.push(this.measurements[key].id);
      }
      return measureIdList;
    },
    measurementsRequestParams: function() {
      return {
        page: this.page,
        onPage: this.onPage,
        filter: this.filter,
        sortField: this.sortField,
        sortWay: this.sortWay,
        sortServiceName: this.sortServiceName,
      };
    }
  },
  methods: {
    ...mapActions([
      'fetchMeasurements',
      'fetchAudits',
    ]),
    getAuditResults: function() {
      return axios.post('/api/audit-results', {
        idList: this.measureIdList,
      }).then((response) => {
        this.auditResults = response.data;
      });
    },
    getMeasurments: function() {
      return axios.post('/api/measurements', this.measurementsRequestParams).then((result) => {
        this.measurements = result.data.measurements;
        this.allCount = result.data.count;
        this.getAuditResults();
      });
    },
    filterMeasurments: function(filterString) {
      this.filter = filterString;
      this.getMeasurments();
    },
    sortMeasurements: function(sortObject) {
      this.sortField = sortObject.sortField;
      this.sortWay = sortObject.sortWay;
      this.sortServiceName = '';
      this.getMeasurments();
    },
    sortMeasurementsByAudit: function(sortObject) {
      this.sortField = sortObject.sortField;
      this.sortWay = sortObject.sortWay;
      this.sortServiceName = sortObject.sortServiceName;
      this.getMeasurments();
    },
    changePage: function($page) {
      this.page = $page;
      this.getMeasurments();
    },
    updateAuditFilter: function(service, checkedColumns) {
      
    },
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