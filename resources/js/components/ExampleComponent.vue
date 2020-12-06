<template lang="pug">
  .container-fluid
    .row.justify-content-center
        MeasureForm(v-on:new-measure-added = "refreshTable()")
        .card
          .card-body
            MeasureTable(ref="measureTable")
</template>

<script>
    import MeasureForm from './MeasureForm.vue';
    import MeasureTable from './MeasureTable.vue';

    export default {
        components: {
            MeasureForm,
            MeasureTable
        },
        methods: {
          refreshTable: function() {
              this.$refs.measureTable.getMeasurments();
          }
        }
    }
</script>
