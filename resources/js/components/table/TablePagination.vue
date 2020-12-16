<template lang="pug">
  div
    nav(aria-label='...')
      ul(class="pagination")
        li(v-for="n in getPageCount" :class="getClassForPage(n)")
          a(class='page-link' v-on:click="setPage(n)")
            |{{ n }}
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  methods: {
    ...mapActions([
      'setPage',
    ]),
    getClassForPage: function(page) {
      if (page === this.getPage) {
        return 'page-item active';
      } else {
        return 'page-item';
      }
    },
  },
  computed: {
    ...mapGetters([
      'getPage',
      'getPageCount',
    ]),
  },
}
</script>