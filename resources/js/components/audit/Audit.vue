<template lang="pug">
div {{ audit }}
</template>

<script>
export default {
  data () {
    return {
      audit: {},
    }
  },
  created () {
    axios.post('/api/audit-results/show', {
      id: this.$route.params.id
    }).then(res => this.audit = res);
  },
}
</script>
