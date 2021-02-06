<template lang="pug">
  div
    .alert.alert-primary.text-center(@click="show = !show")
      |{{ serviceKey }}
    ul(v-show="show" class="list-unstyled card-columns")
      li(v-for="(item, key, index) in audits" :key="index" :name="item.name")
        .item-block
          input(
            type="checkbox"
            v-model="showColumns"
            :value="item.name"
            @change="updateFilter()"
          )
          |{{item.title}}
</template>

<script>
import { mapMutations } from 'vuex';

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
    ...mapMutations([
      'updateShowColumns'
    ]),
    updateFilter: function() {
      this.showColumns({
        columns: this.showColumns,
        service: this.serviceKey
      })
    }
  }
}
</script>

<style scoped>
  .card-columns {
    column-count: 4;
  }
  .item-block {
      break-inside: avoid;
      margin-bottom: 7px;
  }
  input {
      margin-right: 3px;
  }
</style>
