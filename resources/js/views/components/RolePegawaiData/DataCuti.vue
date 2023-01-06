<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Pengajuan Cuti</h6>
        </div>
        <div class="col-6 text-end" >
          <argon-button color="primary" @click="showModal()" size="sm" variant="gradient">Ajukan Cuti</argon-button>
        </div>
      </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="search" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Laporan..." >
          </div>
        </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div class="table-responsive p-0 border-bottom">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jenis Cuti</th>
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
            <tr v-for="(data,index) in cuti.data" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.jenis_cuti}}</span>
              </td>
              <td class="align-middle text-sm">
                <span style="cursor:pointer" class="text-primary text-xs"><i class="fa-solid fa-file"></i><a class="text-primary" :href="`files/${data.bukti_cuti}`"  target="_blank"> Document</a></span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal_cuti}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-success" v-if="data.status_cuti == 'Diterima'" >{{data.status_cuti}}</span>
                <span class="badge badge-sm bg-danger" v-else-if="data.status_cuti == 'Ditolak'" >{{data.status_cuti}}</span>
                <span class="badge badge-sm bg-secondary text-white" v-else-if="data.status_cuti == 'Diproses'" >{{data.status_cuti}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span v-if="data.status_cuti == 'Diproses'">
                  <span  @click.prevent="detailcuti(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-primary ms-0"><i class="far fa-eye"></i></span>
                  <span @click.prevent="showModalEdit(data)" style="cursor:pointer; margin-right: 7px;" class="badge badge-sm bg-warning disabled"><i class="fas fa-edit"></i></span>
                  <span  @click.prevent="hapuscuti(data.id)" style="cursor:pointer" class="badge badge-sm bg-danger"><i class="far fa-trash-alt"></i></span>
                </span>
                <span v-else-if="data.status_cuti != 'Diproses'">
                  <span  @click.prevent="detailcuti(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-primary ms-0"><i class="far fa-eye"></i></span>
                  <span style="cursor:not-allowed; margin-right: 7px;" class="badge badge-sm bg-warning disabled"><i class="fas fa-edit"></i></span>
                  <span style="cursor:not-allowed" class="badge badge-sm bg-danger"><i class="far fa-trash-alt"></i></span>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mb-1">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="cuti" @pagination-change-page="tampilcuti" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="cuti" aria-labelledby="cutiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="cutiLabel" v-show="!statusmodal">Buat Laporan</h5>
        <h5 class="modal-title" id="cutiLabel" v-show="statusmodal">Update Laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal ? updatecuti() : buatcuti()">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai Cuti</label>
                        <input type="date" v-model="form.tanggal_mulai" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai Cuti</label>
                        <input type="date" v-model="form.tanggal_akhir" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Cuti</label>
                        <input type="text" v-model="form.jenis_cuti" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea type="text" v-model="form.keterangan" placeholder="" class="form-control form-control-md"></textarea>
                    </div>
                    <div class="mb-3" v-show="statusmodal">
                        <label class="form-label">Lampiran</label>
                        <input type="file" @change="upload" class="form-control form-control-md">
                        <a class="text-xs ms-1">File Sebelumnya : </a><i class="fa-solid fa-file text-xs text-primary"></i><a class="text-xs ms-1 text-primary" :href="`files/${form.bukti_cuti}`"  target="_blank">{{form.bukti_cuti}}</a>
                    </div>
                    <div class="mb-3" v-show="!statusmodal">
                        <label class="form-label">Lampiran</label>
                        <input type="file" @change="upload" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal"  @click="updatecuti()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal"  @click="buatcuti()" class="btn btn-primary" type="submit" >Buat Pengajuan</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="detail" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="detailLabel">Detail Pengajuan Cuti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form v-for="(data) in detcuti" :key="data.id">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div type="text" placeholder="" class="form-control form-control-md">{{data.email}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pengajuan</label>
                        <div type="date" placeholder="" class="form-control form-control-md">{{data.tanggal_cuti}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai Cuti</label>
                        <div type="date" placeholder="" class="form-control form-control-md">{{data.tanggal_mulai}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai Cuti</label>
                        <div type="date" placeholder="" class="form-control form-control-md">{{data.tanggal_akhir}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Hari</label>
                        <div type="number" placeholder="" class="form-control form-control-md">{{data.jumlah_hari}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Cuti</label>
                        <div type="text" placeholder="" class="form-control form-control-md">{{data.jenis_cuti}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea type="text" disabled placeholder="" v-model="data.keterangan" class="form-control form-control-md bg-white"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lampiran</label>
                        <div class="form-control form-control-md"><a class="text-primary" :href="`files/${data.bukti_cuti}`"  target="_blank"> {{data.bukti_cuti}}</a></div>
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
            cuti:[],
            detcuti:[],
            jabatan:[],
			      search:'',
            form: new Form ({
              id : "",
              tanggal_cuti : "",
              tanggal_mulai : "",
              tanggal_akhir : "",
              jenis_cuti : "",
              keterangan : "",
              bukti_cuti:"",
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
            $("#cuti").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#cuti").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#cuti").modal("hide");
        },
        closeDetail() {
            this.form.reset();
            $("#detailcuti").modal("hide");
        },
        buatcuti(){
				 const formData = new FormData()
				formData.set('bukti_cuti', this.form.bukti_cuti)
				this.form.post('/api/tambahcuti', 
				{
					headers : { Authorization: "Bearer " + this.token },
				},formData,
				).then((response) => {
					if (response.data.success == true){
						const toast = useToast();
                  toast.success("Berhasil Mengajukan Cuti", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						this.form.reset();
						$('#cuti').modal('hide')
						this.tampilcuti()
					}
          if (response.data.success == null){
						const toast = useToast();
                  toast.error("Pengajuan Gagal, Jumlah Hari Lebih Dari Jatah Cuti", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						this.form.reset();
						$('#cuti').modal('hide')
						this.tampilcuti()
					}
          if (response.data.success == 15){
            console.log(response.data.status)
						const toast = useToast();
                  toast.error("Belum Bisa Mengajukan, Menunggu Pengajuan Sebelumnya", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
					}
          if (response.data.success == 12){
            console.log(response.data.status)
						const toast = useToast();
                  toast.error("Tidak Bisa Mengajukan, Anda Memiliki Cuti Yang Sedang Berjalan", {
                  position: "top-center",
                  timeout: 2500,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
					}
          if (response.data.success == false){
						const toast = useToast();
                  toast.error("Pengajuan Gagal, Jatah Cuti Tahun Ini Telah Habis", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						this.form.reset();
						$('#cuti').modal('hide')
						this.tampilcuti()
					}
						
						}
					)
			},
			updatecuti(){
				const formData = new FormData()
				formData.set('bukti_cuti', this.form.bukti_cuti)
				this.form.post('/api/updatecuti', 
				{
					headers : { Authorization: "Bearer " + this.token },
				},
				{
             id: this.form.id,
					   tanggal_cuti: this.form.tanggal_cuti,
					   tanggal_mulai: this.form.tanggal_mulai,
					   jenis_cuti: this.form.jenis_cuti,
					   tanggal_akhir: this.form.tanggal_akhir,
					   keterangan: this.form.keterangan,
					   bukti_cuti: this.form.bukti_cuti
					
				},formData,
				).then((response) => {
					if (response.data.success){
						const toast = useToast();
                  toast.success("Berhasil Update Cuti", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						this.form.reset();
						$('#cuti').modal('hide')
						this.tampilcuti()
					}
						
						}
					)
			},
			hapuscuti(id){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
				const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-danger',
              cancelButton: 'btn btn-secondary ms-2',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Hapus Cuti ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
          }).then((result) => {
					 if (result.isConfirmed) {
					 this.$axios.delete('/api/hapuscuti/'+id,  {
					headers: { Authorization: "Bearer " + this.token },
					},
					)
          const toast = useToast();
                  toast.success("Berhasil Menghapus Cuti", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
						};
						this.tampilcuti()
	
				},
	
				)
	
				})	
	
			},
        // Konfirmasi Status
        detailcuti(id){
            $('#detail').modal('show')
            this.$axios.get('/api/detailcuti/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detcuti = response.data.data
            })
        },
        // Menampilkan Semua Tabel
        tampilcuti(page = 1){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilcutip?page=' +page,{
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
		    searchcuti(val) {
            if (val == "")
            {
                this.tampilcuti()
            }else {
                this.$axios
                    .get('/api/searchcutipeg/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.cuti = response.data;
                    });
            }
        },
        upload(e){
				let files = e.target.files[0]
				this.preview = URL.createObjectURL(files)
				this.form.bukti_cuti = files

        },
        uploadupdate(e){
          let files = e.target.files[0]
          this.preview = URL.createObjectURL(files)
          this.form.bukti_cuti = files
          
        },
        onChange(e) {
            this.file = e.target.files[0];
        },
    },
    watch: {
        search: function ()
          {
              this.searchcuti(this.search)
          }
        },
  mounted() {
    setNavPills();
    this.getpt();
	  this.tampilcuti();
    this.getJabatan();
  }
};
</script>
