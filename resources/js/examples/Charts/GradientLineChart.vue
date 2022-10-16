<template>
  <div class="card">
    <div class="pb-0 card-header mb-0">
      <h6>{{ title }}</h6>
      <p class="text-sm">
        <i class="fa fa-arrow-up text-success"></i>
        <span class="font-weight-bold">{{detail1}}</span>
        {{detail2}}
      </p>
    </div>
    <div class="p-3 card-body">
      <div class="chart">
        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
// import Chart from "./chart.js/auto";

export default {
  name: "gradient-line-chart",

  props: {
    title: {
      type: String,
      default: "Grafik Absensi Pegawai",
    },
    detail1: {
      type: String,
      default: "",
    },
    detail2: {
      type: String,
      default: "Ditampilkan secara mingguan",
    },
  },

  mounted() {
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    // gradientStroke1.addColorStop(1, "rgba(94, 114, 228, 0.2)");
    // gradientStroke1.addColorStop(0.2, "rgba(94, 114, 228, 0.0)");
    // gradientStroke1.addColorStop(0, "rgba(94, 114, 228, 0)");
    new Chart(ctx1, {
      type: "bar",
      data: {
        labels: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
        datasets: [
          {
            label: "Pegawai Yang Hadir",
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
            data: [20, 17, 19, 20, 20, 16],
            maxBarThickness: 20,
          },
        ],
      },
      options: {
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
    });
  },
};
</script>
