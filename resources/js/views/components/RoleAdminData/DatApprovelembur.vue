<template>
  <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Approvement Lembur</h6>
        </div>
        <div class="col-6 text-end" style="visibility:hidden">
          <argon-button color="success" size="sm" variant="gradient">
            <i class="fas fa-plus me-2" ></i>Tambah Jabatan</argon-button>
        </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="search" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari..." >
          </div>
      </div>
      </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div v-if="this.lembur.data == ''" class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pegawai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal Lembur</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Mulai</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Selesai</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Surat Pengajuan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Approvement</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
        </table>
        <p class="text-center text-secondary text-xl font-weight-bold mt-9" style="font-size:23px">Data Kosong</p>
      </div>
      <div v-if="this.lembur.data != ''" class="table-responsive p-0 border-bottom">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pegawai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal Lembur</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Mulai</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Selesai</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Surat Pengajuan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in lembur.data" :key="data.id">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{index+1}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.email}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.tanggal_lembur}}</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{data.jammulai}}</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{data.jamselesai}}</span>
              </td>
              <td class="align-middle text-sm text-center">
                <span style="cursor:pointer" class="text-primary text-xs"><i class="fa-solid fa-file"></i><a class="text-primary" :href="`files/${data.buktilembur}`"  target="_blank"> Document</a></span>
              </td>
              <td class="align-middle text-center text-sm ">
                <span class="badge badge-sm bg-secondary" v-if="data.status_lembur == 'Diproses'">{{data.status_lembur}}</span>
                <span class="badge badge-sm bg-gradient-danger" v-if="data.status_lembur == 'Ditolak'">Ditolak</span>
                <span class="badge badge-sm bg-gradient-success" v-if="data.status_lembur == 'Diterima'">Diterima</span>
              </td>
              <td class="align-middle text-center text-sm" >
                <span @click.prevent="detailLembur(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-primary ms-0"><i class="far fa-eye"></i></span>
                <span  @click.prevent="approvelembur(data.id)" style="cursor:pointer; margin-right: 7px;" class="badge badge-sm bg-warning disabled"><i class="fas fa-edit"></i></span>
                <span style="cursor:pointer" class="badge badge-sm bg-danger"><i class="far fa-trash-alt"></i></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="lembur" @pagination-change-page="tampillembur" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="detaillembur" aria-labelledby="detaillemburLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detaillemburLabel">Detail Lembur Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form  v-for="(data) in detlembur" :key="data.id">
            <div class="mb-3">
                  <label class="form-label">Nama Lengkap</label>
                  <div class="form-control form-control-md" >{{data.nama_lengkap}}</div>
                  <label class="form-label">No Pegawai</label>
                  <div class="form-control form-control-md">{{data.no_pegawai}}</div>
                  <label class="form-label">Tanggal Lembur</label>
                  <div class="form-control form-control-md">{{data.tanggal_lembur}}</div>
                  <label class="form-label">Jam Mulai Lembur</label>
                  <div class="form-control form-control-md">{{data.jammulai}}</div>
                  <label class="form-label">Jam Selesai Lembur</label>
                  <div class="form-control form-control-md">{{data.jamselesai}}</div>
                  <label class="form-label">Aktifitas Lembur</label>
                  <textarea v-model="data.aktifitas" disabled class="form-control form-control-md bg-white" ></textarea>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import setNavPills from "../../../assets/js/nav-pills.js";
import ArgonButton from "../tes/ArgonButton.vue";
import LaravelVuePagination from 'laravel-vue-pagination';
import {useToast} from 'vue-toastification'
export default {
  components: {
    ArgonButton,
    'Pagination' : LaravelVuePagination
  },
  name: "dat-approvelembur",
  data() {
      return {
          LaravelVuePagination:{
            'current_page': 1
          },
          search: '',
          infopt:[],
          lembur:[],
          detlembur:[],
          form: new Form ({
            id : "",
            status_lembur: "",
          }),
          token: localStorage.getItem("token"),
          role: localStorage.getItem('role'),
      }
    },
    methods:{
      approvelembur(id){
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
            title: 'Approvement Lembur Pegawai ?',
            icon: 'warning',
            showDenyButton: true,
            showCancelButton:true,
            confirmButtonText: 'Approve',
            denyButtonText: 'Tolak',
            cancelButtonText: 'Nanti'
          }).then((result)=>{
            if(result.isConfirmed){
              this.$axios.post('/api/confirmlembur',
                 {
                     id: id,
                     status_lembur: "Diterima"
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
                      this.tampillembur()  
                    }
                 })
            }
            if(result.isDenied){
              this.$axios.post('/api/confirmlembur',
                 {
                     id: id,
                     status_lembur: "Ditolak"
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
                      this.tampillembur()  
                    }
                 })
            }
          })
        },
        detailLembur(id){
            $('#detaillembur').modal('show')
            this.$axios.get('/api/detaillembur/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detlembur = response.data.data
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
        searchlembur(val) {
            if (val == "")
            {
                this.tampillembur()
            }else {
               this.$axios.get('/api/searchlembur/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.lembur = response.data;
                    });
            }
        },
        confirmlembur(){
            axios.post('/api/confirmlembur',
                {
                    id: this.form.id,
                    status_lembur: this.form.status_lembur,
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Data Berhasil Diupdate",
                        showConfirmButton: false,
                        timer: 1600,
                    }),
                     $("#lembur").modal("hide");
                    this.tampillembur();
                }
            })
        },
        tampillembur(page = 1){
          this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/tampillembur?page=' + page,{
                    headers: {Authorization: "Bearer " + this.token},
                })
                    .then(response => {
                        this.lembur = response.data.data;
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })

		    },
        showLembur(data) {
            $("#lembur").modal("show");
            this.form.fill({
                id: data.id,
                status_lembur: data.status_lembur,
            })
        },
    },
	watch: {
        search: function ()
        {
            this.searchlembur(this.search)
        },
    },
    
 mounted () {
      setNavPills()
      this.getpt();
		  this.tampillembur();
    }
};
</script>
