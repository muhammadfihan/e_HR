<template>
  <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Shift Pegawai</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button  color="primary" size="sm" variant="gradient" @click="showModal()">
            Buat Shift</argon-button>
        </div>
        <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Cuti Pegawai..." >
          </div>
        </div>
      </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div v-if="this.shift == ''" class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jenis Shift</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Masuk</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Pulang</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
        </table>
        <p class="text-center text-secondary text-xl font-weight-bold mt-9" style="font-size:23px">Data Kosong</p>
      </div>
      <div v-else-if="this.shift != ''" class="table-responsive p-0 border-bottom">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jenis Shift</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Masuk</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Pulang</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data, index) in shift" :key="data.name">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.name}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.email}}</span>
              </td>
              <td class="align-middle" >
                <span class="text-secondary text-xs font-weight-bold">
                  <span v-for="jab in detjabatan" :key="jab.id"><a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a></span>
                </span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-gradient-success" v-if="data.status == 'Aktif'">{{data.status}}</span>
                <span class="badge badge-sm bg-gradient-danger" v-else-if="data.status == 'Tidak Aktif'">{{data.status}}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- <div class="mt-4 mb-1">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="akunpegawai" @pagination-change-page="getUser" />
      </div> -->
    </div>
  </div>
  <div class="modal fade" id="shiftmodal" aria-labelledby="shiftmodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="shiftmodalLabel" v-show="!statusmodal">Buat Shift Baru</h5>
        <h5 class="modal-title" id="shiftmodalLabel" v-show="statusmodal">Update Shift</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal ? editshift() : buatshift()">
                    <div class="mb-3">
                        <label class="form-label">Jenis Shift</label>
                        <input type="text" v-model="form.jenis_shift" placeholder="Masukan nama shift pegawai" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Masuk</label>
                        <input type="time" v-model="form.jam_masuk" placeholder="Masukan Jam Masuk" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Pulang</label>
                        <input type="time" v-model="form.jam_pulang" placeholder="Masukan Jam Pulang" class="form-control form-control-md">
                    </div>
                    <div class="form-check">
                        <label class="col-9 form-label" v-for="data in akun" :key="data.id">
                            <input class="form-check-input" type="checkbox" v-model="emailmultiple" :value="data" @click="select" @change="select"/>
                            <span value={{form.email_pegawai}}></span>{{data}}
                        </label>
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal"  @click="editshift()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal"  @click="buatshift()" class="btn btn-primary" type="submit" >Buat</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import ArgonButton from "../tes/ArgonButton.vue";
import setNavPills from "../../../assets/js/nav-pills.js";
import useVuelidate from '@vuelidate/core'
import { required, email, minLength } from '@vuelidate/validators'
import LaravelVuePagination from 'laravel-vue-pagination';
import { useToast } from "vue-toastification";

export default {
  components: {
    ArgonButton,
    'Pagination': LaravelVuePagination
  },
  name: "data-akun",
  setup () {
        return { v$: useVuelidate() }
    },
    
    data() {
        return {
            LaravelVuePagination:{
				 'current_page': 1
			},
            cuti:[],
            search: '',
            infopt:[],
            shift:[],
            cek:[],
            akun:[],
            emailmultiple:[],
            statusmodal: false,
            akunpegawai :[],
            detjabatan:[],
            golongan:[],
            form : new Form({
                id : "",
                email_pegawai : [],
                jenis_shift : "",
                jam_masuk : "",
                jam_pulang : "",

            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    validations() {
        return {
        form: {
            name: {
            required, name
            },
            email: {
            required, email 
            },
        },
        }
    },
    created() {
    },
    methods:{
      select() {
            console.log(this.emailmultiple)
        },
       cekshift(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/cekpegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.cek = response.data.data
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
       getdataPegawai(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/sudahisi',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.akun = response.data.email
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        lengkapi(){
            this.$router.push("/Cuti");
        },
        cuticek(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/cekcuti',{
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
            $("#shiftmodal").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#shiftmodal").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#tambahakun").modal("hide");
        },
       editAkun() {
              axios.post('/api/updateUser', 
               {
                    id: this.form.id,
                    name: this.form.name,
                    id_jabatan: this.form.id_jabatan,
                    id_golongan: this.form.id_golongan,
                    email: this.form.email,
                    tanggal_masuk: this.form.tanggal_masuk
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Update Akun Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $("#tambahAkun").modal("hide");
                    this.getUser()
                }
            
            })
           
        },
        closeEdit() {
            this.form.reset();
            $("#editAkun").modal("hide");
        },
        buatshift() {
          this.$axios.post('/api/buatshift',
                {
                    id: this.form.id,
                    email_pegawai: this.emailmultiple,
                    jam_masuk: this.form.jam_masuk,
                    jam_pulang: this.form.jam_pulang,
                    jenis_shift:this.form.jenis_shift
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    const toast = useToast();
                    toast.success("Berhasil Membuat Shift", {
                        position: "top-center",
                        timeout: 2000,
                        icon: "fa-sharp fa-solid fa-thumbs-up"
                    });
                    this.form.reset();
                    $("#shiftmodal").modal("hide");
                    this.clear()
                }
           })
        },
          searchuser(val) {
            if (val == "")
            {
                this.getUser()
            }else {
                axios
                    .get('/api/searchuser/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.akunpegawai = response.data;
                    });
            }
        },
        getUser(page = 1){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/allUser?page=' + page, {
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.akunpegawai = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })

		},
         allJabatan(){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljabatan2',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.detjabatan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
         allgolongan(){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/allgolongan',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.golongan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },

        hapusAkun(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Akun Pegawai ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1BC5BD',
            cancelButtonColor: '',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            }).then((result) => {
                 if (result.isConfirmed) {
                 axios.delete('/api/hapusUser/'+id,  {
                headers: { Authorization: "Bearer " + this.token },
                },
                )
                  Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menghapus Akun Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    };
           
                    this.getUser()

            },

            )

            })
        },

    },
    watch: {
                search: function ()
                {
                    this.searchuser(this.search)
                }
        },


  mounted() {
    setNavPills();
    this.getpt();
    this.getUser();
    this.getdataPegawai()
    this.cekshift()
  }
};
</script>
