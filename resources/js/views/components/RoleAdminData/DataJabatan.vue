<template>
  <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Management Jabatan</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button color="primary" @click="showModal()" size="sm" variant="gradient">Tambah Jabatan</argon-button>
        </div>
        <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="searchbon" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Jabatan..." >
          </div>
        </div>
      </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div v-if="this.jabatan.data == ''" class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jabatan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Gaji</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
        </table>
        <p class="text-center text-secondary text-xl font-weight-bold mt-9" style="font-size:23px">Data Kosong</p>
      </div>
      <div v-else-if="this.jabatan.data != ''" class="table-responsive p-0 border-bottom">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jabatan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Gaji</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in jabatan.data" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.jabatan}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{convertToRupiah (data.gaji) }}</span>
              </td>
              <td class="text-center text-sm align-middle" >
                <span @click.prevent="showModalEdit(data)" style="cursor:pointer; margin-right: 7px;" class="badge badge-sm bg-warning disabled"><i class="fas fa-edit"></i></span>
                <span @click.prevent="hapusJabatan(data.id)" style="cursor:pointer" class="badge badge-sm bg-danger"><i class="far fa-trash-alt"></i></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="jabatan" @pagination-change-page="allJabatan" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="jabatan" aria-labelledby="jabatanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="jabatanLabel" v-show="!statusmodal">Tambah Jabatan</h5>
        <h5 class="modal-title" id="jabatanLabel" v-show="statusmodal">Update Jabatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal ? editJabatan() : addJabatan()">
                    <div class="mb-3">
                        <label class="form-label">Nama Jabatan</label>
                        <input type="text" v-model="form.jabatan" placeholder="Masukan nama jabatan" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal Gaji</label>
                        <input type="text" v-model="form.gaji" placeholder="Masukan angka saja" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal"  @click="editJabatan()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal"  @click="addJabatan()" class="btn btn-primary" type="submit" >Tambah</button>
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
            jabatan:[],
            infopt:[],
            search: '',
            statusmodal: false,
            form : new Form({
                id : "",
                jabatan : "",
                gaji : "",
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    created() {
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
    methods:{
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
            $("#jabatan").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#jabatan").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#jabatan").modal("hide");
        },

        addJabatan() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.form.post('/api/tambahjabatan', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                  const toast = useToast();
                  toast.success("Berhasil Menambahkan Jabatan", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
                    this.form.reset();
                    $('#jabatan').modal('hide')
                    this.allJabatan()
                }
                    
                    }
                )
                    })
        },
        editJabatan(){
        
              this.$axios.post('/api/updatejabatan',
                {
                    id: this.form.id,
                    jabatan: this.form.jabatan,
                    gaji: this.form.gaji,
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                  const toast = useToast();
                  toast.success("Berhasil Update Jabatan", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  })
                    this.form.reset();
                    $("#jabatan").modal("hide");
                    this.allJabatan()
                }
            

           })
        },
        hapusJabatan(id){
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
          const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-success',
              cancelButton: 'btn bg-gradient-danger',
            },
            buttonsStyling: false
          })
        custom.fire({
        title: 'Hapus Jabatan ?',
        text: "Anda tidak akan bisa mengembalikannya lagi!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '',
        showConfirmButton:true,
        confirmButtonText:'Hapus Jabatan',
        cancelButtonText: 'Batal',
          }).then((result) => {
              if (result.isConfirmed) {
                  this.$axios.delete('/api/hapusjabatan/'+id, {headers: { Authorization: "Bearer " + this.token }})
                  .then((response) => {
                    if(response.data.success == true){
                      const toast = useToast();
                      toast.success("Berhasil Menghapus Jabatan", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.allJabatan()  
                    };
                    if(response.data.success == false){
                    const toast = useToast();
                      toast.error("Gagal Menghapus, Jabatan Sedang Digunakan, Harap Nonaktifkan Jabatan dari Pegawai Jika Ingin Menghapus Jabatan ", {
                      position: "top-center",
                      timeout: 4000,
                      icon: "fa-solid fa-triangle-exclamation"
                      })
                      this.allJabatan()
                    };
                  })}
                
              }
            )
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
  }
};
</script>
