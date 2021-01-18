<template lang="pug">
  .container-fluid
    .row.justify-content-center
      MeasureForm
      .card
        .card-body
          MeasureTable(ref="measureTable")
          Domain(domain="https://mebelverona.ru")
</template>

<script>
  import MeasureForm from './MeasureForm.vue';
  import MeasureTable from './table/MeasureTable.vue';
  import Domain from './domain/Domain';

  export default {
    components: {
      MeasureForm,
      MeasureTable,
      Domain,
    },
  }
</script>
