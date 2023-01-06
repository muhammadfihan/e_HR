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
              :value="convertToRupiah(stats.sales.value)"
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
            <div class="card" style="height:415px !important; ">
              <div class="p-3 pb-0 card-header">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-2 ms-2">Job Performance</h6>
                </div>
              </div>
              <div class="card-body ms-2 px-0 pt-0 pb-2 mb-3" style="overflow-y: scroll">
                <div class="card-body ps-2 pe-3 pt-0" >
                  <div class="table-responsive">
                <table class="table align-items-center">
                </table>
              </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="card">
              <gradient-line-chart v-if="absenpegawai != null" :absenpegawai="absenpegawai" />
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card"  style="height:350px !important; ">
              <div class="p-3 pb-0 card-header">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-2 ms-2">Aktivitas Terbaru</h6>
                </div>
              </div>
              <div class="card-body ms-2 px-0 pt-0 pb-2 mb-3" style="overflow-y: scroll">
                <div class="card-body ps-2 pe-3 pt-0" >
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
          <div class="col-lg-5">
            <div class="card" style="height:350px !important; ">
              <div class="p-3 pb-0 card-header col-lg-12">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-2 ms-2">Berita Pengumuman</h6>
                </div>
               
              </div>
              <div class="card-body ms-2 px-0 pt-0 pb-2 mb-3" style="overflow-y: scroll">
                <div class="card-body ps-2 pe-3 pt-0" >
                  <ul class="list-group p-2" style="overflow-y: auto;max-height: 260px;" v-for="(data) in pengumuman" :key="data.id">
                  <li
                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-0 border-radius-md bg-white text-dark" style="box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;"
                  >
                    <div class="d-flex align-items-center ms-3">
                      <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark text-sm">{{data.judul}} ({{data.tanggal_pengumuman}})</h6>
                        <span class="text-xs text-secondary me-1" style=" text-overflow: ellipsis;--max-lines: 1; display: -webkit-box; overflow: hidden; -webkit-box-orient: vertical;-webkit-line-clamp: var(--max-lines);"><i>{{data.isi}}</i></span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center text-secondary text-xs">
                      <span @click="detailpengumuman(data.id)" class="text-xs text-primary fw-bold" style="cursor:pointer">Detail</span>
                    </div>
                  </li>
                </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade text-white" id="pengumumandetail" aria-labelledby="pengumumandetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content bg-white">
      <div class="modal-header border-bottom-0" v-for="(data) in detpengumuman" :key="data.id">
        <b class="modal-title text-dark" id="pengumumandetailLabel" >Detail Pengumuman Tanggal</b>
        <b class="modal-title ms-2 text-dark">{{data.tanggal_pengumuman}}</b>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" v-for="(data) in detpengumuman" :key="data.id">
        <b class="text-dark">{{data.judul}}</b>
        <h6 class="text-dark me-1">{{data.isi}}</h6>
      </div>
      <div class="modal-footer border-top-0">
        <button type="button" class="btn btn-primary text-white" data-bs-dismiss="modal">Tutup</button>
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
      absenpegawai: null,
      pengumuman: [],
      detpengumuman: [],
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
    convertToRupiah(value) {
            // value = value.toString()
            value = parseFloat(value)
            let rupiah = ''
            let valueRev = value.toString().split('').reverse().join('')
            for (let i = 0; i < valueRev.length; i++) {
                if (i % 3 === 0) rupiah += `${valueRev.substr(i, 3)}.`
            }

            const rp = rupiah
                .split('', rupiah.length - 1)
                .reverse()
                .join('')
            // console.log('rupiah', isNaN(rp), rupiah.length, rp, rupiah)
            if (rupiah === 'NaN.' || rupiah === 'NaN') {
                return '...'
            }
            return `Rp ${rp}`
        },
       
    dashpeg(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/dashboardpeg',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.stats.money.value = response.data.totaljob;
                    this.stats.users.value = response.data.complete;
                    this.stats.sales.value = response.data.totalgaji
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    getpengumuman(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/getpengumumanpeg',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.pengumuman = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    detailpengumuman(id){
      $('#pengumumandetail').modal('show')
            this.$axios.get('/api/detailpengumuman/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detpengumuman = response.data.data
            })
    },  
    loadgrafik(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/grafikpegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.absenpegawai = response.data;
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
    this.loadgrafik()
    this.aktivitas()
    this.getpengumuman()
    this.dashpeg()
  }
};
</script>
<style></style>
