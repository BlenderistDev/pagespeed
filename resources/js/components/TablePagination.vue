<template lang="pug">
  div
    nav(aria-label='...')
      ul(class="pagination")
        li(v-for="n in pagesCount" v-bind:class="getClassForPage(n)")
          a(class='page-link' v-on:click="$emit('page-change', n)")
            |{{ n }}
</template>

<script>
export default {
  props: ['page', "onPage", "count"],
  methods: {
    getClassForPage: function(page) {
      if (page === this.page) {
        return 'page-item active';
      } else {
        return 'page-item';
      }
    }
  },
  computed: {
    pagesCount: function() {
      return Math.ceil(this.count / this.onPage);
    }
  }
}
</script>