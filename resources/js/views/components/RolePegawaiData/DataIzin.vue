<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Pengajuan Izin</h6>
        </div>
        <div class="col-6 text-end" >
          <argon-button color="primary" @click="showModal()" size="sm" variant="gradient">Buat Izin</argon-button>
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
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jenis Izin</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Surat Izin</th>
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
            <tr v-for="(data,index) in izin.data" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.jenis_izin}}</span>
              </td>
              <td class="align-middle text-sm">
                <span style="cursor:pointer" class="text-primary text-xs"><i class="fa-solid fa-file"></i><a class="text-primary" :href="`files/${data.bukti}`"  target="_blank"> Document</a></span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-success" v-if="data.status_izin == 'Diterima'" >{{data.status_izin}}</span>
                <span class="badge badge-sm bg-danger" v-else-if="data.status_izin == 'Ditolak'" >{{data.status_izin}}</span>
                <span class="badge badge-sm bg-info text-white" v-else-if="data.status_izin == 'Diproses'" >Belum Disetujui</span>
              </td>
              <td class="align-middle text-center">
                <div class="text-md" v-if="data.status_izin == 'Diproses'">
                  <span @click.prevent="showModalEdit(data)" style="cursor:pointer; margin-right: 7px;" class="badge badge-sm bg-gradient-success text-md"><i class="fas fa-edit"></i></span>
                   <span  @click.prevent="hapusizin(data.id)" style="cursor:pointer" class="badge badge-sm bg-danger text-md"><i class="far fa-trash-alt"></i></span>
                </div>
                <div class="text-sm" v-if="data.status_izin !== 'Diproses'">
                  <span class="badge badge-sm bg-secondary">Confirmed</span>
                </div>
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
  <div class="modal fade" id="izin" aria-labelledby="izinLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="izinLabel" v-show="!statusmodal">Buat Izin</h5>
        <h5 class="modal-title" id="izinLabel" v-show="statusmodal">Update Izin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal ? updateizin() : buatizin()">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" v-model="form.tanggal" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Izin</label>
                        <input type="text" v-model="form.jenis_izin" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3" v-show="statusmodal">
                        <label class="form-label">Lampiran</label>
                        <input type="file" @change="upload" class="form-control form-control-md">
                        <a class="text-xs ms-1">File Sebelumnya : </a><i class="fa-solid fa-file text-xs text-primary"></i><a class="text-xs ms-1 text-primary" :href="`files/${form.bukti}`"  target="_blank">{{form.bukti}}</a>
                    </div>
                    <div class="mb-3" v-show="!statusmodal">
                        <label class="form-label">Lampiran</label>
                        <input type="file" @change="upload" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal"  @click="updateizin()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal"  @click="buatizin()" class="btn btn-primary" type="submit" >Buat Izin</button>
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
            izin:[],
            jabatan:[],
			      search:'',
            form: new Form ({
              id: "",	
              jenis_izin : "",
              tanggal : "",
              bukti : "",
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
            $("#izin").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#izin").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#izin").modal("hide");
        },
        buatizin(){
				 const formData = new FormData()
				formData.set('bukti', this.form.bukti)
				this.form.post('/api/ajukanizin', 
				{
					headers : { Authorization: "Bearer " + this.token },
				},formData,
				).then((response) => {
					if (response.data.success){
						const toast = useToast();
                  toast.success("Berhasil Mengajukan Izin", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						this.form.reset();
						$('#izin').modal('hide')
						this.allizin()
					}
						
						}
					)
			},
			updateizin(){
				const formData = new FormData()
				formData.set('bukti', this.form.bukti)
				this.form.post('/api/updateizin', 
				{
					headers : { Authorization: "Bearer " + this.token },
				},
				{
             id: this.form.id,
					   jenis_izin: this.form.jenis_izin,
					   tanggal: this.form.tanggal,
					   bukti: this.form.bukti,
					
				},formData,
				).then((response) => {
					if (response.data.success){
						const toast = useToast();
                  toast.success("Berhasil Update Izin", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						this.form.reset();
						$('#izin').modal('hide')
						this.allizin()
					}
						
						}
					)
			},
			hapusizin(id){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
				const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-danger',
              cancelButton: 'btn btn-secondary ms-2',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Hapus Izin ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
          }).then((result) => {
					 if (result.isConfirmed) {
					 this.$axios.delete('/api/hapusizin/'+id,  {
					headers: { Authorization: "Bearer " + this.token },
					},
					)
          const toast = useToast();
                  toast.success("Berhasil Menghapus Izin", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						};
						this.allizin()
	
				},
	
				)
	
				})	
	
			},
        // Menampilkan Semua Tabel
        allizin(page = 1){
          this.$axios.get('/sanctum/csrf-cookie').then(response => {
			   this.$axios.get('/api/allizinpegawai?page=' + page,{
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
		    searchizin(val) {
            if (val == "")
            {
                this.allizin()
            }else {
                this.$axios
                    .get('/api/searchizinpeg/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.izin = response.data;
                    });
            }
        },
        upload(e){
				let files = e.target.files[0]
				this.preview = URL.createObjectURL(files)
				this.form.bukti = files

        },
        uploadupdate(e){
          let files = e.target.files[0]
          this.preview = URL.createObjectURL(files)
          this.form.lampiran = files
          
        },
        onChange(e) {
            this.file = e.target.files[0];
        },
    },
    watch: {
        search: function ()
          {
              this.searchizin(this.search)
          }
        },
  mounted() {
    setNavPills();
    this.getpt();
	  this.allizin();
    this.getJabatan();
  }
};
</script>
