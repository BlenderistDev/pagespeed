<template lang="pug">
div azaza
</template>

<script>
export default {
  data: {
    audit: {},
  },
  created() {
    axios.post('/api/audit-results/show', {id: 28}).then(res => console.log(res));
  },
}
</script>
