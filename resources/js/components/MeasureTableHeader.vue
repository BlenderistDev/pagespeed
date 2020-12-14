<template lang="pug">
  thead
    tr
      th(scope="col") 
        SortButton(columnName="domain" v-bind:sortWay="sortWay" v-on:sorting="sortMeasurements($event)") domain
      th(scope="col")
        SortButton(:sortWay="sortWay" columnName="created_at"  v-on:sorting="sortMeasurements($event)") created_at

      template(v-for="(serviceAudits, serviceKey) in audits")
        template(v-for="audit in serviceAudits")
          AuditServiceHeader(
            :audit="audit"
            :showColumns="showColumns[serviceKey]"
            :serviceKey="serviceKey"
            v-on:sortByAudit="sortMeasurementsByAudit($event)"
          )
</template>

<script>
import SortButton from './SortButton.vue';
import AuditServiceHeader from './AuditServiceHeader.vue';
import { mapGetters } from 'vuex';

export default {
  components: {
      SortButton,
      AuditServiceHeader,
  },
  props: ['showColumns','sortField', 'sortWay'],
  computed: {
    audits: function() {
      return this.$store.state.audits;
    }
  },
  methods: {
    sortMeasurements: function(sortObject) {
      this.$emit('sort', sortObject);
    },
    sortMeasurementsByAudit: function(sortObject) {
      this.$emit('sortByAudit', sortObject);
    },
  }
}
</script>