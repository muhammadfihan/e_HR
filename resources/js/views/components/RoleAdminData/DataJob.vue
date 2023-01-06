<template>
  <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Job/Task Management</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button color="primary" @click="showModal()" size="sm" variant="gradient">Buat Task</argon-button>
        </div>
        <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Pencarian..." >
          </div>
        </div>
      </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div v-if="this.job == ''" class="table-responsive p-0">
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
      <div v-else-if="this.job != ''" class="table-responsive p-0 border-bottom">
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
              >Approvement</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in job" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.email_pegawai}}</span>
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
              <td class="text-center text-sm align-middle">
                <div v-if="data.status == 'Complete'">
                  <span class="badge badge-sm bg-secondary me-2" style="cursor:not-allowed">Terima</span>
                  <span class="badge badge-sm bg-secondary" style="cursor:not-allowed">Revisi</span>
                </div>
                <div v-else-if="data.status != 'Complete'">
                  <span @click="modalapprove(data)" class="badge badge-sm bg-success me-2" style="cursor:pointer">Terima</span>
                  <span @click="showrevisi(data)" class="badge badge-sm bg-warning" style="cursor:pointer">Revisi</span>
                </div>
              </td>
              <td class="text-center text-sm align-middle" >
                <div v-if="data.status == 'Complete'">
                  <span @click.prevent="detailjob(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-primary ms-0"><i class="far fa-eye"></i></span>
                  <span style="cursor:not-allowed; margin-right: 7px;" class="badge badge-sm bg-secondary disabled"><i class="fas fa-edit"></i></span>
                  <span style="cursor:not-allowed" class="badge badge-sm bg-secondary"><i class="far fa-trash-alt"></i></span>
                </div>
                <div v-else-if="data.status != 'Complete'">
                  <span @click.prevent="detailjob(data.id)" style="cursor:pointer;margin-right:7px" class="badge badge-sm bg-primary ms-0"><i class="far fa-eye"></i></span>
                  <span @click.prevent="showModalEdit(data)" style="cursor:pointer; margin-right: 7px;" class="badge badge-sm bg-warning disabled"><i class="fas fa-edit"></i></span>
                  <span @click.prevent="hapusjob(data.id)" style="cursor:pointer" class="badge badge-sm bg-danger"><i class="far fa-trash-alt"></i></span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mb-2">
        <!-- <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="jabatan" @pagination-change-page="allJabatan" /> -->
      </div>
    </div>
  </div>
  <div class="modal fade" id="jobmodal" aria-labelledby="jobmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="jobmodalLabel" v-show="!statusmodal">Buat Job Pegawai</h5>
        <h5 class="modal-title" id="jobmodalLabel" v-show="statusmodal">Update Job</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal ? editjob() : buatjob()">
                  <div class="mb-3">
                    <label class="form-label">Email Pegawai</label>
                        <select class="form-select" v-model="form.email_pegawai">
                          <option disabled selected>Pilih Email</option>
                          <option v-for="data in emailpeg" :key="data.id" :selected="null == form.email_pegawai ? selected : null" :value="data.email">{{data.email}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Job/Task</label>
                        <input type="text" v-model="form.judul_job" placeholder="Masukan nama job" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea v-model="form.deskripsi" type="text"  placeholder="" class="form-control form-control-md"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deadline</label>
                        <input type="date" v-model="form.deadline" placeholder="Masukan angka saja" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal"  @click="editjob()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal"  @click="buatjob()" class="btn btn-primary" type="submit" >Buat</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="revisimodal" aria-labelledby="revisimodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="revisimodalLabel" >Revisi Job</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Revisi</label>
                        <textarea v-model="rev.revisi" type="text"  placeholder="" class="form-control form-control-md"></textarea>
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button  @click="revisi()" class="btn btn-primary" type="submit" >Post</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="jobdetail" aria-labelledby="jobdetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="jobdetailLabel">Detail Job/Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form v-for="(data) in detjob" :key="data.id">
                    <div class="mb-3">
                        <label class="form-label">Email Pegawai</label>
                        <div type="text" placeholder="" class="form-control form-control-md">{{data.email_pegawai}}</div>
                    </div>
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
                        <label class="form-label">Lampiran</label>
                        <div v-if="data.pengumpulan != null" class="form-control form-control-md"><a class="text-primary" :href="`files/${data.pengumpulan}`"  target="_blank"> {{data.pengumpulan}}</a></div>
                        <div v-else-if="data.pengumpulan == null" class="form-control form-control-md"><a class="text-dark">Null</a></div>
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
  name: "data-jabatan",
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
                deadline:"",
                revisi:""
            }),
            rev : new Form({
                id : "",
                revisi:""
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    created() {
         this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljob',{
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
    methods:{
      modalapprove(id){
          const custom = Swal.mixin({
            customClass: {
              cancelButton: 'btn btn-secondary ms-2',
              confirmButton: 'btn bg-success text-white',
            },
            buttonsStyling: false
          })  
        custom.fire({
            title: 'Approvement Job ?',
            icon: 'warning',
            showCancelButton:true,
            confirmButtonText: 'Approve',
            cancelButtonText: 'Nanti'
          }).then((result)=>{
            if(result.isConfirmed){
              this.$axios.post('/api/approvejob',
                 {
                     id: id,
                     status: "Complete"
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Job Approved", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.alljob()  
                    }
                 })
            }
          })
        },
      revisi(){
        this.$axios.post('/api/approvejob',
                 {
                     id: this.rev.id,
                     status: "Revisi",
                     revisi: this.rev.revisi
                 },
                 {
                     headers: { Authorization: "Bearer " + this.token }
                 }).then((response)=>{
                    if(response.data.success){
                      const toast = useToast();
                      toast.success("Job Revision", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      $('#revisimodal').modal('hide')
                      this.alljob()  
                    }
                 })
      },
      detailjob(id){
            $('#jobdetail').modal('show')
            this.$axios.get('/api/detailjob/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detjob = response.data.data
            })
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
        searchjabatan(val) {
            if (val == "")
            {
                this.allJabatan()
            }else {
                axios
                    .get('/api/searchjabatan/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.jabatan = response.data;
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
        showrevisi(data) {
            $("#revisimodal").modal("show");
            this.rev.fill(data);
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
        editjob(){
              this.$axios.post('/api/updatejob',
                {
                    id: this.form.id,
                    email_pegawai: this.form.email_pegawai,
                    judul_job: this.form.judul_job,
                    deskripsi: this.form.deskripsi,
                    deadline: this.form.deadline
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                  const toast = useToast();
                  toast.success("Berhasil Update Job/Task", {
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
        alljob(){
          this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljob',{
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
                    this.searchjabatan(this.search)
                }
        },
  mounted() {
    setNavPills();
    this.getpt();
    this.allJabatan();
    this.getdataPegawai()
  }
};
</script>
