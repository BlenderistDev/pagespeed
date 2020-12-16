<template lang="pug">
  .form-row
    .form-group.col-md-6
      input(v-model="value" name="filter" class="form-control")
    .form-group.col-md-6
      button(v-on:click="setFilter(filter)" class="btn btn-primary") Отфильтровать
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
      'setFilter'
    ]),
  }
}
</script>