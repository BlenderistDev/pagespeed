<template lang="pug">
  div
    div(v-if="services_count")
      div(v-for="(service, serviceKey) in services" v-bind:key="serviceKey")
        .alert.alert-primary.text-center(v-on:click="service.show = !service.show") 
          |{{ serviceKey }}

        ul(v-show="service.show" class="list-unstyled card-columns")
          li(v-for="(item, key, index) in service.headers" v-bind:key="index" v-bind:name="item.name")
            input(type="checkbox" v-model="showColumns" v-bind:value="serviceKey + item.name")
            label(class="form-check-label")
            | {{item.name}}
      .row
        .col-md-4.mr-auto
          FilterForm(v-on:filtering="filterMeasurments($event)")
        .col-auto
          button(v-on:click="getMeasurments()" class="btn btn-primary") Обновить
      
      .measure-table
        table(class="table table-striped table-bordered")
          thead
            tr
            th(scope="col") 
              SortButton(columnName="domain" v-bind:sortField="sortField" v-bind:sortWay="sortWay" v-on:sorting="sortMeasurements($event)")
            th(scope="col")
              SortButton(columnName="created_at" v-on:sorting="sortMeasurements($event)")
            template(v-for="(service, serviceKey) in services")
                template(v-for="(item, key, index) in service.headers")
                  th(v-show="showColumns.includes(serviceKey + item.name)" scope="col")
                    SortButtonAudit(v-bind:auditId="item.id" v-bind:serviceName="serviceKey" v-bind:columnName="item.name" v-on:sorting="sortMeasurementsByAudit($event)")
          tbody
            tr(v-for="measurement in measurements" v-bind:key="measurement.id")
              td {{ measurement.domain }}
              td {{ measurement.created_at }}
              template(v-for="(service, serviceKey) in services")
                template(v-for="(header, auditKey, index) in service.headers")
                  td(v-show="showColumns.includes(serviceKey + header.name)" v-bind:class="serviceKey")
                    template(v-if="service.audits[measurement.id] && service.audits[measurement.id][header.id]")
                      | {{ service.audits[measurement.id][header.id].value }}
          
      TablePagination(v-on:page-change="changePage($event)" v-bind:count="allCount", v-bind:onPage="onPage", v-bind:page="page")
           
</template>

<script>

import TablePagination from './TablePagination.vue';
import FilterForm from './FilterForm.vue';
import SortButton from './SortButton.vue';
import SortButtonAudit from './SortButtonAudit.vue';

export default {
  components: {
    TablePagination,
    FilterForm,
    SortButton,
    SortButtonAudit,
  },
  data: function() {
    return {
      showColumns: [],
      services: [],
      measurements: [],
      page: 1,
      onPage: 10,
      allCount: 0,
      filter: '',
      sortField: 'created_at',
      sortWay: 'DESC',
      sortServiceName: '',
    }
  },
  created: function () {
    this.getMeasurments().then(() => {
      for(var prop in this.services) {
        this.services[prop].headers.forEach((header) => {
          this.showColumns.push(prop + header.name);
        });
      }
      for(const service in this.services) {
        Vue.set(this.services[service], 'show', false)
      }
    })
  },
  computed: {
    services_count: function() {
      return Object.keys(this.services).length;
    }
  },
  methods: {
    getMeasurments: function() {
      return axios.post('/api/measurements', {
        page: this.page,
        onPage: this.onPage,
        filter: this.filter,
        sortField: this.sortField,
        sortWay: this.sortWay,
        sortServiceName: this.sortServiceName,
      }).then((result) => {
        this.services = result.data.services;
        this.measurements = result.data.measurements;
        this.allCount = result.data.count;
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
    changePage: function($event) {
      this.page = $event;
      this.getMeasurments();
    },
  }
}
</script>

<style>
  .mobile {
    background-color: green;
  }
  .desktop {
    background-color: blue;
  }
  .table {
    border: 1px solid;
  }
  .card-columns {
    column-count: 5;
  }
  .measure-table {
    overflow: auto
  }
</style>