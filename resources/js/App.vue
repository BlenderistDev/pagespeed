<template lang="pug">
  .container-fluid
    Menu
    router-view
</template>

<script>
import Menu from './components/Menu.vue';
import {mapActions} from "vuex";

export default {
  components: {
    Menu,
  },
  created() {
    this.fetchAudits();
  },
  methods: {
    ...mapActions([
      'fetchAudits',
    ]),
  }
}

</script>
<style scoped>
nav {
  background-color: #e3f2fd;
}
</style>
