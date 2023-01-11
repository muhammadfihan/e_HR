<template>
  <div class="card">
    <div class="pb-0 card-header mb-0">
      <h6>Job/Task Performance</h6>
    </div>
    <div class="p-3 card-body mb-3 mt-1">
      <PolarArea :chart-data="chartData" :chart-options="chartOptions" :height=363 />
    </div>
  </div>
</template>

<script>
import { PolarArea } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, RadialLinearScale } 
from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, RadialLinearScale)
export default {
  name: "polar",
  components: {PolarArea},
  extends: PolarArea,
  props: ["job"],
  // props:
  // {

  //   height: {
  //     type: Number,
  //     default: 280
  //   },
  //   title: {
  //     type: String,
  //     default: "Grafik Absensi Pegawai",
  //   },
  //   detail1: {
  //     type: String,
  //     default: "",
  //   },
  //   detail2: {
  //     type: String,
  //     default: "Ditampilkan secara mingguan",
  //   },
  // },
  
  data(){
    return{
      job:[],
      chartData: {
          labels: ["Complete", "In Progress","Revisi" ],
          datasets: [
            {
              label: 'My First Dataset',
              data: this.job,
              backgroundColor: [
              'rgb(153, 102, 255)',
              'rgb(255, 99, 132)',
              'rgb(255, 205, 86)',
              ],
              hoverOffset: 4

            },
          ],
        },
        chartOptions: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top',
              display: true,
              labels:{
                boxWidth: 20,
                boxHeight: 20
              }
            },
          },
          interaction: {
            intersect: false,
            mode: "index",
          },
        }
        
    }
    
  },
  mounted(){
  }
};
</script>
