<template lang="pug">
.form-row
  .form-group.col-md-6
    |C
    input(v-model="moreValue" type="date" @change="addMoreFilter(moreFilter)")
    |По
    input(v-model="lessValue" type="date" @change="addLessFilter(lessFilter)")
</template>

<script>
import { mapActions } from 'vuex';

export default {
  props: ['field'],
  data: function() {
    return {
      lessValue: null,
      moreValue: null,
    }
  },
  computed: {
    lessFilter: function() {
      return {
        field: this.field,
        value: this.lessValue,
      }
    },
    moreFilter: function() {
      return {
        field: this.field,
        value: this.moreValue,
      }
    },
  },
  methods: {
    ...mapActions([
      'addLessFilter',
      'addMoreFilter',
    ]),
  }
}
</script>