<template lang="pug">
.row
  .col(
    v-for="(serviceAudits, serviceName) in audits"
  ) 
    .text-center
      h2 {{ serviceName }}
    ul(class="list-group")
      template(v-for="(audit, auditKey) in serviceAudits")
        li(
          class="list-group-item d-flex justify-content-between align-items-center"
          v-if="measurement[serviceName] && measurement[serviceName][audit.id]"
        ) {{ audit.title }}
          span(class="badge badge-primary badge-pill") {{ measurement[serviceName][audit.id].value }}
</template>

<script>
import { mapState } from 'vuex'

export default {
  data () {
    return {
      measurement: {},
    }
  },
  created () {
    axios.post('/api/audit-results/show', {
      id: this.$route.params.id
    }).then(res => this.measurement = res.data);
  },
  computed: {
    ...mapState([
      'audits',
    ])
  },
}
</script>

<style scoped>
.row {
  padding-top: 1%;
  padding-bottom: 2%;
}
</style>
