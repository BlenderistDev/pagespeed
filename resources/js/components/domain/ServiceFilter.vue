<template lang="pug">
  .card-body.d-flex.justify-content-around
    .form-check.form-check-inline
      input#defaultCheck1.form-check-input(
        v-model="service",
        type="radio",
        value="desktop"
      )
      label.form-check-label(for="defaultCheck1")
      | desktop
    .form-check.form-check-inline
      input#defaultCheck2.form-check-input(
        v-model="service",
        type="radio",
        value="mobile"
      )
      label.form-check-label(for="defaultCheck2")
      | mobile
</template>

<script>
export default {
  data: function() {
    
  }
}
</script>