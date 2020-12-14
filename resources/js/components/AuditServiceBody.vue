<template lang="pug">
    td(v-show="showColumns.includes(audit.name)" :class="serviceKey")
      template(v-if="auditResults && auditResults[measurementId] && auditResults[measurementId][audit.id]")
        | {{ auditResults[measurementId][audit.id].value }}
</template>

<script>
export default {
  props: ['measurementId', 'auditResults', 'serviceKey', 'audit'],
  computed: {
    showColumns: function() {
      return this.$store.getters.columnsForService(this.serviceKey);
    }
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