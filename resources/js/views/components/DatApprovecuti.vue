<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Approvement Cuti</h6>
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
            <input style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari..." >
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
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pegawai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Nama Lengkap</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No Pegawai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal Pengajuan</th>
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
            <tr v-for="(data,index) in cuti.data" :key="data.id">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{index+1}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.email}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.nama_lengkap}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.no_pegawai}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.tanggal_cuti}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span style="cursor:pointer" class="text-primary text-xs" :href="`files/${data.bukti_cuti}`"  target="_blank"><i class="fa-solid fa-file"></i> Document</span>
              </td>
              <td class="align-middle text-center text-sm ">
                <span class="badge badge-sm bg-primary" v-if="data.status_cuti == 'Diproses'">Belum Disetujui</span>
                <span class="badge badge-sm bg-gradient-danger" v-if="data.status_cuti == 'Ditolak'">Ditolak</span>
                <span class="badge badge-sm bg-gradient-success" v-if="data.status_cuti == 'Diterima'">Diterima</span>
              </td>
              <td class="align-middle text-center text-sm" >
                <span v-if="data.status_cuti == 'Diproses'">
                  <span style="margin-right:7px;cursor:pointer" class="badge badge-sm bg-warning" @click.prevent="approvecuti(data.id)">approvement</span>
                  <span style="cursor:pointer" class="badge badge-sm bg-primary" @click.prevent="detailCuti(data.id)">detail</span>
                </span>
                <span v-else-if="data.status_cuti !== 'Diproses'">
                  <span style="margin-right:7px" class="badge badge-sm bg-secondary" @click.prevent="detailCuti(data.id)">Confirmed</span>
                  <span style="cursor:pointer" class="badge badge-sm bg-primary" @click.prevent="detailCuti(data.id)">detail</span>
                </span>
                
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="cuti" @pagination-change-page="tampilcuti" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="detailcuti" aria-labelledby="detailcutiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailcutiLabel">Detail Cuti Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form  v-for="(data) in detcuti" :key="data.id">
            <div class="mb-3">
                  <label class="form-label">Nama Lengkap</label>
                  <div class="form-control form-control-md" >{{data.nama_lengkap}}</div>
                  <label class="form-label">No Pegawai</label>
                  <div class="form-control form-control-md">{{data.no_pegawai}}</div>
                  <label class="form-label">Tanggal Pengajuan</label>
                  <div class="form-control form-control-md">{{data.tanggal_cuti}}</div>
                  <label class="form-label">Tanggal Mulai Cuti</label>
                  <div class="form-control form-control-md">{{data.tanggal_mulai}}</div>
                  <label class="form-label">Tanggal Selesai Cuti</label>
                  <div class="form-control form-control-md">{{data.tanggal_akhir}}</div>
                  <label class="form-label">Jumlah Hari Cuti</label>
                  <div class="form-control form-control-md">{{data.jumlah_hari}}</div>
                  <label class="form-label">Jenis Cuti</label>
                  <div class="form-control form-control-md">{{data.jenis_cuti}}</div>
                  <label class="form-label">Keterangan</label>
                  <textarea v-model="data.keterangan" disabled class="form-control form-control-md bg-white" ></textarea>
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
import setNavPills from "../../assets/js/nav-pills.js";
import ArgonButton from "../components/tes/ArgonButton.vue";
import LaravelVuePagination from 'laravel-vue-pagination';
import {useToast} from 'vue-toastification'
export default {
  components: {
    ArgonButton,
    'Pagination' : LaravelVuePagination
  },
  name: "dat-approvecuti",
  data() {
      return {
          LaravelVuePagination:{
            'current_page': 1
          },
          search: '',
          infopt:[],
          cuti:[],
          detcuti:[],
          form: new Form ({
            id : "",
            status_cuti: "",
          }),
          token: localStorage.getItem("token"),
          role: localStorage.getItem('role'),
      }
    },
    methods:{
        approvecuti(id){
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
            title: 'Approvement Cuti Pegawai ?',
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Approve',
            denyButtonText: 'Tolak',
            cancelButtonText: 'Nanti'
          }).then((result)=>{
            if(result.isConfirmed){
              this.$axios.post('/api/confirmcuti',
                 {
                     id: id,
                     status_cuti: "Diterima"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Pengajuan Cuti Telah Diterima", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.tampilcuti()  
                    }
                 })
            }
            if(result.isDenied){
              this.$axios.post('/api/confirmcuti',
                 {
                     id: id,
                     status_cuti: "Ditolak"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Pengajuan Cuti Telah Ditolak", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.tampilcuti()  
                    }
                 })
            }
          })
        },
		    closeCuti() {
            $("#cuti").modal("hide");
        },
        showCuti(data) {
            $("#cuti").modal("show");
            this.form.fill({
                id: data.id,
                status_cuti: data.status_cuti,
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
		// CUTI
		tampilcuti(page = 1){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilcuti?page=' + page, {
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.cuti = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })

		},
		confirmcuti(){
            this.$axios.post('/api/confirmcuti',
                {
                    id: this.form.id,
                    status_cuti: this.form.status_cuti,
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
                     $("#cuti").modal("hide");
                    this.tampilcuti();
                }
            })
        },
		searchcuti(val) {
            if (val == "")
            {
                this.tampilcuti()
            }else {
                this.$axios
                    .get('/api/searchcuti/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.cuti = response.data;
                    });
            }
        },
        detailCuti(id){
            $('#detailcuti').modal('show')
            this.$axios.get('/api/detailcuti/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detcuti = response.data.data
            })
        },
		    closeDetailCuti() {
            this.form.reset();
            $("#detailcuti").modal("hide");
        },
    },
	watch: {
        search: function ()
        {
            this.searchcuti(this.search)
        },
    },
    
 mounted () {
      setNavPills()
      this.getpt();
		  this.tampilcuti();
    }
};
</script>
