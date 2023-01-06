<template>
  <div class="card">
    <div class="p-3 card-body mb-3 mt-1">
      <Pie :chart-data="chartData" :chart-options="chartOptions" :height=363 />
    </div>
  </div>
</template>

<script>
import { Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, RadialLinearScale } 
from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, RadialLinearScale)
export default {
  name: "gradient-line-chart",
  components: {Pie},
  extends: Pie,
  props: ["absenpegawai"],
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
      akun:[],
      chartData: {
          labels: ["Hadir", "Tidak Hadir","Izin", "Request Attendance" ],
          datasets: [
            {
              label: 'My First Dataset',
              data: this.absenpegawai,
              backgroundColor: [
              'rgb(75, 192, 192)',
              'rgb(255, 99, 132)',
              'rgb(255, 205, 86)',
              'rgb(153, 102, 255)',
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
