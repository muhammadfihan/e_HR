<template>
  <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Pengaturan Cuti</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button style="margin-right:5px" @click="tambahcuti()" color="primary" size="sm" variant="gradient">Jatah Cuti</argon-button>
          <argon-button color="danger" @click="modalcuti()" size="sm" variant="gradient">Detail Cuti</argon-button>
        </div>
        <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="search" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Cuti Pegawai..." >
          </div>
        </div>
      </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div class="table-responsive p-0" v-if="this.totalcuti.data == ''">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Email Pegawai</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jumlah Cuti</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Sisa Cuti</th>
            </tr>
          </thead>
        </table>
        <p class="text-center text-secondary text-xl font-weight-bold mt-9" style="font-size:23px">Data Kosong</p>
      </div>
      <div class="table-responsive p-0 border-bottom"  v-else-if="this.totalcuti.data != ''">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Email Pegawai</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jumlah Cuti</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Cuti Terpakai</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Sisa Cuti</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in totalcuti.data" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.email }}</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{ data.jumlah_cuti }}</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{ data.cuti_terpakai }}</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{ data.sisa_cuti }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mb-2">
        <Pagination align="center" :data="totalcuti" @pagination-change-page="allcuti" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="detailcuti" aria-labelledby="detailcutiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailcutiLabel">Detail Cuti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form >
            <div class="mb-3" v-for="(data) in jumlah_cuti.data" :key="data.id">
                 <label class="form-label">Jumlah Cuti</label>
                  <div class="form-control form-control-md">{{ data.jumlah_cuti}}</div>

                  <label class="form-label">Tahun</label>
                  <div class="form-control form-control-md">{{ data.tahun}}</div>

            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="tambahcuti" aria-labelledby="tambahcutiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahcutiLabel">Tambah Jatah Cuti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form >
            <div class="mb-3">
                 <label class="form-label">Jumlah Cuti</label>
                  <input placeholder="Masukan Jumlah Cuti" v-model="form.jumlah_cuti" class="form-control form-control-md"/>

            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit" @click="addJatahcuti()">Tambah</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import setNavPills from "../../../assets/js/nav-pills.js";
import ArgonButton from "../tes/ArgonButton.vue";
import { useToast } from "vue-toastification";
import LaravelVuePagination from 'laravel-vue-pagination';
export default {
  components: {
    ArgonButton
  },
  name: "data-cuti",
  data() {
       return {
            jumlah_cuti:[],
            totalcuti:[],
            infopt:[],
            search: '',
            statusmodal: false,
            form : new Form({
                id : "",
                jumlah_cuti : "",
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    methods:{
        modalcuti() {
            $("#detailcuti").modal("show");
        },
        tambahcuti() {
            $("#tambahcuti").modal("show");
        },
        searchjatahcuti(val) {
            if (val == "")
            {
                this.allJabatan()
            }else {
                axios
                    .get('/api/searchjatahcuti/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.jatahcuti = response.data;
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
            $("#TambahCuti").modal("show");
        },
        closeModal() {
            $("#TambahCuti").modal("hide");
             this.form.reset();
        },
        addJatahcuti() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.form.post('/api/mastercutiperusahaan/add', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                  const toast = useToast();
                  toast.success("Berhasil Menambahkan Jatah Cuti", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  })
                    this.form.reset();
                    $('#tambahcuti').modal('hide')
                    this.alljatahcuti()
                }
                if (response.data.success == false){
                  const toast = useToast();
                  toast.error("Cuti Belum Terisi", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-solid fa-triangle-exclamation"
                  })
                }
                if (response.data.status == false){
                  const toast = useToast();
                  toast.error("Telah Menambahkan Jatah Cuti Tahun Ini", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-solid fa-triangle-exclamation"
                  })
                }
                    
                    }
                )
                    })
        },
        alljatahcuti(){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/mastercutiperusahaan',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.jumlah_cuti = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
		},
        allcuti(page = 1){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/mastercutitahunan?page=' + page, {
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.totalcuti = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
		},
    watch: {
                search: function ()
                {
                    this.searchjatahcuti(this.search)
                }
        },
    },
  mounted() {
    setNavPills();
    this.getpt();
    this.allcuti();
    this.alljatahcuti();
  }
};
</script>
