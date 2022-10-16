<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Management Bonus</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button color="success" @click="showModal2()" size="sm" variant="gradient">
            <i class="fas fa-plus me-2" ></i>Tambah Bonus</argon-button>
        </div>
      </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="searchbon" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Bonus..." >
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
              >Jenis Bonus</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Nominal</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in bonus" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.jenis_bonus }}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{convertToRupiah (data.nominal) }}</span>
              </td>
              <td class="text-center text-sm align-middle" >
                  <span style="margin-right:7px;cursor:pointer" @click.prevent="showModalEdit2(data)" class="badge badge-sm bg-warning">Edit</span>
                  <span style="cursor:pointer" @click.prevent="hapusbonus(data.id)" class="badge badge-sm bg-danger">Hapus</span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
    </div>
  </div>
  <div class="modal fade" id="tambahbonus" aria-labelledby="tambahbonusLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahbonusLabel" v-show="!statusmodal">Tambah Bonus</h5>
        <h5 class="modal-title" id="tambahbonusLabel" v-show="statusmodal">Update Bonus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal2()"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal2 ? editbonus() : addbonus()">
                    <div class="mb-3">
                        <label class="form-label">Jenis Bonus</label>
                        <input type="text" v-model="form.jenis_bonus" placeholder="Masukan Jenis Bonus" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal Bonus</label>
                        <input type="text" v-model="form.nominal" placeholder="Masukan Hanya Angka" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal2"  @click="editbonus()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal2"  @click="addbonus()" class="btn btn-primary" type="submit" >Tambah</button>
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
            bonus:[],
            searchbon: '',
            infopt:[],
            detpegawai:[],
            datapegawai:[],
            statusmodal2: false,
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
    showModal2() {
            this.statusmodal2 = false;
            this.form.reset();
            $("#tambahbonus").modal("show");
        },
        showModalEdit2(data) {
            this.statusmodal2 = true;
            this.form.reset();
            $("#tambahbonus").modal("show");
            this.form.fill(data);
        },
        closeModal2() {
            this.form.reset();
            $("#tambahbonus").modal("hide");
        },
    searchbonus(val) {
            if (val == "")
            {
                this.allbonus()
            }else {
                this.$axios
                    .get('/api/searchbonus/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.bonus = response.data;
                    });
            }
        },
        editbonus(){
        
        this.$axios.post('/api/updatebonus',
          {
              id: this.form.id,
              jenis_bonus: this.form.jenis_bonus,
              nominal: this.form.nominal,
          },
          {
              headers: { Authorization: "Bearer " + this.token }
          }).then((response) => {
            if (response.data.success){
            const toast = useToast();
                  toast.success("Berhasil Update Bonus", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
              this.form.reset();
              $("#tambahbonus").modal("hide");
              this.allbonus()
          }
      

     })
  },
  addbonus() {
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.form.post('/api/tambahbonus', {
          headers : { Authorization: "Bearer " + this.token },
      }).then((response) => {
        if (response.data.success){
            const toast = useToast();
                  toast.success("Berhasil Menambahkan Bonus", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
              this.form.reset();
              $('#tambahbonus').modal('hide')
              this.allbonus()
          }
              
              }
          )
              })
  },
   allbonus(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.$axios.get('/api/allbonus2',{
          headers: {Authorization: "Bearer " + this.token},
      })
          .then(response => {
              this.bonus = response.data.data;
          })
          .catch(function (error) {
              console.error(error);
          });
  })
  },
   hapusbonus(id){
    this.$axios.get('/sanctum/csrf-cookie').then(response => {
      const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-success',
              cancelButton: 'btn bg-gradient-danger',
            },
            buttonsStyling: false
          })
      custom.fire({
        title: 'Hapus Bonus ?',
        text: "Anda tidak akan bisa mengembalikannya lagi!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '',
        showConfirmButton:true,
        confirmButtonText: 'Hapus Bonus',
        cancelButtonText: 'Batal',
      }).then((result) => {
           if (result.isConfirmed) {
              this.$axios.delete('/api/hapusbonus/'+id, {headers: { Authorization: "Bearer " + this.token }})
              .then((response) => {
                if(response.data.success == true){
                  const toast = useToast();
                  toast.success("Berhasil Menghapus Bonus", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  })
                  this.allbonus()  
                };
                if(response.data.success == false){
                const toast = useToast();
                  toast.error("Gagal, Bonus Sedang Dalam Transaksi, Harap Mengupdate/Menghapus Gaji atau Menunggu Pegawai Menyelesaian Penggajian", {
                  position: "top-center",
                  timeout: 4000,
                  icon: "fa-solid fa-triangle-exclamation"
                  })
                  this.allbonus()
                };
              })}
             
          }
        )
      })
  },   
  },  
  watch:{
    searchbon: function ()
            {
                this.searchbonus(this.searchbon)
            },
  },
  mounted() {
    setNavPills();
    this.allbonus();
  }
};
</script>
