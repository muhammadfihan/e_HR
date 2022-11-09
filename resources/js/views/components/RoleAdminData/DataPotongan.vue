<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Management Potongan</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button color="primary" @click="showModal4()" size="sm" variant="gradient">Tambah Potongan</argon-button>
        </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="searchpot" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Bonus..." >
          </div>
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
              >Jenis Potongan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Nominal</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in potongan" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.jenis_potongan }}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{convertToRupiah (data.nominal) }}</span>
              </td>
              <td class="text-center text-sm align-middle" >
                  <span style="margin-right:7px;cursor:pointer" @click.prevent="showModalEdit4(data)" class="badge badge-sm bg-warning">Edit</span>
                  <span style="cursor:pointer" @click.prevent="hapuspotongan(data.id)" class="badge badge-sm bg-danger">Hapus</span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
    </div>
  </div>
  <div class="modal fade" id="tambahpotongan" aria-labelledby="tambahpotonganLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahpotonganLabel" v-show="!statusmodal4">Tambah Bonus</h5>
        <h5 class="modal-title" id="tambahpotonganLabel" v-show="statusmodal4">Update Bonus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal4()"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal4 ? editpotongan() : addpotongan()">
                    <div class="mb-3">
                        <label class="form-label">Jenis Potongan</label>
                        <input type="text" v-model="form.jenis_potongan" placeholder="Masukan Jenis Potongan" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal Potongan</label>
                        <input type="text" v-model="form.nominal" placeholder="Masukan Hanya Angka" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal4"  @click="editpotongan()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal4"  @click="addpotongan()" class="btn btn-primary" type="submit" >Tambah</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import ArgonButton from "../tes/ArgonButton.vue";
import setNavPills from "../../../assets/js/nav-pills.js";
import {useToast} from "vue-toastification";

export default {
  components: {
    ArgonButton,
  },
  name: "data-potongan",
  data(){
    return {
      searchpot: '',
            infopt:[],
            bonus:[],
            potongan:[],
            searchpot:'',
            searchbon: '',
            infopt:[],
            detpegawai:[],
            datapegawai:[],
            statusmodal4: false,
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
        showModal4() {
            this.statusmodal3 = false;
            this.form.reset();
            $("#tambahpotongan").modal("show");
        },
        showModalEdit4(data) {
            this.statusmodal3 = true;
            this.form.reset();
            $("#tambahpotongan").modal("show");
            this.form.fill(data);
        },
        closeModal4() {
            this.form.reset();
            $("#tambahpotongan").modal("hide");
        },
        editpotongan(){
        
        this.$axios.post('/api/updatepotongan',
          {
            id: this.form.id,
            jenis_potongan: this.form.jenis_potongan,
            nominal: this.form.nominal,
          },
          {
              headers: { Authorization: "Bearer " + this.token }
          }).then((response) => {
            if (response.data.success){
            const toast = useToast();
                  toast.success("Berhasil Update Potongan", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
              this.form.reset();
              $("#tambahpotongan").modal("hide");
              this.allpotongan()
          }
      

     })
  },
  addpotongan() {
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.form.post('/api/tambahpotongan', {
          headers : { Authorization: "Bearer " + this.token },
      }).then((response) => {
        if (response.data.success){
            const toast = useToast();
                  toast.success("Berhasil Menambahkan Potongan", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
              this.form.reset();
              $('#tambahpotongan').modal('hide')
              this.allpotongan()
          }
              
              }
          )
              })
  },
  allpotongan(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.$axios.get('/api/allpotongan2',{
          headers: {Authorization: "Bearer " + this.token},
      })
          .then(response => {
              this.potongan = response.data.data;
          })
          .catch(function (error) {
              console.error(error);
          });
  })
  },
   hapuspotongan(id){
    this.$axios.get('/sanctum/csrf-cookie').then(response => {
      const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-success',
              cancelButton: 'btn bg-gradient-danger',
            },
            buttonsStyling: false
          })
      custom.fire({
        title: 'Hapus Potongan ?',
        text: "Anda tidak akan bisa mengembalikannya lagi!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '',
        showConfirmButton:true,
        confirmButtonText: 'Hapus Potongan',
        cancelButtonText: 'Batal',
      }).then((result) => {
           if (result.isConfirmed) {
              this.$axios.delete('/api/hapuspotongan/'+id, {headers: { Authorization: "Bearer " + this.token }})
              .then((response) => {
                if(response.data.success == true){
                  const toast = useToast();
                  toast.success("Berhasil Menghapus Potongan", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  })
                  this.allpotongan()  
                };
                if(response.data.success == false){
                const toast = useToast();
                  toast.error("Gagal, Potongan Sedang Dalam Transaksi, Harap Mengupdate/Menghapus Gaji atau Menunggu Pegawai Menyelesaian Penggajian", {
                  position: "top-center",
                  timeout: 4000,
                  icon: "fa-solid fa-triangle-exclamation"
                  })
                  this.allpotongan()
                };
              })}
             
          }
        )
      })
  },
  searchpotongan(val) {
            if (val == "")
            {
                this.allpotongan()
            }else {
                axios
                    .get('/api/searchpotongan/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.potongan = response.data;
                    });
            }
    },   
  },  
  watch:{
    searchpot: function ()
            {
                this.searchpotongan(this.searchpot)
            },               
        },
  mounted() {
    setNavPills();
    this.allpotongan();
  }
};
</script>
