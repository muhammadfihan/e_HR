<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Management Akun Perusahaan</h6>
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
              >Bidang</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jabatan Admin</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >NPWP</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in superadmin.data" :key="data.id">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{index+1}}</span>
              </td>
              <td>
                <p class="text-xs font-weight-bold mb-0">{{data.nama_perusahaan}}</p>
                <p class="text-xs text-secondary mb-0">{{data.email}}</p>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.bidang}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.jabatan}}</span>
              </td>
              <td class="text-center align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.npwp}}</span>
              </td>
              <td class="align-middle text-center text-sm ">
                <span class="badge badge-sm bg-info" v-if="data.status == 'Pending'">Belum Disetujui</span>
                <span class="badge badge-sm bg-gradient-danger" v-if="data.status == 'Ditolak'" >Rejected</span>
                <span class="badge badge-sm bg-gradient-success" v-if="data.status == 'Diterima'">Aktif</span>
                <span class="badge badge-sm bg-warning" v-if="data.status == 'Nonaktif'">Nonaktif</span>
              </td>
              <td class="align-middle text-center text-sm" >
                  <span v-if="data.status == 'Pending'" style="margin-right:7px;cursor:pointer" class="badge badge-sm bg-primary" @click.prevent="approveakun(data.id)" >approvement</span>
                  <span v-if="data.status == 'Diterima'" style="cursor:pointer" class="badge badge-sm bg-warning" @click.prevent="manageakun(data.id)">Manage</span>
                  <span v-if="data.status == 'Ditolak'" style="cursor:pointer" class="badge badge-sm bg-info" @click.prevent="ubahstatus(data.id)">Ubah</span>
                  <span v-if="data.status == 'Nonaktif'" style="cursor:pointer" class="badge badge-sm bg-success" @click.prevent="aktifakun(data.id)">Aktifkan</span>
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
import setNavPills from "../../../assets/js/nav-pills.js";
import ArgonButton from "../../components/tes/ArgonButton.vue";
import LaravelVuePagination from 'laravel-vue-pagination';
import {useToast} from 'vue-toastification'
export default {
  components: {
    ArgonButton,
    'Pagination' : LaravelVuePagination
  },
  name: "superadmin-approve",
  data() {
      return {
          LaravelVuePagination:{
            'current_page': 1
          },
          superadmin:[],
          search1: '',
          infopt:[],
          izin:[],
          form: new Form ({
            id : "",
            status: "",
          }),
          token: localStorage.getItem("token"),
          role: localStorage.getItem('role'),
      }
    },
    methods:{
      aktifakun(id){
          console.log(id)
          const custom = Swal.mixin({
            customClass: {
              cancelButton: 'btn btn-secondary ms-2',
              confirmButton: 'btn bg-gradient-success',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Aktifkan Akun Perusahaan ?',
            icon: 'warning',
            showCancelButton:true,
            confirmButtonText: 'Aktifkan',
            cancelButtonText: 'Nanti'
          }).then((result)=>{
            if(result.isConfirmed){
              const toast = useToast();
                  toast.info("Mengirim Email ke Akun Perusahaan", {
                  position: "top-center",
                  timeout: 3500,
                  icon: "fa-solid fa-spinner"
              })
              this.$axios.post('/api/aktifakun',
                 {
                     id: id,
                     status: "Diterima"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Akun berhasil diaktifkan", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.allsuperadmin()  
                    }
                 })
            }
          })
        },
        ubahstatus(id){
          console.log(id)
          const custom = Swal.mixin({
            customClass: {
              cancelButton: 'btn btn-secondary ms-2',
              confirmButton: 'btn bg-gradient-success',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Ubah Status Approvement ?',
            icon: 'warning',
            showCancelButton:true,
            confirmButtonText: 'Approve',
            cancelButtonText: 'Nanti'
          }).then((result)=>{
            if(result.isConfirmed){
              const toast = useToast();
                  toast.info("Mengirim Email ke Akun Perusahaan", {
                  position: "top-center",
                  timeout: 3500,
                  icon: "fa-solid fa-spinner"
              })
              this.$axios.post('/api/approveakun',
                 {
                     id: id,
                     status: "Diterima"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Status ", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.allsuperadmin()  
                    }
                 })
            }
          })
        },
      approveakun(id){
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
            title: 'Approvement Akun Perusahaan ?',
            icon: 'warning',
            showDenyButton: true,
            showCancelButton:true,
            confirmButtonText: 'Approve',
            denyButtonText: 'Tolak',
            cancelButtonText: 'Nanti'
          }).then((result)=>{
            if(result.isConfirmed){
              const toast = useToast();
                  toast.info("Mengirim Email ke Akun Perusahaan", {
                  position: "top-center",
                  timeout: 3500,
                  icon: "fa-solid fa-spinner"
              })
              this.$axios.post('/api/approveakun',
                 {
                     id: id,
                     status: "Diterima"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Approvemen Akun Perusahaan Telah Diterima", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.allsuperadmin()  
                    }
                 })
            }
            if(result.isDenied){
              const toast = useToast();
                  toast.info("Mengirim Email ke Akun Perusahaan", {
                  position: "top-center",
                  timeout: 3500,
                  icon: "fa-solid fa-spinner"
              })
              this.$axios.post('/api/approveakun',
                 {
                     id: id,
                     status: "Ditolak"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Approvemen Akun Perusahaan Telah Ditolak", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.allsuperadmin()  
                    }
                 })
            }
          })
        },
        manageakun(id){
          const custom = Swal.mixin({
            customClass: {
              cancelButton: 'btn btn-secondary ms-2',
              confirmButton: 'btn bg-danger text-white',
              denyButton: 'btn bg-warning ms-2 text-white',
            },
            buttonsStyling: false
          })  
          custom.fire({
            title: 'Manage Akun Perusahaan ?',
            icon: 'warning',
            showDenyButton: true,
            showCancelButton:true,
            confirmButtonText: 'Nonaktifkan',
            denyButtonText: 'Hapus',
            cancelButtonText: 'Batal'
          }).then((result)=>{
            if(result.isConfirmed){
              const toast = useToast();
                  toast.info("Mengirim Email ke Akun Perusahaan", {
                  position: "top-center",
                  timeout: 3500,
                  icon: "fa-solid fa-spinner"
              })
              this.$axios.post('/api/updateakun',
                 {
                     id: id,
                     status: "Nonaktif"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Akun Perusahaan Telah Dinonaktifkan", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.allsuperadmin()  
                    }
                 })
            }
            if(result.isDenied){
              const toast = useToast();
                  toast.info("Mengirim Email ke Akun Perusahaan", {
                  position: "top-center",
                  timeout: 3500,
                  icon: "fa-solid fa-spinner"
              })
              this.$axios.delete('/api/hapusakun/'+id, {headers: { Authorization: "Bearer " + this.token }}).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Akun Perusahaan Telah Dihapus", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.allsuperadmin()  
                    }
                 })
            }
          })
        },
        allsuperadmin(page = 1){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/approvesuperadmin?page=' + page,{
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
      // this.getpt();
		  this.allsuperadmin();
    }
};
</script>
