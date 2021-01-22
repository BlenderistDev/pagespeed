<template lang="pug">
  .container-fluid
    Menu
    router-view
</template>

<script>
import Menu from './Menu.vue';

export default {
   components: {
     Menu,
   }
}

</script>
<style scoped>
nav {
  background-color: #e3f2fd;
}
</style>
