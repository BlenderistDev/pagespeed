<template lang="pug">
  div
    .alert.alert-primary.text-center(@click="show = !show") 
        |{{ serviceKey }}
    ul(v-show="show" class="list-unstyled card-columns")
        li(v-for="(item, key, index) in audits" :key="index" :name="item.name")
          input(
            type="checkbox"
            v-model="showColumns"
            :value="item.name"
            @change="updateShowColumns()"
          )
          label(class="form-check-label") {{item.name}}
</template>

<script>

import { mapState } from 'vuex';

export default {
  props: ['serviceKey'],
  data: function() {
    return {
      show: false,
    };
  },
  computed: {
    audits: function() {
      return this.$store.getters.auditsForService(this.serviceKey);
    },
    showColumns: {
      get () {
        return this.$store.getters.columnsForService(this.serviceKey);
      },
      set (value) {
        this.$store.commit('updateShowColumns', {
          columns: value,
          service: this.serviceKey
        })
      }
    }
  },
  methods: {
    updateShowColumns: function() {
      this.$store.commit('updateShowColumns', {
        columns: this.showColumns,
        service: this.serviceKey
      })
    }
  }
}
</script>

<style>
  .card-columns {
    column-count: 5;
  }
</style>