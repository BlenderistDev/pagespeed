<template lang="pug">
  nav(class="navbar navbar-expand-lg navbar-light")
    ul(class="navbar-nav")
      li(class="nav-item")
        router-link(
        class="nav-link"
        :to="{name: 'table'}") Замеры
      li(class="nav-item")
        router-link(
          class="nav-link"
          :to="{name: 'regular'}") Регулярные аудиты
</template>

<style scoped>
  nav {
    background-color: #819fb6;
  }
</style>
