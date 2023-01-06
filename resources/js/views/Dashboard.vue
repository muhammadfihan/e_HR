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
              <gradient-line-chart v-if="absensigrafik != null" :absensigrafik="absensigrafik" />
            </div>
          </div>
          <div class="col-lg-5">
            <carousel />
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card"  style="height:350px !important; ">
              <div class="p-3 pb-0 card-header">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-2 ms-2">User Login Activity</h6>
                </div>
              </div>
              <div class="card-body ms-2 px-0 pt-0 pb-2 mb-3" style="overflow-y: scroll">
                <div class="card-body ps-2 pe-3 pt-0" >
                  <div class="table-responsive">
                <table class="table align-items-center">
                  <tbody>
                    <tr v-for="(data) in activityuser" :key="data.id">
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{data.name}}</p>
                        <p class="text-xs text-secondary mb-0">{{data.email}}</p>
                      </td>
                      <td class="align-middle" >
                        <span class="text-secondary text-xs font-weight-bold">
                          <span v-for="jab in jabatan" :key="jab.id"><a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a></span>
                        </span>
                      </td>
                      <td class="align-middle text-left">
                        <span v-if="data.last_login != null " class="text-xs font-weight-bold text-primary">Last login at {{data.last_login}}</span>
                        <span v-else-if="data.last_login == null" class="text-secondary text-xs font-weight-bold">New Account</span>
                      </td>
                   </tr>
                  </tbody>
                </table>
              </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="card" style="height:350px !important; ">
              <div class="p-3 pb-0 card-header col-lg-12">
                <div class="d-flex justify-content-between">
                  <h6 class="mb-2 ms-2">Post Berita/Pengumuman</h6>
                  <button type="submit" class="btn btn-xs btn-outline-primary text-primary font-weight-bolder" @click="pengumumanmodal()"><i class="fa-solid fa-plus me-1"></i> Buat</button>
                </div>
               
              </div>
              <div class="card-body ms-2 px-0 pt-0 pb-2 mb-3" style="overflow-y: scroll">
                <div class="card-body ps-2 pe-3 pt-0" >
                  <ul class="list-group p-2" style="overflow-y: auto;max-height: 260px;" v-for="(data) in pengumuman" :key="data.id">
                  <li
                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-0 border-radius-md bg-white text-dark" style="box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; cursor: pointer;"
                  >
                    <div class="d-flex align-items-center ms-3">
                      <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark text-sm">{{data.judul}} ({{data.tanggal_pengumuman}})</h6>
                        <span class="text-xs text-secondary me-1" style=" text-overflow: ellipsis;--max-lines: 1; display: -webkit-box; overflow: hidden; -webkit-box-orient: vertical;-webkit-line-clamp: var(--max-lines);"><i>{{data.isi}}</i></span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center text-secondary text-xs">
                    <i @click="detailpengumuman(data.id)" class="far fa-eye me-2 text-primary"></i>
                    <i @click="pengumumanedit(data)" class="fas fa-edit me-2 text-primary"></i>
                    <i @click="hapuspengumuman(data.id)" class="far fa-trash-alt text-danger"></i>
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
  <div class="modal fade" id="pengumuman" aria-labelledby="pengumumanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="pengumumanLabel" v-show="!statusmodal">Post Pengumuman</h5>
        <h5 class="modal-title" id="pengumumanLabel" v-show="statusmodal">Update Pengumuman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal ? editpengumuman() : buatpengumuman()">
                    <div class="mb-3">
                        <label class="form-label">Buat Untuk Tanggal</label>
                        <input v-model="form.tanggal_pengumuman" type="date"  placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul Pengumuman</label>
                        <input v-model="form.judul" type="text" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea v-model="form.isi" type="text"  placeholder="" class="form-control form-control-md"></textarea>
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closemodal()" >Batal</button>
        <button v-show="statusmodal"  @click="editpengumuman()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal"  @click="buatpengumuman()" class="btn btn-primary" type="submit" >Buat Pengumuman</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade text-white" id="pengumumandetail" aria-labelledby="pengumumandetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content bg-white">
      <div class="modal-header border-bottom-0" v-for="(data) in detpengumuman" :key="data.id">
        <b class="modal-title text-dark" id="pengumumandetailLabel">Detail Pengumuman Tanggal</b>
        <b class="modal-title ms-2 text-dark">{{data.tanggal_pengumuman}}</b>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body " v-for="(data) in detpengumuman" :key="data.id">
        <b class="text-dark">{{data.judul}}</b>
        <h6 class="text-dark">{{data.isi}}</h6>
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
import GradientLineChart from "../examples/Charts/GradientLineChart.vue";
import Carousel from "./components/Carousel.vue";
import CategoriesCard from "./components/CategoriesCard.vue";
import {useToast} from 'vue-toastification'

import US from "../assets/img/icons/flags/US.png";
import DE from "../assets/img/icons/flags/DE.png";
import GB from "../assets/img/icons/flags/GB.png";
import BR from "../assets/img/icons/flags/BR.png";

export default {
  name: "dashboard-default",
  data() {
    return {
      statusmodal: false,
      absensigrafik: null,
      pengumuman: [],
      infopt:[],
      detpengumuman:[],
      activityuser:[],
      jabatan:[],
      token: localStorage.getItem("token"),
      role: localStorage.getItem('role'),
      form : new Form({
                id : "",
                judul: "",
                isi : "",
                tanggal_pengumuman : "",
            }),
      stats: {
        money: {
          title: "Jumlah Pegawai",
          value: "",
          percentage: "",
          iconClass: "ni ni-single-02",
          detail: "Total jumlah pegawai",
          iconBackground: "bg-gradient-primary",
        },
        users: {
          title: "Jabatan",
          value: "12",
          percentage: "",
          iconClass: "ni ni-single-02",
          iconBackground: "bg-gradient-success",
          detail: "Jumlah Jabatan",
        },
        sales: {
          title: "Akun Aktif",
          value: "",
          percentage: "",
          iconClass: "ni ni-single-02",
          iconBackground: "bg-gradient-warning",
          detail: "Jumlah akun aktif",
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
    this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/infopt',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.infopt = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
  },  
  methods:{
    closemodal(){
      this.form.reset()
      $('#pengumumandetail').modal('hide')
    },
    detailpengumuman(id){
      $('#pengumumandetail').modal('show')
            this.$axios.get('/api/detailpengumuman/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detpengumuman = response.data.data
            })
    },  
    pengumumanmodal() {
            this.statusmodal = false;
            $("#pengumuman").modal("show");
    },
    pengumumanedit(data) {
            this.statusmodal = true;
            this.form.fill(data)
            $("#pengumuman").modal("show");
    },
    hapuspengumuman(id){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
				const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-danger',
              cancelButton: 'btn btn-secondary ms-2',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Hapus Pengumuman ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
          }).then((result) => {
					 if (result.isConfirmed) {
					 this.$axios.delete('/api/hapuspengumuman/'+id,  {
					headers: { Authorization: "Bearer " + this.token },
					},
					)
          const toast = useToast();
                  toast.success("Berhasil Menghapus Pengumuman", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						};
						this.getpengumuman()
	
				},
	
				)
	
				})	
    },
    buatpengumuman(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.form.post('/api/buatpengumuman', {
          headers : { Authorization: "Bearer " + this.token },
      }).then((response) => {
        if (response.data.success){
            const toast = useToast();
                  toast.success("Berhasil Membuat Pengumuman", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
              this.form.reset();
              $('#pengumuman').modal('hide')
              this.getpengumuman()
          }
              
              }
          )
              })
    },
    editpengumuman(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.form.post('/api/editpengumuman', {
          headers : { Authorization: "Bearer " + this.token },
      }).then((response) => {
        if (response.data.success){
            const toast = useToast();
                  toast.success("Berhasil Mengupdate Pengumuman", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
              this.form.reset();
              $('#pengumuman').modal('hide')
              this.getpengumuman()
          }
              
              }
          )
              })
    },
    getpengumuman(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/getpengumuman',{
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
    getJabatan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljabatan2',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.jabatan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
    user(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/useractive',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.activityuser = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
    dashakunpegawai(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/dashakunpegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.stats.sales.value = response.data.aktif;
                    this.tidak = response.data.tidak;
                    this.stats.money.value = response.data.pegawai;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
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
  },
  mounted(){
    this.dashakunpegawai()
    this.loadgrafik()
    this.user()
    this.getJabatan()
    this.getpengumuman()
  }
};
</script>
<style></style>
