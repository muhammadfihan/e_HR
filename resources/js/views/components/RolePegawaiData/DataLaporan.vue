<template>
  <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Tabel Laporan Pegawai</h6>
        </div>
        <div class="col-6 text-end" >
          <argon-button color="primary" @click="showModal()" size="sm" variant="gradient">Buat Laporan</argon-button>
        </div>
      </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="search" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Berdasarkan Tanggal/Keterangan..." >
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
              >Email</th>
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
              >Email</th>
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
                <span style="cursor:pointer" class="text-primary text-xs"><i class="fa-solid fa-file"></i><a class="text-primary" :href="`files/${data.lampiran}`"  target="_blank"> Document</a></span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal_laporan}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-success" v-if="data.status_laporan == 'Diterima'" >{{data.status_laporan}}</span>
                <span class="badge badge-sm bg-danger" v-else-if="data.status_laporan == 'Ditolak'" >{{data.status_laporan}}</span>
                <span class="badge badge-sm bg-secondary text-white" v-else-if="data.status_laporan == 'Diproses'" >{{data.status_laporaan}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span v-if="data.status_laporan == 'Diproses'">
                  <span  @click.prevent="detaillaporan(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-primary ms-0"><i class="far fa-eye"></i></span>
                  <span @click.prevent="showModalEdit(data)" style="cursor:pointer; margin-right: 7px;" class="badge badge-sm bg-warning disabled"><i class="fas fa-edit"></i></span>
                  <span @click.prevent="hapuslaporan(data.id)" style="cursor:pointer" class="badge badge-sm bg-danger"><i class="far fa-trash-alt"></i></span>
                </span>
                <span v-else-if="data.status_laporan != 'Diproses'">
                  <span  @click.prevent="detaillaporan(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-primary ms-0"><i class="far fa-eye"></i></span>
                  <span  style="cursor:not-allowed; margin-right: 7px;" class="badge badge-sm bg-secondary disabled"><i class="fas fa-edit"></i></span>
                  <span  style="cursor:not-allowed" class="badge badge-sm bg-secondary"><i class="far fa-trash-alt"></i></span>
                </span>
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
  <div class="modal fade" id="laporan" aria-labelledby="laporanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="laporanLabel" v-show="!statusmodal">Buat Laporan</h5>
        <h5 class="modal-title" id="laporanLabel" v-show="statusmodal">Update Laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal ? updatelaporan() : buatlaporan()">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" v-model="form.tanggal_laporan" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea type="text" v-model="form.deskripsi" placeholder="" class="form-control form-control-md"></textarea>
                    </div>
                    <div class="mb-3" v-show="statusmodal">
                        <label class="form-label">Lampiran</label>
                        <input type="file" @change="upload" class="form-control form-control-md">
                        <a class="text-xs ms-1">File Sebelumnya : </a><i class="fa-solid fa-file text-xs text-primary"></i><a class="text-xs ms-1 text-primary" :href="`files/${form.lampiran}`"  target="_blank">{{form.lampiran}}</a>
                    </div>
                    <div class="mb-3" v-show="!statusmodal">
                        <label class="form-label">Lampiran</label>
                        <input type="file" @change="upload" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal"  @click="updatelaporan()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal"  @click="buatlaporan()" class="btn btn-primary" type="submit" >Buat Pengajuan</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="detail" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="detailLabel">Detail Laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form v-for="(data) in detlaporan" :key="data.id">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
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
            statusmodal:false,
            infopt:[],
            laporan:[],
            detlaporan:[],
            jabatan:[],
			      search:'',
            form: new Form ({
              id : "",
              tanggal_laporan : "",
              deskripsi : "",
              lampiran : "",
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
            $("#laporan").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#laporan").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#laporan").modal("hide");
        },
        closeDetail() {
            this.form.reset();
            $("#detailLaporan").modal("hide");
        },
        buatlaporan(){
				 const formData = new FormData()
				formData.set('lampiran', this.form.lampiran)
				this.form.post('/api/tambahlaporan', 
				{
					headers : { Authorization: "Bearer " + this.token },
				},formData,
				).then((response) => {
					if (response.data.success){
						const toast = useToast();
                  toast.success("Berhasil Mengajukan Laporan", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						this.form.reset();
						$('#laporan').modal('hide')
						this.tampillaporan()
					}
						
						}
					)
			},
			updatelaporan(){
				const formData = new FormData()
				formData.set('lampiran', this.form.lampiran)
				this.form.post('/api/updatelaporan', 
				{
					headers : { Authorization: "Bearer " + this.token },
				},
				{
						id: this.form.id,
						tanggal_laporan: this.form.tanggal_laporan,
						deskripsi: this.form.deskripsi,
						lampiran: this.form.lampiran
					
				},formData,
				).then((response) => {
					if (response.data.success){
						const toast = useToast();
                  toast.success("Berhasil Update Laporan", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						this.form.reset();
						$('#laporan').modal('hide')
						this.tampillaporan()
					}
						
						}
					)
			},
			hapuslaporan(id){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
				const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-danger',
              cancelButton: 'btn btn-secondary ms-2',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Hapus Laporan ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
          }).then((result) => {
					 if (result.isConfirmed) {
					 this.$axios.delete('/api/hapuslaporan/'+id,  {
					headers: { Authorization: "Bearer " + this.token },
					},
					)
          const toast = useToast();
                  toast.success("Berhasil Menghapus Laporan", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						};
						this.tampillaporan()
	
				},
	
				)
	
				})	
	
			},
        // Konfirmasi Status
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
            this.$axios.get('/api/tampillaporanpegawai?page=' +page,{
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
		    searchlaporan(val) {
            if (val == "")
            {
                this.tampillaporan()
            }else {
                this.$axios
                    .get('/api/searchlaporanpeg/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.laporan = response.data;
                    });
            }
        },
        upload(e){
				let files = e.target.files[0]
				this.preview = URL.createObjectURL(files)
				this.form.lampiran = files

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
