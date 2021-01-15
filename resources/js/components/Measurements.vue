<template lang="pug">
  .container-fluid
    .row.justify-content-center
      MeasureForm
      .card
        .card-body
          MeasureTable(ref="measureTable")
          chart(:chartData="mobileChart")
</template>

<script>
  import { mapState, mapActions } from 'vuex';
  import MeasureForm from './MeasureForm.vue';
  import MeasureTable from './table/MeasureTable.vue';
  import chart from './table/chart.vue';

  export default {

    components: {
      MeasureForm,
      MeasureTable,
      chart
    },
      created() {
        this.fetchChartData('https://mebelverona.ru');
      },
      computed: {
          ...mapState([
              'chartData',
          ]),
          mobileChart: function () {
              const datasets = [];
              console.log(this.chartData.mobile)
              Object.entries(this.chartData.mobile).forEach((el) => {
                  console.log(el[1])
                  datasets.push({
                      data: el[1],
                      label: el[0],

                  })
              })
              return {
                  datasets: datasets
              }
          }
      },
      methods: {
          ...mapActions([
              'fetchChartData',
          ]),
      }
  }
</script>
