<script>
import { Line, mixins } from 'vue-chartjs'
const { reactiveProp } = mixins

export default {
  extends: Line,
  mixins: [reactiveProp],
  // props: ['options'],
  mounted () {
    // this.chartData создаётся внутри миксина.
    // Если вы хотите передать опции, создайте локальный объект options
    this.renderChart(this.chartData, this.options)
  },
  data: function() {
    return {
      // chartData: {
      //   // labels: ['Январь', 'Февраль'],
      //   datasets: [
      //     {
      //       label: 'Данные 1',
      //       backgroundColor: '#f87979',
      //       // data: [
      //       //   {
      //       //     x: 10,
      //       //     y: 20
      //       //   },
      //       //   {
      //       //     x: 15,
      //       //     y: 10
      //       //   }
      //       // ]
      //     }
      //   ]
      // },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    }
  },
}
</script>
