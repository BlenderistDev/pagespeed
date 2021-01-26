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
  chart(
    :chartData="chart"
    :height="height"
  )
</template>

<script>
import Chart from "../components/domain/Chart.vue";

import {mapState, mapActions} from "vuex";

export default {
  components: {
    Chart,
  },
  data: () => {
    return {
      service: "mobile",
      chartData: {
        mobile: '',
        desktop: '',
      },
    };
  },
  computed: {
    ...mapState([
      "audits",
    ]),
    domain: function() {
      return this.$route.query.domain;
    },
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
    height: function() {
      return window.innerHeight - 200;
    },
  },
  created() {
    axios.post('/api/audit-results/domain', {
      domain: this.domain,
    }).then((response) => {
      this.chartData = response.data
    });
  },
  methods: {
    ...mapActions(["fetchChartData"]),
  },
};
</script>
