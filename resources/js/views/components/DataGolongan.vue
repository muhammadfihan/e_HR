<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Management Golongan</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button color="success" @click="showModal3()" size="sm" variant="gradient">
            <i class="fas fa-plus me-2" ></i>Tambah Golongan</argon-button>
        </div>
      </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="searchgol" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Golongan..." >
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
              >Golongan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Pendidikan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Nominal</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in golongan" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.golongan }}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.pendidikan }}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{convertToRupiah (data.nominal) }}</span>
              </td>
              <td class="text-center text-sm align-middle" >
                <span v-if="data.jenis_bonus == 'Tidak Ada Bonus'" class="badge badge-sm bg-secondary">Default</span>
                <div v-if="data.jenis_bonus !== 'Tidak Ada Bonus'">
                  <span style="margin-right:7px;cursor:pointer" @click.prevent="showModalEdit3(data)" class="badge badge-sm bg-warning">Edit</span>
                  <span style="cursor:pointer" @click.prevent="hapusgolongan(data.id)" class="badge badge-sm bg-danger">Hapus</span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
    </div>
  </div>
  <div class="modal fade" id="tambahgolongan" aria-labelledby="tambahgolonganLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahgolonganLabel" v-show="!statusmodal3">Tambah Golongan</h5>
        <h5 class="modal-title" id="tambahgolonganLabel" v-show="statusmodal3">Update Golongan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal3()"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal3 ? editgolongan() : addgolongan()">
                    <div class="mb-3">
                        <label class="form-label">Golongan</label>
                        <input type="text" v-model="form.golongan" placeholder="Masukan Golongan" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pendidikan</label>
                        <input type="text" v-model="form.pendidikan" placeholder="Masukan Pendidikan" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal</label>
                        <input type="text" v-model="form.nominal" placeholder="Masukan Hanya Angka" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal3"  @click="editgolongan()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal3"  @click="addgolongan()" class="btn btn-primary" type="submit" >Tambah</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import ArgonButton from "../components/tes/ArgonButton.vue";
import setNavPills from "../../assets/js/nav-pills.js";
import {useToast} from "vue-toastification";

export default {
  components: {
    ArgonButton,
  },
  name: "data-bonus",
  data(){
    return {
      searchpot: '',
            infopt:[],
            golongan:[],
            searchgol: '',
            infopt:[],
            detpegawai:[],
            datapegawai:[],
            statusmodal3: false,
             form : new Form({
                id : "",
                email: "",
                id_tunjangan : [],
                id_bonus : [],
                id_potongan : [],
            }),
            
            form : new Form({
                id : "",
                jenis_tunjangan : "",
                golongan : "",
                pendidikan : "",
                jenis_bonus : "",
                jenis_potongan : "",
                nominal : "",
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),

    }
  },
  methods:{
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
    showModal3() {
            this.statusmodal3 = false;
            this.form.reset();
            $("#tambahgolongan").modal("show");
        },
        showModalEdit3(data) {
            this.statusmodal3 = true;
            this.form.reset();
            $("#tambahgolongan").modal("show");
            this.form.fill(data);
        },
        closeModal3() {
            this.form.reset();
            $("#tambahgolongan").modal("hide");
        },
    searchgolongan(val) {
            if (val == "")
            {
                this.allgolongan()
            }else {
                this.$axios
                    .get('/api/searchgolongan/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.golongan = response.data;
                    });
            }
        },
        editgolongan(){
        
        this.$axios.post('/api/updategolongan',
          {
            id: this.form.id,
                    golongan: this.form.golongan,
                    pendidikan: this.form.pendidikan,
                    nominal: this.form.nominal,
          },
          {
              headers: { Authorization: "Bearer " + this.token }
          }).then((response) => {
            if (response.data.success){
            const toast = useToast();
                  toast.success("Berhasil Update Golongan", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
              this.form.reset();
              $("#tambahgolongan").modal("hide");
              this.allgolongan()
          }
      

     })
  },
  addgolongan() {
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.form.post('/api/tambahgolongan', {
          headers : { Authorization: "Bearer " + this.token },
      }).then((response) => {
        if (response.data.success){
            const toast = useToast();
                  toast.success("Berhasil Menambahkan Golongan", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
              this.form.reset();
              $('#tambahgolongan').modal('hide')
              this.allgolongan()
          }
              
              }
          )
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
   hapusgolongan(id){
    this.$axios.get('/sanctum/csrf-cookie').then(response => {
      const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-success',
              cancelButton: 'btn bg-gradient-danger',
            },
            buttonsStyling: false
          })  
      custom.fire({
        title: 'Hapus Golongan ?',
        text: "Anda tidak akan bisa mengembalikannya lagi!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '',
        showConfirmButton:true,
        confirmButtonText: 'Hapus Golongan',
        cancelButtonText: 'Batal',
          }).then((result) => {
              if (result.isConfirmed) {
                  this.$axios.delete('/api/hapusgolongan/'+id, {headers: { Authorization: "Bearer " + this.token }})
                  .then((response) => {
                    if(response.data.success == true){
                      const toast = useToast();
                      toast.success("Berhasil Menghapus Golongan", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                      this.allgolongan()  
                    };
                    if(response.data.success == false){
                    const toast = useToast();
                      toast.error("Gagal Menghapus, Golongan Sedang Digunakan, Harap Nonaktifkan Golongan dari Pegawai Jika Ingin Menghapus Golongan ", {
                      position: "top-center",
                      timeout: 4000,
                      icon: "fa-solid fa-triangle-exclamation"
                      })
                      this.allgolongan()
                    };
                  })}
                
              }
            )
          })
  },   
  },  
  watch:{
    searchgol: function ()
            {
                this.searchgolongan(this.searchgol)
            },
  },
  mounted() {
    setNavPills();
    this.allgolongan();
  }
};
</script>
