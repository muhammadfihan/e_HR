<template>
  <div class="card">
    <div class="pb-0 card-header mb-0">
      <h6>Grafik Absensi Pegawai Hari Ini</h6>
      <p class="text-sm">
        <i class="fa fa-arrow-up text-success"></i>
        <span class="font-weight-bold ms-1">{{akun}} Total Pegawai</span>
      </p>
    </div>
    <div class="p-3 card-body">
      <Bar
        :chart-options="chartOptions"
        :chart-data="chartData"
        :chart-id="chartId"
        :dataset-id-key="datasetIdKey"
        :plugins="plugins"
        :css-classes="cssClasses"
        :styles="styles"
        :width="width"
        :height=285
      />
    </div>
  </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
export default {
  name: "gradient-line-chart",
  components: {Bar},
  extends: Bar,
  props: ["absensigrafik"],
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
      chartData: {
          labels: ["Hadir", "Tidak Hadir", "On Time", "Terlambat", "Izin"],
          datasets: [
            {
              label: "Jumlah Pegawai",
              pointRadius: 0,
              backgroundColor: [
              'rgb(255, 99, 132)',
              'rgb(255, 159, 64)',
              'rgb(255, 205, 86)',
              'rgb(75, 192, 192)',
              'rgb(54, 162, 235)',
              'rgb(153, 102, 255)',
            ],
            borderColor: [
              'rgb(255, 99, 132)',
              'rgb(255, 159, 64)',
              'rgb(255, 205, 86)',
              'rgb(75, 192, 192)',
              'rgb(54, 162, 235)',
              'rgb(153, 102, 255)',
            ],
              borderWidth: 2,
              fill: true,
              data: this.absensigrafik,
              maxBarThickness: 20,
            },
          ],
        },
        chartOptions: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            },
          },
          interaction: {
            intersect: false,
            mode: "index",
          },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              padding: 10,
              color: "#fbfbfb",
              font: {
                size: 11,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              color: "#ccc",
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
        },
      },
    }
  },
  mounted(){
  }
};
</script>
