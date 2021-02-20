<template lang="pug">
tbody
  tr(v-for="measurement in measurements" :key="measurement.id")
    td
      router-link(:to="{name: 'audit', params: { id: measurement.id } }") {{ measurement.id }}
    td(@click="goToDomain(measurement.domain)") {{ measurement.domain }}
    td {{ measurement.comment }}
    td {{ measurement.created_at }}
    template(v-for="(serviceAudits, serviceKey) in audits")
      template(v-for="(audit, auditKey) in serviceAudits")
        transition(name="slide-fade")
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
  methods: {
    goToDomain: function(domain) {
      this.$router.push({ path: 'domain', query: { domain: domain } })
    },
    goToAudit: function(auditId) {
      this.$router.push({ path: 'audit', params: { id: auditId } })
    },
  }
}
</script>

<style scoped>
  .mobile {
    background-color:lightgreen;
  }
  .desktop {
    background-color: lightblue;
  }
  .slide-fade-enter-active, .slide-fade-leave-active {
    transition: all .3s ease;
  }
  .slide-fade-enter, .slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
  }
</style>
