<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-12">
            <card
              :title="stats.money.title"
              :value="stats.money.value"
              :percentage="stats.money.percentage"
              :iconClass="stats.money.iconClass"
              :iconBackground="stats.money.iconBackground"
              :detail="stats.money.detail"
              directionReverse
            ></card>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <card
              :title="stats.users.title"
              :value="stats.users.value"
              :percentage="stats.users.percentage"
              :iconClass="stats.users.iconClass"
              :iconBackground="stats.users.iconBackground"
              :detail="stats.users.detail"
              directionReverse
            ></card>
          </div>
          <div class="col-lg-4 col-md-12 col-12">
            <card
              :title="stats.sales.title"
              :value="stats.sales.value"
              :percentage="stats.sales.percentage"
              :iconClass="stats.sales.iconClass"
              :iconBackground="stats.sales.iconBackground"
              :detail="stats.sales.detail"
              directionReverse
            ></card>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-7 mb-lg-0 mb-4">
            <!-- line chart -->
            <div class="card">
              <gradient-line-chart :absensigrafik="absensigrafik" />
            </div>
          </div>
          <div class="col-lg-5">
            <div class="card" style="height:415px !important; ">
              <div class="p-3 pb-0 card-header">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-2 ms-2">Aktivitas Terbaru</h6>
                </div>
              </div>
              <div class="card-body ms-2 px-0 pt-0 pb-2 mb-3" style="overflow-y: scroll">
                <div class="card-body ps-2 pe-3 pt-0" >
                  <!-- <p class="text-center text-secondary text-xl font-weight-bold mt-7" style="font-size:18px">Tidak Ada Pemberitahuan</p> -->
                  <ul class="list-group p-2" style="overflow-y: auto;max-height: 260px;" v-for="(data) in notif" :key="data.id">
                  <li
                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-0 border-radius-md bg-white text-dark" style="box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; cursor: pointer;"
                  >
                    <div class="d-flex align-items-center ms-3">
                      <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark text-sm">{{data.judul}}</h6>
                        <span class="text-xs text-secondary"><i>{{data.tanggal}}, jam {{data.jam}}</i></span>
                      </div>
                    </div>
                    <div
                      class="d-flex align-items-center text-secondary text-xs"
                    >{{data.status}}</div>
                  </li>
                </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
              <div class="p-3 pb-0 card-header">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-2">Penugasan Untuk Anda</h6>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table align-items-center">
                  <tbody>
                    <tr v-for="(sale, index) in sales" :key="index">
                      <td class="w-30">
                        <div class="px-2 py-1 d-flex align-items-center">
                          <div>
                            <img :src="sale.flag" alt="Country flag" />
                          </div>
                          <div class="ms-4">
                            <p class="mb-0 text-xs font-weight-bold">Country:</p>
                            <h6 class="mb-0 text-sm">{{ sale.country }}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="text-center">
                          <p class="mb-0 text-xs font-weight-bold">Sales:</p>
                          <h6 class="mb-0 text-sm">{{ sale.sales }}</h6>
                        </div>
                      </td>
                      <td>
                        <div class="text-center">
                          <p class="mb-0 text-xs font-weight-bold">Value:</p>
                          <h6 class="mb-0 text-sm">{{ sale.value }}</h6>
                        </div>
                      </td>
                      <td class="text-sm align-middle">
                        <div class="text-center col">
                          <p class="mb-0 text-xs font-weight-bold">Bounce:</p>
                          <h6 class="mb-0 text-sm">{{ sale.bounce }}</h6>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="card">
              <div class="p-3 pb-0 card-header">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-2">Pengumuman</h6>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table align-items-center">
                  <tbody>
                    <tr v-for="(sale, index) in sales" :key="index">
                      <td class="w-30">
                        <div class="px-2 py-1 d-flex align-items-center">
                          <div>
                            <img :src="sale.flag" alt="Country flag" />
                          </div>
                          <div class="ms-4">
                            <p class="mb-0 text-xs font-weight-bold">Country:</p>
                            <h6 class="mb-0 text-sm">{{ sale.country }}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="text-center">
                          <p class="mb-0 text-xs font-weight-bold">Sales:</p>
                          <h6 class="mb-0 text-sm">{{ sale.sales }}</h6>
                        </div>
                      </td>
                      <td>
                        <div class="text-center">
                          <p class="mb-0 text-xs font-weight-bold">Value:</p>
                          <h6 class="mb-0 text-sm">{{ sale.value }}</h6>
                        </div>
                      </td>
                      <td class="text-sm align-middle">
                        <div class="text-center col">
                          <p class="mb-0 text-xs font-weight-bold">Bounce:</p>
                          <h6 class="mb-0 text-sm">{{ sale.bounce }}</h6>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Card from "../examples/Cards/Card.vue";
import GradientLineChart from "../examples/Charts/GradientLineChartPegawai.vue";
import Carousel from "./components/CarouselPegawai.vue";
import CategoriesCard from "./components/CategoriesCard.vue";
import ArgonButton from "../components/ArgonButton.vue";
import { useToast } from "vue-toastification";

import US from "../assets/img/icons/flags/US.png";
import DE from "../assets/img/icons/flags/DE.png";
import GB from "../assets/img/icons/flags/GB.png";
import BR from "../assets/img/icons/flags/BR.png";

export default {
  name: "dashboard-default",
  components: { ArgonButton },
  data() {
    return {
      infopt:[],
      absensigrafik: null,
      notif: [],
      token: localStorage.getItem("token"),
      role: localStorage.getItem('role'),
      stats: {
        money: {
          title: "Job",
          value: "0",
          percentage: "",
          iconClass: "fa-solid fa-briefcase",
          detail: "Total Job ",
          iconBackground: "bg-gradient-primary",
        },
        users: {
          title: "Complete Job",
          value: "0",
          percentage: "",
          iconClass: "fa-solid fa-list-check",
          iconBackground: "bg-gradient-success",
          detail: "Job Terselesaikan",
        },
        sales: {
          title: "Gaji",
          value: "0",
          percentage: "",
          iconClass: "fa-solid fa-sack-dollar",
          iconBackground: "bg-gradient-warning",
          detail: "Total Gaji Didapat",
        },
      },
      sales: {
        us: {
          country: "United States",
          sales: 2500,
          value: "$230,900",
          bounce: "29.9%",
          flag: US,
        },
        germany: {
          country: "Germany",
          sales: "3.900",
          value: "$440,000",
          bounce: "40.22%",
          flag: DE,
        },
        britain: {
          country: "Great Britain",
          sales: "1.400",
          value: "$190,700",
          bounce: "23.44%",
          flag: GB,
        },
        brasil: {
          country: "Brasil",
          sales: "562",
          value: "$143,960",
          bounce: "32.14%",
          flag: BR,
        },
      },
    };
  },
  components: {
    Card,
    GradientLineChart,
    Carousel,
    CategoriesCard,
  },
  created(){
  },  
  methods:{
    loadgrafik(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/grafikadmin',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.absensigrafik = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
     aktivitas(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/pemberitahuan',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.notif = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
      },
    initMap() {
			const map = new google.maps.Map(document.getElementById("map"), {
				center: { lat: -34.397, lng: 150.644 },
				zoom: 8,
			});
			},
    dashsuperadmin(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/dashsuperadmin',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.stats.sales.value = response.data.pegawai;
                    this.stats.users.value = response.data.pending;
                    this.stats.money.value = response.data.diterima;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
  },
  mounted(){
    // this.dashsuperadmin()
    // this.loadgrafik()
    this.aktivitas()
  }
};
</script>
<style></style>
