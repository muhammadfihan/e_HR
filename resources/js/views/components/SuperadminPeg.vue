<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Approvement Request Hapus Akun Pegawai</h6>
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
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Perusahaan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Bidang Perusahaan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Akun Pegawai</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Alasan Pengajuan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in izin.data" :key="data.id">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{index+1}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.email}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.jenis_izin}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.tanggal}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span style="cursor:pointer" class="text-primary text-xs" :href="`files/${data.bukti}`"  target="_blank"><i class="fa-solid fa-file"></i> Document</span>
              </td>
              <td class="align-middle text-center text-sm ">
                <span class="badge badge-sm bg-primary" v-if="data.status_izin == 'Diproses'">Belum Disetujui</span>
                <span class="badge badge-sm bg-gradient-danger" v-if="data.status_izin == 'Ditolak'">Ditolak</span>
                <span class="badge badge-sm bg-gradient-success" v-if="data.status_izin == 'Diterima'">Diterima</span>
              </td>
              <td class="align-middle text-center text-sm" >
                <span v-if="data.status_izin == 'Diproses'">
                  <span style="margin-right:7px;cursor:pointer" class="badge badge-sm bg-warning" @click.prevent="approveizin(data.id)">approvement</span>
                </span>
                <span v-else-if="data.status_izin !== 'Diproses'">
                  <span style="margin-right:7px" class="badge badge-sm bg-secondary">Confirmed</span>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="izin" @pagination-change-page="allizin" />
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
  name: "superadmin-hapuspeg",
  data() {
      return {
          LaravelVuePagination:{
            'current_page': 1
          },
          search1: '',
          infopt:[],
          izin:[],
          form: new Form ({
            id : "",
            status_izin: "",
          }),
          token: localStorage.getItem("token"),
          role: localStorage.getItem('role'),
      }
    },
    methods:{
      approveizin(id){
          console.log(id)
          const custom = Swal.mixin({
            customClass: {
              cancelButton: 'btn btn-secondary ms-2',
              confirmButton: 'btn bg-gradient-success',
              denyButton: 'btn bg-gradient-danger',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Approvement Izin Pegawai ?',
            icon: 'warning',
            showDenyButton: true,
            showCancelButton:true,
            confirmButtonText: 'Approve',
            denyButtonText: 'Tolak',
            cancelButtonText: 'Nanti'
          }).then((result)=>{
            if(result.isConfirmed){
              this.$axios.post('/api/approveizin',
                 {
                     id: id,
                     status_izin: "Diterima"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Pengajuan Lembur Telah Diterima", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.allizin()  
                    }
                 })
            }
            if(result.isDenied){
              this.$axios.post('/api/approveizin',
                 {
                     id: id,
                     status_izin: "Ditolak"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Pengajuan Lembur Telah Ditolak", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.allizin()  
                    }
                 })
            }
          })
        },
        allizin(page = 1){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/allizin?page=' + page,{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.izin = response.data.data;
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
		  this.allizin();
    }
};
</script>
