<template lang="pug">
div
  input(type="radio", v-model="service", name="service", value="mobile")
  | mobile
  input(type="radio", name="service", v-model="service", value="desktop")
  | desktop
  chart(:chartData="chart")
</template>

<script>
import Chart from "./Chart.vue";

import { mapState, mapActions } from "vuex";

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