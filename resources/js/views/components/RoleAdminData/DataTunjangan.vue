<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Management Tunjangan</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button color="primary" @click="showModal()" size="sm" variant="gradient">Tambah Tunjangan</argon-button>
      </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Tunjangan..." >
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
              >Jenis Tunjangan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Nominal</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data, index) in tunjangan" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.jenis_tunjangan }}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{convertToRupiah (data.nominal) }}</span>
              </td>
              <td class="text-center text-sm align-middle" >
                  <span style="margin-right:7px;cursor:pointer" @click.prevent="showModalEdit(data)" class="badge badge-sm bg-warning">Edit</span>
                  <span style="cursor:pointer" @click.prevent="hapustunjangan(data.id)" class="badge badge-sm bg-danger">Hapus</span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
    </div>
  </div>
  <div class="modal fade" id="tambahtunjangan" aria-labelledby="tambahtunjanganLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahtunjanganLabel" v-show="!statusmodal">Tambah Tunjangan</h5>
        <h5 class="modal-title" id="tambahtunjanganLabel" v-show="statusmodal">Update Tunjangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal()"></button>
      </div>
      <div class="modal-body">
                <form @submit.prevent="statusmodal ? edittunjangan() : addtunjangan()">
                    <div class="mb-3">
                        <label class="form-label">Jenis Tunjangan</label>
                        <input type="text" v-model="form.jenis_tunjangan" placeholder="Masukan Jenis Tunjangan" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal Tunjangan</label>
                        <input type="text" v-model="form.nominal" placeholder="Masukan Hanya Angka" class="form-control form-control-md">
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button v-show="statusmodal"  @click="edittunjangan()" class="btn btn-primary" type="submit" >Update</button>
        <button v-show="!statusmodal"  @click="addtunjangan()" class="btn btn-primary" type="submit" >Tambah</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import setNavPills from "../../../assets/js/nav-pills.js";
import ArgonButton from "../tes/ArgonButton.vue";
import {useToast} from "vue-toastification";

export default {
  components: {
    ArgonButton,
  },
  name: "data-tunjangan",
  data(){
    return {
      searchpot: '',
            searchtun: '',
            infopt:[],
            tunjangan:[],
            infopt:[],
            detpegawai:[],
            datapegawai:[],
            statusmodal: false,
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
  watch: {
         searchtun: function ()
            {
                this.searchtunjangan(this.searchtun)
            },
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
    searchtunjangan(val) {
            if (val == "")
            {
                this.alltunjangan()
            }else {
                axios
                    .get('/api/searchtunjangan/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.tunjangan = response.data;
                    });
            }
     },
     showModal() {
            this.statusmodal = false;
            this.form.reset();
            $("#tambahtunjangan").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#tambahtunjangan").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#tambahtunjangan").modal("hide");
        },
        edittunjangan(){
        
        this.$axios.post('/api/updatetunjangan',
          {
              id: this.form.id,
              jenis_tunjangan: this.form.jenis_tunjangan,
              nominal: this.form.nominal,
          },
          {
              headers: { Authorization: "Bearer " + this.token }
          }).then((response) => {
          if (response.data.success){
            const toast = useToast();
                  toast.success("Berhasil Update Tunjangan", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
              this.form.reset();
              $("#tambahtunjangan").modal("hide");
              this.alltunjangan()
          }
      

     })
  },
  addtunjangan() {
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.form.post('/api/tambahtunjangan', {
          headers : { Authorization: "Bearer " + this.token },
      }).then((response) => {
          if (response.data.success){
            const toast = useToast();
                  toast.success("Berhasil Menambahkan Tunjangan", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
              this.form.reset();
              $('#tambahtunjangan').modal('hide')
              this.alltunjangan()
          }
              
              }
          )
              })
  },
   alltunjangan(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.$axios.get('/api/alltunjangan2',{
          headers: {Authorization: "Bearer " + this.token},
      })
          .then(response => {
              this.tunjangan = response.data.data;
          })
          .catch(function (error) {
              console.error(error);
          });
  })
  },
   hapustunjangan(id){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
        const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-success',
              cancelButton: 'btn bg-gradient-danger',
            },
            buttonsStyling: false
          })
      custom.fire({
        title: 'Hapus Tunjangan ?',
        text: "Anda tidak akan bisa mengembalikannya lagi!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '',
        showConfirmButton:true,
        confirmButtonText: 'Hapus Tunjangan',
        cancelButtonText: 'Batal',
      }).then((result) => {
           if (result.isConfirmed) {
              this.$axios.delete('/api/hapustunjangan/'+id, {headers: { Authorization: "Bearer " + this.token }})
              .then((response) => {
                if(response.data.success == true){
                  const toast = useToast();
                  toast.success("Berhasil Menghapus Tunjangan", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  })
                  this.alltunjangan()  
                };
                if(response.data.success == false){
                const toast = useToast();
                  toast.error("Gagal, Tunjangan Sedang Dalam Transaksi, Harap Mengupdate/Menghapus Gaji atau Menunggu Pegawai Menyelesaian Penggajian", {
                  position: "top-center",
                  timeout: 4000,
                  icon: "fa-solid fa-triangle-exclamation"
                  })
                  this.alltunjangan()
                };
              })}
             
          }
        )
      })
    },
  },
  mounted() {
    setNavPills();
    this.alltunjangan();
  },
};
</script>
