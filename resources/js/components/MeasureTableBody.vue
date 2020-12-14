<template lang="pug">
  tbody
    tr(v-for="measurement in measurements" v-bind:key="measurement.id")
      td {{ measurement.domain }}
      td {{ measurement.created_at }}
      template(v-for="(serviceAudits, serviceKey) in audits")
        template(v-for="(audit, auditKey) in serviceAudits")
          AuditServiceBody(
            :measurementId="measurement.id"
            :auditResults="auditResults[serviceKey]"
            :audit="audit"
            :serviceKey="serviceKey"
          )
</template>

<script>

import AuditServiceBody from './AuditServiceBody.vue';
import { mapState } from 'vuex';

export default {
    components: {
      AuditServiceBody,
    },
    computed: {
      ...mapState([
        'auditResults',
        'measurements',
      ]),
      audits: function() {
        return this.$store.state.audits;
      }
    },
    // props: ['measurements', 'auditResults'],
}
</script>

<style>
  .mobile {
    background-color: green;
  }
  .desktop {
    background-color: blue;
  }
</style>