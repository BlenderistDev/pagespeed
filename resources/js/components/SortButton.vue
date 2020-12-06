<template lang="pug">
  span(v-on:click="sortClick()")
    |{{ columnName }}
    span(v-if="sortField === columnName")
      span(v-if="sortWay === 'DESC'") &#8593;
      span(v-if="sortWay === 'ASC'") &#8595;
</template>

<script>
export default {
  props: ['sortField', 'columnName'],
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
        sortField: this.columnName,
        sortWay: this.newSortingWay,
      }
    },
  },
  methods: {
    sortClick: function() {
      this.sortWay = this.newSortingWay;
      this.$emit('sorting', this.sortObject);
    }
  }
}
</script>