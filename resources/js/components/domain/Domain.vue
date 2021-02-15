<template lang="pug">
.card
  .card-header {{ domain }}
  .card-body.d-flex.justify-content-around
    .form-check.form-check-inline
      input.form-check-input(
        v-model="service",
        type="radio",
        value="desktop"
      )
      label
      | desktop
    .form-check.form-check-inline
      input.form-check-input(
        v-model="service",
        type="radio",
        value="mobile"
      )
      label
      | mobile
  chart(:chartData="chart", :height="height")
</template>

<script>
import Chart from "./Chart.vue";
import _ from 'lodash'

import { mapState, mapActions } from "vuex";

export default {
  components: {
    Chart,
  },
  data: () => {
    return {
      service: "mobile",
      chartData: {
        mobile: "",
        desktop: "",
      },
    };
  },
  computed: {
    ...mapState(["audits"]),
    domain: function () {
      return this.$route.query.domain;
    },
    chart: function () {
      const datasets = _.reduce(Object.entries(this.chartData[this.service]), (datasets, el) => {
        datasets.push({
          data: el[1],
          label: this.audits[this.service][el[0]]["title"],
          fill: false,
          hidden: true,
          borderColor: this.$randomColor(),
        })
        return datasets
      }, [])
      return {
        datasets: datasets,
      };
    },
    height: function () {
      return window.innerHeight - 200;
    },
  },
  created() {
    axios.post("/api/audit-results/domain", {
      domain: this.domain,
    }).then(response => this.chartData = response.data);
  },
  methods: {
    ...mapActions(["fetchChartData"]),
  },
};
</script>
