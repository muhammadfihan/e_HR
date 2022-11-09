<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Pengajuan Lembur</h6>
        </div>
        <div class="col-6 text-end" >
          <argon-button color="primary" @click="showModal()" size="sm" variant="gradient">Buat Pengajuan</argon-button>
        </div>
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
              >Jam Mulai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Selesai</th>
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
            <tr v-for="(data,index) in lembur.data" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.jammulai}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.jamselesai}}</span>
              </td>
              <td class="align-middle text-sm">
                <span style="cursor:pointer" class="text-primary text-xs"><i class="fa-solid fa-file"></i><a class="text-primary" :href="`files/${data.buktilembur}`"  target="_blank"> Document</a></span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal_lembur}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-success" v-if="data.status_lembur == 'Diterima'" >{{data.status_lembur}}</span>
                <span class="badge badge-sm bg-danger" v-else-if="data.status_lembur == 'Ditolak'" >{{data.status_lembur}}</span>
                <span class="badge badge-sm bg-info text-white" v-else-if="data.status_lembur == 'Diproses'" >Belum Disetujui</span>
              </td>
              <td class="align-middle text-center text-md">
                <span  @click.prevent="detaillembur(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-primary ms-0"><i class="far fa-eye"></i></span>
                <span v-if="data.status_lembur == 'Diproses'" @click.prevent="showModalEdit(data)" style="cursor:pointer; margin-right: 7px;" class="badge badge-sm bg-gradient-success disabled"><i class="fas fa-edit"></i></span>
                <span v-if="data.status_lembur == 'Diproses'" @click.prevent="hapuslembur(data.id)" style="cursor:pointer" class="badge badge-sm bg-danger"><i class="far fa-trash-alt"></i></span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="lembur" @pagination-change-page="tampillembur" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="lembur" aria-labelledby="lemburLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="lemburLabel" v-show="!statusmodal">Buat Pengajuan</h5>
        <h5 class="modal-title" id="lemburLabel" v-show="statusmodal">Update Pengajuan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal ? updatelembur() : buatlembur()">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" v-model="form.tanggal_lembur" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" v-model="form.jammulai" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" v-model="form.jamselesai" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea type="text" v-model="form.aktifitas" placeholder="" class="form-control form-control-md"></textarea>
                    </div>
                    <div class="mb-3" v-show="statusmodal">
                        <label class="form-label">Lampiran</label>
                        <input type="file" @change="upload" class="form-control form-control-md">
                        <a class="text-xs ms-1">File Sebelumnya : </a><i class="fa-solid fa-file text-xs text-primary"></i><a class="text-xs ms-1 text-primary" :href="`files/${form.buktilembur}`"  target="_blank">{{form.buktilembur}}</a>
                    </div>
                    <div class="mb-3" v-show="!statusmodal">
                        <label class="form-label">Lampiran</label>
                        <input type="file" @change="upload" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal"  @click="updatelembur()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal"  @click="buatlembur()" class="btn btn-primary" type="submit" >Ajukan Lembur</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="detail" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="detailLabel">Detail Lembur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form v-for="(data) in detlembur" :key="data.id">
                    <div class="mb-3">
                        <label class="form-label">email</label>
                        <div type="text" placeholder="" class="form-control form-control-md">{{data.email}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <div type="date" placeholder="" class="form-control form-control-md">{{data.tanggal_lembur}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <div type="time" placeholder="" class="form-control form-control-md">{{data.jammulai}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Selesai</label>
                        <div type="time" placeholder="" class="form-control form-control-md">{{data.jamselesai}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kegiatan</label>
                        <textarea type="text" disabled placeholder="" v-model="data.aktifitas" class="form-control form-control-md bg-white"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lampiran</label>
                        <div class="form-control form-control-md"><a class="text-primary" :href="`files/${data.buktilembur}`"  target="_blank"> {{data.buktilembur}}</a></div>
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
            statusmodal:false,
            infopt:[],
            lembur:[],
            detlembur:[],
            jabatan:[],
			      search:'',
            form: new Form ({
              id : "",
              tanggal_lembur : "",
              jammulai : "",
              jamselesai : "",
              aktifitas : "",
              buktilembur: "",
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
            $("#lembur").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#lembur").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#lembur").modal("hide");
        },
        closeDetail() {
            this.form.reset();
            $("#detail").modal("hide");
        },
        buatlembur(){
				 const formData = new FormData()
				formData.set('lampiran', this.form.buktilembur)
				this.form.post('/api/tambahlembur', 
				{
					headers : { Authorization: "Bearer " + this.token },
				},formData,
				).then((response) => {
					if (response.data.success){
						const toast = useToast();
                  toast.success("Berhasil Mengajukan Lembur", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						this.form.reset();
						$('#lembur').modal('hide')
						this.tampillembur()
					}
						
						}
					)
			},
			updatelembur(){
				const formData = new FormData()
				formData.set('lampiran', this.form.buktilembur)
				this.form.post('/api/updatelembur', 
				{
					headers : { Authorization: "Bearer " + this.token },
				},
				{
             id: this.form.id,
					   tanggal_lembur: this.form.tanggal_lembur,
					   jammulai: this.form.jammulai,
					   jamselesai: this.form.jamselesai,
					   aktifitas: this.form.aktifitas,
					   buktilembur: this.form.buktilembur
					
				},formData,
				).then((response) => {
					if (response.data.success){
						const toast = useToast();
                  toast.success("Berhasil Update Lembur", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						this.form.reset();
						$('#lembur').modal('hide')
						this.tampillembur()
					}
						
						}
					)
			},
			hapuslembur(id){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
				const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-danger',
              cancelButton: 'btn btn-secondary ms-2',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Hapus Lembur ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
          }).then((result) => {
					 if (result.isConfirmed) {
					 this.$axios.delete('/api/hapuslembur/'+id,  {
					headers: { Authorization: "Bearer " + this.token },
					},
					)
          const toast = useToast();
                  toast.success("Berhasil Menghapus Lembur", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						};
						this.tampillembur()
	
				},
	
				)
	
				})	
	
			},
        // Konfirmasi Status
        detaillembur(id){
			   $('#detail').modal('show')
			   this.$axios.get('/api/detaillembur/'+id,{
				   headers: { Authorization: "Bearer " + this.token }
			   }).then((response) => {
				   this.detlembur = response.data.data
			   })
		   },
        // Menampilkan Semua Tabel
        tampillembur(page = 1){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampillemburpegawai?page=' +page,{
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
		    searchlembur(val) {
            if (val == "")
            {
                this.tampillembur()
            }else {
                this.$axios
                    .get('/api/searchlemburpeg/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.lembur = response.data;
                    });
            }
        },
        upload(e){
				let files = e.target.files[0]
				this.preview = URL.createObjectURL(files)
				this.form.buktilembur = files

        },
        uploadupdate(e){
          let files = e.target.files[0]
          this.preview = URL.createObjectURL(files)
          this.form.buktilembur = files
          
        },
        onChange(e) {
            this.file = e.target.files[0];
        },
    },
    watch: {
        search: function ()
          {
              this.searchlembur(this.search)
          }
        },
  mounted() {
    setNavPills();
    this.getpt();
	  this.tampillembur();
    this.getJabatan();
  }
};
</script>
