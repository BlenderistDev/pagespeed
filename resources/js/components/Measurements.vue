<template lang="pug">
  .container-fluid
    .row.justify-content-center
      MeasureForm
      .card
        .card-body
          MeasureTable(ref="measureTable")
</template>

<script>
  import MeasureForm from './MeasureForm.vue';
  import MeasureTable from './table/MeasureTable.vue';

  export default {
    components: {
      MeasureForm,
      MeasureTable
    },
  }
</script>
