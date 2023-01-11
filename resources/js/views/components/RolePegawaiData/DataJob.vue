<template>
  <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Job/Task</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button color="primary" style="visibility:hidden" @click="showModal()" size="sm" variant="gradient">Buat Task</argon-button>
        </div>
        <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="search" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Pencarian..." >
          </div>
        </div>
      </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div v-if="this.job.data == ''" class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Job/Task</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Deadline</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Pengumpulan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Terkumpul</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Keterangan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
        </table>
        <p class="text-center text-secondary text-xl font-weight-bold mt-9" style="font-size:23px">Data Kosong</p>
      </div>
      <div v-else-if="this.job.data != ''" class="table-responsive p-0 border-bottom">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Job/Task</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Deadline</th>
              <th
                class="w-2 ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Pengumpulan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Terkumpul</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Keterangan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in job.data" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.judul_job}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.deadline}}</span>
              </td>
              <td class="align-middle">
                <a v-if="data.pengumpulan != null" class="text-primary text-xs font-weight-bold" :href="`files/${data.pengumpulan}`"  target="_blank">{{data.pengumpulan}}</a>
                <span v-else-if="data.pengumpulan == null" class="text-secondary text-xs font-weight-bold">Null</span>
              </td>
              <td class="align-middle">
                <span v-if="data.terkumpul != null" class="text-secondary text-xs font-weight-bold">{{data.terkumpul}}</span>
                <span v-else-if="data.terkumpul == null" class="text-secondary text-xs font-weight-bold">Null</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.status}}</span>
              </td>
              <td class="align-middle">
                <span v-if="data.keterangan != null" class="text-secondary text-xs font-weight-bold">{{data.keterangan}}</span>
                <span v-else-if="data.keterangan == null" class="text-secondary text-xs font-weight-bold">Null</span>
              </td>
              <td class="text-center text-sm align-middle" >
                <span v-if="data.status != 'Revisi'" @click.prevent="detailjob(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-primary ms-0"><i class="far fa-eye"></i></span>
                <span v-else-if="data.status == 'Revisi'" @click.prevent="detailjob(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-danger ms-0"><i class="far fa-eye"></i></span>
                <span v-if="data.status == 'In Progress' || data.status == 'Checking'" @click="showModalEdit(data)" style="cursor:pointer;" class="badge badge-sm bg-success disabled"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                <span v-else-if="data.status == 'Revisi'" @click="modalsubmit(data)" style="cursor:pointer;" class="badge badge-sm bg-danger disabled"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                <span v-else-if="data.status == 'Complete'" style="cursor:not-allowed;" class="badge badge-sm bg-secondary disabled"><i class="fa-solid fa-cloud-arrow-up"></i></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="job" @pagination-change-page="alljob" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="jobmodal" aria-labelledby="jobmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="jobmodalLabel">Submit Job</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form >
                    <div class="mb-3">
                        <label class="form-label">File/Berkas Pengumpulan</label>
                        <input type="file" @change="upload" placeholder="" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer"  >
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button  @click="submitjob()" class="btn btn-primary" type="submit" >Submit</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="jobrevisimodal" aria-labelledby="jobrevisimodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="jobrevisimodalLabel">Submit Revisi Job</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form >
                    <div class="mb-3">
                        <label class="form-label">File/Berkas Pengumpulan</label>
                        <input type="file" @change="uploadrevisi" placeholder="" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer"  >
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button  @click="submitrevisijob()" class="btn btn-primary" type="submit" >Submit Revisi</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="jobdetail" aria-labelledby="jobdetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="jobdetailLabel">Detail Laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form v-for="(data) in detjob" :key="data.id">
                    <div class="mb-3">
                        <label class="form-label">Job/Task</label>
                        <div type="date" placeholder="" class="form-control form-control-md">{{data.judul_job}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea type="text" disabled placeholder="" v-model="data.deskripsi" class="form-control form-control-md bg-white"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deadline</label>
                        <div type="date" placeholder="" class="form-control form-control-md">{{data.deadline}}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File/Berkas Pengumpulan</label>
                        <div v-if="data.pengumpulan != null" class="form-control form-control-md"><a class="text-primary" :href="`files/${data.pengumpulan}`"  target="_blank"> {{data.pengumpulan}}</a></div>
                        <div v-else-if="data.pengumpulan == null" class="form-control form-control-md"><a class="text-dark">Null</a></div>
                    </div>
                    <div class="mb-3" v-if="data.status == 'Revisi'" >
                        <label class="form-label">Revisi</label>
                        <textarea type="text" disabled placeholder="" v-model="data.revisi" class="form-control form-control-md bg-white border-danger"></textarea>
                    </div>
                    <div class="mb-3" v-else-if="data.status != 'Revisi'" style="display:none">
                        <label class="form-label">Revisi</label>
                        <textarea type="text" disabled placeholder="" v-model="data.revisi" class="form-control form-control-md bg-white border-danger"></textarea>
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
import ArgonAlert from "../tes/ArgonAlert.vue";
import ArgonPagination from "../tes/ArgonPagination.vue";
import LaravelVuePagination from 'laravel-vue-pagination';
import { useToast } from "vue-toastification";
export default {
  components: {
    ArgonButton,
    ArgonAlert,
    ArgonPagination,
    'Pagination': LaravelVuePagination
  },
  name: "data-job",
  data() {
        return {
            job:[],
            infopt:[],
            detjob:[],
            search: '',
            statusmodal: false,
            emailpeg:[],
            form : new Form({
                id : "",
                email_pegawai : "",
                judul_job : "",
                deskripsi: "",
                pengumpulan:"",
                deadline:""
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    created() {
        //  this.$axios.get('/sanctum/csrf-cookie').then(response => {
        //     this.$axios.get('/api/alljobpeg',{
        //         headers: {Authorization: "Bearer " + this.token},
        //     })
        //         .then(response => {
        //             this.job = response.data.data;
        //         })
        //         .catch(function (error) {
        //             console.error(error);
        //         });
        // })
    },
    methods:{
       upload(e){
				let files = e.target.files[0]
				this.preview = URL.createObjectURL(files)
				this.form.pengumpulan = files
        },
        uploadrevisi(e){
				let files = e.target.files[0]
				this.preview = URL.createObjectURL(files)
				this.form.pengumpulan = files
        },
        showModalEdit(data) {
            $("#jobmodal").modal("show");
            this.form.fill(data);
        },
       detailjob(id){
            $('#jobdetail').modal('show')
            this.$axios.get('/api/detailjob/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detjob = response.data.data
            })
        },
        modalsubmit(data){
          $("#jobrevisimodal").modal("show");
            this.form.fill(data);
        },
      getdataPegawai(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/sudahisi',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.emailpeg = response.data.data
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        searchjob(val) {
            if (val == "")
            {
                this.alljob()
            }else {
                this.$axios.get('/api/searchjobpeg/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.job = response.data;
                    });
            }
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
        showModal() {
            this.statusmodal = false;
            this.form.reset();
            $("#jobmodal").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#jobmodal").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#jobmodal").modal("hide");
        },

        buatjob() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.form.post('/api/buatjob', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                  const toast = useToast();
                  toast.success("Berhasil Membuat Task", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
                    this.form.reset();
                    $('#jobmodal').modal('hide')
                    this.alljob()
                }
                    
                    }
                )
                    })
        },
        submitjob(){
              const formData = new FormData()
              formData.set('pengumpulan', this.form.pengumpulan)
              this.form.post('/api/submitjob',
                {
                    headers: { Authorization: "Bearer " + this.token }
                },
                {
                    id: this.form.id,
                    pengumpulan: this.form.pengumpulan
                },formData,
               ).then((response) => {
                if (response.data.success){
                  const toast = useToast();
                  toast.success("Berhasil Submit Job/Task", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  })
                    this.form.reset();
                    $("#jobmodal").modal("hide");
                    this.alljob()
                }
            

           })
        },
        submitrevisijob(){
              const formData = new FormData()
              formData.set('pengumpulan', this.form.pengumpulan)
              this.form.post('/api/submitjob',
                {
                    headers: { Authorization: "Bearer " + this.token }
                },
                {
                    id: this.form.id,
                    pengumpulan: this.form.pengumpulan
                },formData,
               ).then((response) => {
                if (response.data.success){
                  const toast = useToast();
                  toast.success("Berhasil Submit Revisi Job/Task", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  })
                    this.form.reset();
                    $("#jobrevisimodal").modal("hide");
                    this.alljob()
                }
            

           })
        },
        hapusjob(id){
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
          const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-success',
              cancelButton: 'btn bg-gradient-danger',
            },
            buttonsStyling: false
          })
        custom.fire({
        title: 'Hapus Job/Task ?',
        text: "Anda tidak akan bisa mengembalikannya lagi!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '',
        showConfirmButton:true,
        confirmButtonText:'Hapus',
        cancelButtonText: 'Batal',
          }).then((result) => {
              if (result.isConfirmed) {
                  this.$axios.delete('/api/hapusjob/'+id, {headers: { Authorization: "Bearer " + this.token }})
                  .then((response) => {
                    if(response.data.success == true){
                      const toast = useToast();
                      toast.success("Berhasil Menghapus Job", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.alljob()  
                    };
                  })}
                
              }
            )
          })
        },
        alljob(page = 1){
          this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljobpeg?page=' + page,{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.job = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        allJabatan(page = 1){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/jabatanpaginate?page=' + page,{
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

        convertToRupiah(value) {
            // value = value.toString()
            value = parseFloat(value)
            let rupiah = ''
            let valueRev = value.toString().split('').reverse().join('')
            for (let i = 0; i < valueRev.length; i++) {
                if (i % 3 === 0) rupiah += `${valueRev.substr(i, 3)}.`
            }

            const rp = rupiah
                .split('', rupiah.length - 1)
                .reverse()
                .join('')
            // console.log('rupiah', isNaN(rp), rupiah.length, rp, rupiah)
            if (rupiah === 'NaN.' || rupiah === 'NaN') {
                return '...'
            }
            return `Rp ${rp}`
        },

    
        
    },
    watch: {
                search: function ()
                {
                    this.searchjob(this.search)
                }
        },
  mounted() {
    setNavPills();
    this.getpt();
    this.allJabatan();
    this.alljob()
    this.getdataPegawai()
  }
};
</script>
<style scoped>
.ellipsis {
            position: relative;
        }
.ellipsis:before {
            content: ' ';
            visibility: hidden;
        }
 .ellipsis span {
            position: absolute;
            left: 0;
            right: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
</style>
