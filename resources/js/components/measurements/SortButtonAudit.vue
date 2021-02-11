<template lang="pug">
span(v-on:click="sortClick()")
  slot
  span(v-if="showSortIcon")
    span(v-if="sortWay === 'DESC'") &#8593;
    span(v-if="sortWay === 'ASC'") &#8595;
</template>

<script>
import { mapActions, mapState } from 'vuex';

export default {
  props: ['auditId', 'service'],
  data: function() {
    return {
      sortWay: '',
    }
  },
  computed: {
    ...mapState([
      'sort'
    ]),
    newSortingWay: function() {
      if (!this.sortWay || this.sortWay === 'DESC') {
        return'ASC';
      } else {
          return "DESC";
      }
    },
    sortObject: function() {
      return {
        service: this.service,
        field: this.auditId,
        way: this.newSortingWay,
      }
    },
    sortField: function() {
      return this.sort.field;
    },
    sortService: function() {
      return this.sort.service;
    },
    showSortIcon: function() {
      return (this.sortField === this.auditId) && (this.sortService === this.service)
    }
  },
  methods: {
    ...mapActions([
      'sort',
    ]),
    sortClick: function() {
      this.sortWay = this.newSortingWay;
      this.sort(this.sortObject);
    },
  }
}
</script>