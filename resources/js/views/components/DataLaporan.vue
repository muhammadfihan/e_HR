<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Tabel Laporan Pegawai</h6>
        </div>
        <div class="col-6 text-end" style="visibility:hidden">
          <argon-button color="success" @click="showModal()" size="sm" variant="gradient">
            <i class="fas fa-plus me-2" ></i>Tambah Jabatan</argon-button>
        </div>
      </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Pegawai..." >
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
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Nama Pegawai</th>
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
                <span class="badge badge-sm bg-primary text-white" v-else-if="data.status_laporan == 'Diproses'" >Belum Disetujui</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span v-if="data.status_laporan == 'Diproses'" @click.prevent="confirmlaporan(data.id)" style="cursor:pointer" class="badge badge-sm bg-primary">Approvement</span>
                <span v-else-if="data.status_laporan == 'Diterima'" class="badge badge-sm bg-secondary">Confirmed</span>
                <span v-else-if="data.status_laporan == 'Ditolak'" class="badge badge-sm bg-secondary">Confirmed</span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="laporan" @pagination-change-page="tampillaporan" />
      </div>
    </div>
  </div>
</template>

<script>
import setNavPills from "../../assets/js/nav-pills.js";
import ArgonBadge from "../components/tes/ArgonBadge.vue";
import ArgonButton from "../components/tes/ArgonButton.vue";
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
        detailLaporan(id){
            $('#detailLaporan').modal('show')
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
                axios
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
