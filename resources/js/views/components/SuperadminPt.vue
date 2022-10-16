<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Data Perusahaan Terdaftar</h6>
        </div>
        <div class="col-6 text-end" style="visibility:hidden">
          <argon-button color="success" size="sm" variant="gradient">
            <i class="fas fa-plus me-2" ></i>Tambah Jabatan</argon-button>
        </div>
      </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="search1" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari..." >
          </div>
      </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Akun Perusahaan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >NPWP</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jumlah Pegawai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Nama Perusahaan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Daftar Pegawai</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in superadmin.data" :key="data.id">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{index+1}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.email}}</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{data.npwp}}</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{data.jumlah_karyawan}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.nama_perusahaan}}</span>
              </td>
              <td class="align-middle text-center text-sm ">
                <span class="badge badge-sm bg-primary" style="cursor:pointer" @click="detpegadmin(data.id)">Detail</span>
              </td>
              <td class="align-middle text-center text-sm" >
                <span v-if="data.status == 'Pending'">
                  <span class="badge badge-sm bg-info" @click.prevent="approveizin(data.id)">Pending</span>
                </span>
                <span v-if="data.status == 'Diterima'">
                  <span class="badge badge-sm bg-success">Aktif</span>
                </span>
                <span v-else-if="data.status == 'Ditolak'">
                  <span class="badge badge-sm bg-danger">Rejected</span>
                </span>
                <span class="badge badge-sm bg-warning" v-if="data.status == 'Nonaktif'">Nonaktif</span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="superadmin" @pagination-change-page="allsuperadmin" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="detailpegawai" aria-labelledby="detailpegawaiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered-top modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <h5 class="modal-title" id="detailpegawaiLabel">Pegawai Terdaftar Di Perusahaan {{pt}}</h5>
          <h7 class="modal-title" id="detailpegawaiLabel">Jumlah akun pegawai : {{jmlh}}</h7>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Username</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Email</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jabatan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data, index) in detakun" :key="data.id">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.name}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.email}}</span>
              </td>
              <td class="align-middle" >
                <span class="text-secondary text-xs font-weight-bold">
                  <span v-for="jab in detjabatan" :key="jab.id"><a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a></span>
                </span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-gradient-success" v-if="data.status == 'Aktif'">{{data.status}}</span>
                <span class="badge badge-sm bg-gradient-danger" v-else-if="data.status == 'Tidak Aktif'">{{data.status}}</span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import setNavPills from "../../assets/js/nav-pills.js";
import ArgonButton from "../components/tes/ArgonButton.vue";
import LaravelVuePagination from 'laravel-vue-pagination';
import {useToast} from 'vue-toastification'
export default {
  components: {
    ArgonButton,
    'Pagination' : LaravelVuePagination
  },
  name: "superadmin-pt",
  data() {
      return {
          LaravelVuePagination:{
            'current_page': 1
          },
          search1: '',
          infopt:[],
          pt:[],
          jmlh:[],
          detakun:[],
          superadmin:[],
          form: new Form ({
            id : "",
            status_izin: "",
          }),
          token: localStorage.getItem("token"),
          role: localStorage.getItem('role'),
      }
    },
    methods:{
      allJabatan(){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljabatansuperadmin',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.detjabatan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        detpegadmin(id){
            $('#detailpegawai').modal('show')
            
            this.$axios.get('/api/pegperusahaan/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detakun = response.data.data
                this.pt = response.data.namapt
                this.jmlh = response.data.akunpeg
            })
        },
        allsuperadmin(page = 1){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilsuperadmin?page=' + page,{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.superadmin = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        getpt(){
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
        searchizin(val) {
            if (val == "")
            {
                this.allizin()
            }else {
                this.$axios
                    .get('/api/searchizin/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.izin = response.data;
                    });
            }
        },

    },
	watch: {
        search1: function ()
        {
            this.searchizin(this.search1)
        },
    },
    
 mounted () {
      setNavPills()
      this.getpt();
		  this.allsuperadmin();
      this.allJabatan()
    }
};
</script>
