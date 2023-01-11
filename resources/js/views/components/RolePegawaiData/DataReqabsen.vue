<template>
  <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Pengajuan Request Attendance</h6>
        </div>
        <div class="col-6 text-end" >
          <argon-button color="primary" @click="showModal()" size="sm" variant="gradient">Ajukan Request</argon-button>
        </div>
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
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div v-if="this.reqabsen.data == ''" class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Alasan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Surat/Bukti Pendukung</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal Request</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
        </table>
        <p class="text-center text-secondary text-xl font-weight-bold mt-9" style="font-size:23px">Data Kosong</p>
      </div>
      <div v-else-if="this.reqabsen.data != ''" class="table-responsive p-0 border-bottom">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Alasan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Surat/Bukti Pendukung</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal Request</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in reqabsen.data" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.alasan}}</span>
              </td>
              <td class="align-middle text-sm">
                <span style="cursor:pointer" class="text-primary text-xs"><i class="fa-solid fa-file"></i><a class="text-primary" :href="`files/${data.bukti_pendukung}`"  target="_blank"> Document</a></span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal_req}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-success" v-if="data.status_req == 'Diterima'" >{{data.status_req}}</span>
                <span class="badge badge-sm bg-danger" v-else-if="data.status_req == 'Ditolak'" >{{data.status_req}}</span>
                <span class="badge badge-sm bg-secondary text-white" v-else-if="data.status_req == 'Diproses'" >{{data.status_req}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <div class="text-md" v-if="data.status_req == 'Diproses'">
                  <span @click.prevent="showModalEdit(data)" style="cursor:pointer; margin-right: 7px;" class="badge badge-sm bg-warning text-md"><i class="fas fa-edit"></i></span>
                   <span  @click.prevent="hapusreqabsen(data.id)" style="cursor:pointer" class="badge badge-sm bg-danger text-md"><i class="far fa-trash-alt"></i></span>
                </div>
                <div class="text-sm" v-if="data.status_req !== 'Diproses'">
                  <span style="cursor:not-allowed; margin-right: 7px;" class="badge badge-sm bg-secondary text-md"><i class="fas fa-edit"></i></span>
                   <span style="cursor:not-allowed" class="badge badge-sm bg-secondary text-md"><i class="far fa-trash-alt"></i></span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mb-1">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="reqabsen" @pagination-change-page="tampilreqabsen" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="reqabsen" aria-labelledby="reqabsenLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="reqabsenLabel" v-show="!statusmodal">Request Attendance</h5>
        <h5 class="modal-title" id="reqabsenLabel" v-show="statusmodal">Update Ajuan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal ? updatereq() : buatreq()">
                    <div class="mb-3">
                        <label class="form-label">Pilih tanggal tidak presensi</label>
                        <select class="form-select" v-model="form.tanggal_req">
                          <option disabled selected>Pilih Tanggal</option>
                          <option v-for="data in listreq" :key="data.id" :selected="null == form.tanggal_req ? selected : null" :value="data.tanggal">{{data.tanggal}}</option>
                        </select>
                        <!-- <label class="form-label">Tanggal</label>
                        <input type="date" v-model="form.tanggal_req" placeholder="" class="form-control form-control-md"> -->
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan</label>
                        <input type="text" v-model="form.alasan" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3" v-show="statusmodal">
                        <label class="form-label">Surat atau Bukti Pendukung</label>
                        <input type="file" @change="upload" class="form-control form-control-md">
                        <a class="text-xs ms-1">File Sebelumnya : </a><i class="fa-solid fa-file text-xs text-primary"></i><a class="text-xs ms-1 text-primary" :href="`files/${form.bukti_pendukung}`"  target="_blank">{{form.bukti_pendukung}}</a>
                    </div>
                    <div class="mb-3" v-show="!statusmodal">
                        <label class="form-label">Surat Atau Bukti Pendukung</label>
                        <input type="file" @change="upload" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal"  @click="updatereq()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal"  @click="buatreq()" class="btn btn-primary" type="submit" >Buat Pengajuan</button>
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
  name: "data-izin",
  data() {
        return {
            statusmodal:false,
            infopt:[],
            reqabsen:[],
            jabatan:[],
			      search:'',
            listreq:[],
            form: new Form ({
              id: "",
              alasan: "",
              bukti_pendukung:"",
              tanggal_req:"",
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    methods:{
        // Modal 
        showModal() {
            this.statusmodal = false;
            this.form.reset();
            $("#reqabsen").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#reqabsen").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#reqabsen").modal("hide");
        },
        list(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/newreq',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.listreq = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        buatreq(){
				 const formData = new FormData()
				formData.set('bukti_pendukung', this.form.bukti_pendukung)
				this.form.post('/api/ajukanreqabsen', 
				{
					headers : { Authorization: "Bearer " + this.token },
				},formData,
				).then((response) => {
					if (response.data.success){
						const toast = useToast();
                  toast.success("Berhasil Mengajukan Request Attendance", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						this.form.reset();
						$('#reqabsen').modal('hide')
						this.tampilreqabsen()
					}
						
						}
					)
			},
			updatereq(){
				const formData = new FormData()
				formData.set('bukti_pendukung', this.form.bukti_pendukung)
				this.form.post('/api/updatereqabsen', 
				{
					headers : { Authorization: "Bearer " + this.token },
				},
				{
          id: this.form.id,
					alasan: this.form.alasan,
					tanggal_req: this.form.tanggal_req,
					bukti_pendukung: this.form.bukti_pendukung
					
				},formData,
				).then((response) => {
					if (response.data.success){
						const toast = useToast();
                  toast.success("Berhasil Update Request Attendance", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						this.form.reset();
						$('#reqabsen').modal('hide')
						this.tampilreqabsen()
					}
						
						}
					)
			},
			hapusreqabsen(id){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
				const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-danger',
              cancelButton: 'btn btn-secondary ms-2',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Hapus Request Attendance ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
          }).then((result) => {
					 if (result.isConfirmed) {
					 this.$axios.delete('/api/hapusreqabsen/'+id,  {
					headers: { Authorization: "Bearer " + this.token },
					},
					)
          const toast = useToast();
                  toast.success("Berhasil Menghapus Request Attendance", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						};
						this.tampilreqabsen()
	
				},
	
				)
	
				})	
	
			},
        // Menampilkan Semua Tabel
        tampilreqabsen(page = 1){
          this.$axios.get('/sanctum/csrf-cookie').then(response => {
			   this.$axios.get('/api/allreqpegawai?page=' + page,{
				   headers: {Authorization: "Bearer " + this.token},
			   })
				   .then(response => {
					   this.reqabsen = response.data.data;
				   })
				   .catch(function (error) {
					   console.error(error);
				   });
		   })
		},
        // Menampilkan Tabel Untuk Jabatan
        getJabatan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/jabatanpegawai',{
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
		    searchreqabsen(val) {
            if (val == "")
            {
                this.tampilreqabsen()
            }else {
                this.$axios
                    .get('/api/searchreqabsenpeg/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.reqabsen = response.data;
                    });
            }
        },
        upload(e){
				let files = e.target.files[0]
				this.preview = URL.createObjectURL(files)
				this.form.bukti_pendukung = files

        },
        uploadupdate(e){
          let files = e.target.files[0]
          this.preview = URL.createObjectURL(files)
          this.form.bukti_pendukung = files
          
        },
        onChange(e) {
            this.file = e.target.files[0];
        },
    },
    watch: {
        search: function ()
          {
              this.searchreqabsen(this.search)
          }
        },
  mounted() {
    setNavPills();
    this.getpt();
	  this.tampilreqabsen();
    this.getJabatan();
    this.list();
  }
};
</script>
