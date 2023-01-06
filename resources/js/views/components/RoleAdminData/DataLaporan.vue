<template>
   <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Data Laporan</h6>
        </div>
        <div class="col-6 text-end" style="visibility:hidden">
          <argon-button color="success" size="sm" variant="gradient">Tambah Bonus</argon-button>
        </div>
        <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="search" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Pegawai..." >
          </div>
        </div>
      </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div v-if="this.laporan.data == ''" class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Email Pegawai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No Pegawai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jabatan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Lampiran</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal</th>
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
      <div v-else-if="this.laporan.data != ''" class="table-responsive p-0 border-bottom">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Email Pegawai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No Pegawai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jabatan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Lampiran</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in laporan.data" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.email}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.no_pegawai}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold" v-for="jab in jabatan" :key="jab.id">
                  <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                </span>
              </td>
              <td class="align-middle text-sm">
                <span style="cursor:pointer" class="text-primary text-xs" :href="`files/${data.lampiran}`"  target="_blank"><i class="fa-solid fa-file"></i> Document</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal_laporan}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-success" v-if="data.status_laporan == 'Diterima'" >{{data.status_laporan}}</span>
                <span class="badge badge-sm bg-danger" v-else-if="data.status_laporan == 'Ditolak'" >{{data.status_laporan}}</span>
                <span class="badge badge-sm bg-secondary text-white" v-else-if="data.status_laporan == 'Diproses'" >{{data.status_laporan}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span @click.prevent="detaillaporan(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-primary ms-0"><i class="far fa-eye"></i></span>
                <span  @click.prevent="confirmlaporan(data.id)" style="cursor:pointer; margin-right: 7px;" class="badge badge-sm bg-warning disabled"><i class="fas fa-edit"></i></span>
                <span style="cursor:pointer" class="badge badge-sm bg-danger"><i class="far fa-trash-alt"></i></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mb-1">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="laporan" @pagination-change-page="tampillaporan" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="detail" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="detailLabel">Detail Laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form v-for="(data) in detlaporan" :key="data.id">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <div type="text" placeholder="" class="form-control form-control-md">{{data.email}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <div type="date" placeholder="" class="form-control form-control-md">{{data.tanggal_laporan}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea type="text" disabled placeholder="" v-model="data.deskripsi" class="form-control form-control-md bg-white"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lampiran</label>
                        <div class="form-control form-control-md"><a class="text-primary" :href="`files/${data.lampiran}`"  target="_blank"> {{data.lampiran}}</a></div>
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
import ArgonBadge from "../tes/ArgonBadge.vue";
import ArgonButton from "../tes/ArgonButton.vue";
import LaravelVuePagination from 'laravel-vue-pagination';
import {useToast} from 'vue-toastification'

export default {
  components: {
    ArgonBadge,
    ArgonButton,
    'Pagination': LaravelVuePagination
  },
  name: "data-laporan",
  data() {
        return {
            infopt:[],
            laporan:[],
            detlaporan:[],
            jabatan:[],
			      search:'',
            form: new Form ({
               id : "",
               status_laporan: "",
			         deskripsi:""
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    methods:{
        // Modal 
        closeModal() {
            $("#laporan").modal("hide");
        },
        showModal(data) {
            $("#laporan").modal("show");
            this.form.fill({
                id: data.id,
                status_req: data.status_laporan,
            })
        },
        closeDetail() {
            this.form.reset();
            $("#detailLaporan").modal("hide");
        },
        // Konfirmasi Status
        confirmlaporan(id){
          console.log(id)
          const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-success',
              cancelButton: 'btn btn-secondary ms-2',
              denyButton: 'btn bg-gradient-danger',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Approvement Laporan Pegawai ?',
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Approve',
            denyButtonText: 'Tolak',
            cancelButtonText: 'Nanti'
          }).then((result)=>{
            if(result.isConfirmed){
              this.$axios.post('/api/confirmlaporan',
                 {
                     id: id,
                     status_laporan: "Diterima"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Laporan Telah Diterima", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.tampillaporan()  
                    }
                 })
            }
            if(result.isDenied){
              this.$axios.post('/api/confirmlaporan',
                 {
                     id: id,
                     status_laporan: "Ditolak"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Laporan Telah Ditolak", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.tampillaporan()  
                    }
                 })
            }
          })
        },
        detaillaporan(id){
            $('#detail').modal('show')
            this.$axios.get('/api/detaillaporan/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detlaporan = response.data.data
            })
        },
        // Menampilkan Semua Tabel
        tampillaporan(page = 1){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampillaporan?page=' +page,{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.laporan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
		},
        // Menampilkan Tabel Untuk Jabatan
        getJabatan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljabatan',{
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
		searchlaporan(val) {
            if (val == "")
            {
                this.tampillaporan()
            }else {
                this.$axios
                    .get('/api/searchlaporan/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.laporan = response.data;
                    });
            }
        },
    },
    watch: {
                search: function ()
                {
                    this.searchlaporan(this.search)
                }
        },
  mounted() {
    setNavPills();
    this.getpt();
	  this.tampillaporan();
    this.getJabatan();
  }
};
</script>
