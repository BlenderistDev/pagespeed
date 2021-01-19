<template lang="pug">
  .container
    nav(
      class="navbar navbar-light"
    )
      router-link(
        class="navbar-brand"
        :to="{name: 'table'}") Замеры
    router-view
</template>

<style scoped>
nav {
  background-color: #e3f2fd;
}
</style>
