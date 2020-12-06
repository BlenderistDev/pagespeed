<template lang="pug">
  .form-row
    .form-group.col-md-6
      input(v-model="filter" name="filter" class="form-control")
    .form-group.col-md-6
      button(v-on:click="$emit('filtering', filter)" class="btn btn-primary") Отфильтровать
</template>

<script>
export default {
  data: function() {
    return {
      filter: '',
    }
  }
}
</script>