<template lang="pug">
.card
  .card
    .card-header {{ domain }}
    .card-body.d-flex.justify-content-around
        .form-check.form-check-inline
          input(
            v-model="service",
            class="form-check-input"
            type="radio"
            value="desktop"
            id="defaultCheck1"
          )
          label(
            class="form-check-label"
            for="defaultCheck1"
          )
          | desktop
        .form-check.form-check-inline
          input(
            v-model="service",
            class="form-check-input"
            type="radio"
            value="mobile"
            id="defaultCheck2"
          )
          label(
            class="form-check-label"
            for="defaultCheck2"
          )
          | mobile
  chart(:chartData="chart")
</template>

<script>
import Chart from "./Chart.vue";

import {mapState, mapActions} from "vuex";

export default {
  components: {
    Chart,
  },
  data: () => {
    return {
      service: "mobile",
    };
  },
  props: ["domain"],
  computed: {
    ...mapState([
      "chartData",
      "audits",
    ]),
    chart: function () {
      const datasets = [];
      Object.entries(this.chartData[this.service]).forEach((el) => {
        datasets.push({
          data: el[1],
          label: this.audits[this.service][el[0]]['title'],
          fill: false,
          hidden: true,
          backgroundColor: 'white',
          borderColor: this.$randomColor(),
        });
      });
      return {
        datasets: datasets,
      };
    },
  },
  created() {
    this.fetchChartData(this.$route.params.domain);
  },
  methods: {
    ...mapActions(["fetchChartData"]),
  },
};
</script>
