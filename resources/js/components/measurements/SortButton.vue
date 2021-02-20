<template lang="pug">
span(@click="sortClick()")
  slot
  span(v-if="sortField === columnName")
    span(v-if="sortWay === 'DESC'") &#8593;
    span(v-if="sortWay === 'ASC'") &#8595;
</template>

<script>
import { mapActions, mapState } from 'vuex';

export default {
  props: ['columnName'],
  data: function() {
    return {
      sortWay: '',
    }
  },
  computed: {
    newSortingWay: function() {
      if (!this.sortWay || this.sortWay === 'DESC') {
        return'ASC';
      } else {
        return "DESC";
      }
    },
    sortObject: function() {
      return {
        field: this.columnName,
        way: this.newSortingWay,
        service: '',
      }
    },
    sortField: function() {
      return this.$store.state.sort.field;
    }
  },
  methods: {
    ...mapActions([
      'sort',
    ]),
    sortClick: function() {
      this.sortWay = this.newSortingWay;
      this.sort(this.sortObject);
    }
  }
}
</script>
