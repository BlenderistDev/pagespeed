<template lang="pug">
  .form-row
    .form-group.col-md-6
      input(v-model="value" v-on:change="addFilter(filter)" name="filter")
</template>

<script>
import { mapActions } from 'vuex';

export default {
  data: function() {
    return {
      value: '',
    }
  },
  props: ['field'],
  computed: {
    filter: function() {
      return {
        field: this.field,
        value: this.value,
      }
    },
  },
  methods: {
    ...mapActions([
      'addFilter'
    ]),
  }
}
</script>