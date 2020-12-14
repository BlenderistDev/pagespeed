<template lang="pug">
  th(v-show="showColumns && showColumns.includes(audit.name)" scope="col")
    SortButtonAudit(
      :auditId="audit.id"
      :service="serviceKey"
    ) {{ audit.name }}
</template>

<script>
import SortButtonAudit from './SortButtonAudit.vue';

export default {
  components: {
      SortButtonAudit,
  },
  computed: {
    showColumns: function() {
      return this.$store.getters.columnsForService(this.serviceKey);
    }
  },
  props: ['audit', 'serviceKey'],
}
</script>
