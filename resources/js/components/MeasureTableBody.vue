<template lang="pug">
  tbody
    tr(v-for="measurement in measurements" v-bind:key="measurement.id")
      td {{ measurement.domain }}
      td {{ measurement.created_at }}
      template(v-for="(serviceAudits, serviceKey) in audits")
        template(v-for="(audit, auditKey) in serviceAudits")
          td(v-show="showColumns[serviceKey].includes(audit.name)" :class="serviceKey") 
            template(v-if="auditResults[serviceKey] && auditResults[serviceKey][measurement.id] && auditResults[serviceKey][measurement.id][audit.id]")
              | {{ auditResults[serviceKey][measurement.id][audit.id].value }}
</template>

<script>

import { mapState } from 'vuex';

export default {
  computed: {
    ...mapState([
      'auditResults',
      'measurements',
      'showColumns',
      'audits'
    ]),
  },
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