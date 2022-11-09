<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Tabel Data Pegawai</h6>
        </div>
         <div class="col-6 text-end" style="visibility:hidden">
          <argon-button color="success" size="sm" variant="gradient">
            <i class="fas fa-plus me-2" ></i>Tambah Jabatan</argon-button>
        </div>
        <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Pegawai..." >
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
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pegawai</th>
              <th
                class=" ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jabatan</th>
              <th
                class=" ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Golongan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No Pegawai</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal Masuk</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in pegawai.data" :key="data.id">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td>
                <p class="text-xs font-weight-bold mb-0">{{data.name}}</p>
                <p class="text-xs text-secondary mb-0">{{data.email}}</p>
              </td>
              <td class="align-middle" >
                <span class="text-secondary text-xs font-weight-bold">
                  <span v-for="jab in jabatan" :key="jab.id"><a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a></span>
                </span>
              </td>
              <td class="align-middle" >
                <span class="text-secondary text-xs font-weight-bold" v-if="data.id_golongan != null">
                  <span v-for="gol in golongan" :key="gol.id"><a v-if="data.id_golongan == gol.id">{{gol.golongan}}</a></span>
                </span>
                <span style="margin-left: 22px !important" class="align-middle text-center text-secondary text-xs font-weight-bold" v-else-if="data.id_golongan == null">
                  <span><a>-</a></span>
                </span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{data.no_pegawai}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-gradient-success" v-if="data.status == 'Aktif'">{{data.status}}</span>
                <span class="badge badge-sm bg-gradient-danger" v-else-if="data.status == 'Tidak Aktif'">{{data.status}}</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{data.tanggal_masuk}}</span>
              </td>
              <td class="align-middle text-center text-sm" >
                <span style="margin-right:7px;cursor:pointer" class="badge badge-sm bg-primary" @click.prevent="detailPegawai(data.id)">Detail</span>
                <span style="margin-right:7px;cursor:pointer" @click.prevent="editModal(data)" class="badge badge-sm bg-warning">Edit</span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="pegawai" @pagination-change-page="getdataPegawai" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="detailpegawai" aria-labelledby="detailpegawaiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailpegawaiLabel">Detail Data Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form  v-for="(data) in detpegawai" :key="data.id">
            <div class="mb-3">
                 <label class="form-label">Username</label>
                  <div class="form-control form-control-md">{{data.name}}</div>

                  <label class="form-label">Email</label>
                  <div class="form-control form-control-md">{{data.email}}</div>

                  <label class="form-label">Status</label>
                    <div class="form-control form-control-md" v-if="data.status == 'Aktif'">
                      <span class="badge badge-sm bg-gradient-success" >{{data.status}}</span>
                    </div>
                    <div class="form-control form-control-md" v-if="data.status == 'Tidak Aktif'">
                      <span class="badge badge-sm bg-gradient-danger">{{data.status}}</span>
                    </div>

                  <label class="form-label">Nama Lengkap</label>
                  <div class="form-control form-control-md" v-if="data.nama_lengkap != null">{{data.nama_lengkap}}</div>
                  <div class="form-control form-control-md" v-if="data.nama_lengkap == null">-</div>

                  <label class="form-label">No Pegawai</label>
                  <div class="form-control form-control-md">{{data.no_pegawai}}</div>

                  <label class="form-label">Jabatan</label>
                  <div class="form-control form-control-md">
                    <span v-for="jab in jabatan" :key="jab.id"><a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a></span>
                  </div>

                  <label class="form-label">Golongan</label>
                  <div class="form-control form-control-md" v-if="data.golongan != null">
                    <span v-for="gol in golongan" :key="gol.id">
                        <a v-if="data.id_golongan == gol.id">{{gol.golongan}}</a>
                    </span>
                  </div>
                  <div class="form-control form-control-md" v-if="data.golongan == null">-</div>

                  <label class="form-label">Tanggal Masuk</label>
                  <div class="form-control form-control-md">{{data.tanggal_masuk}}</div>
                  <label class="form-label">Jumlah Kerja</label>
                  <div class="form-control form-control-md">{{data.jumlah_kerja}} Hari</div>

                  <label class="form-label">Pendidikan Terakhir</label>
                  <div class="form-control form-control-md" v-if="data.pendidikan != null">{{data.pendidikan}}</div>
                  <div class="form-control form-control-md" v-if="data.pendidikan == null">-</div>

                  <label class="form-label">Nomor KTP</label>
                  <div class="form-control form-control-md" v-if="data.no_ktp != null">{{data.no_ktp}}</div>
                  <div class="form-control form-control-md" v-if="data.no_ktp == null">-</div>

                  <label class="form-label">Nomor Handphone</label>
                  <div class="form-control form-control-md" v-if="data.no_hp != null">{{data.no_hp}}</div>
                  <div class="form-control form-control-md" v-if="data.no_hp == null">-</div>

                  <label class="form-label">Jenis Kelamin</label>
                  <div class="form-control form-control-md" v-if="data.gender != null">{{data.gender}}</div>
                  <div class="form-control form-control-md" v-if="data.gender == null">-</div>

                  <label class="form-label">Alamat</label>
                  <span v-if="data.alamat != null">
                    <textarea v-model="data.alamat" disabled class="form-control form-control-md bg-white" ></textarea>
                  </span>
                  <span v-else-if="data.alamat == null">
                    <textarea disabled class="form-control form-control-md bg-white" >-</textarea>
                  </span>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="updatepegawai" aria-labelledby="updatepegawaiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updatepegawaiLabel">Update Data Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Jabatan Pegawai</label>
                        <select class="form-select" v-model="form.id_jabatan">
                          <option disabled selected>Ubah Jabatan</option>
                          <option v-for="data in jabatan" :key="data.id" :selected="data.jabatan == form.id_jabatan ? selected : null" :value="data.id">{{data.jabatan}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Golongan</label>
                        <select class="form-select" v-model="form.id_golongan">
                          <option v-for="data in golongan" :key="data.id" :selected="data.golongan == form.id_golongan ? selected : null" :value="data.id">{{data.golongan}}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Pegawai</label>
                        <select class="form-select" v-model="form.status">
                          <option >Aktif</option>
                          <option >Tidak Aktif</option>
                        </select>
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" type="submit" @click="updatePegawai()" >Update</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import setNavPills from "../../../assets/js/nav-pills.js";
import ArgonInput from "../tes/ArgonInput.vue";
import ArgonBadge from "../tes/ArgonBadge.vue";
import ArgonButton from "../tes/ArgonButton.vue";
import LaravelVuePagination from 'laravel-vue-pagination';
import { useToast } from "vue-toastification";

export default {
  components: {
    ArgonInput,
    ArgonButton,
    ArgonBadge,
    'Pagination': LaravelVuePagination
},
  name: "data-pegawai",
  data() {
        return {
            pegawai: [],
            detpegawai: [],
            jabatan:[],
            golongan:[],
            search: '',
            editpegawai:[],
            updatepegawai :[],
            delpegawai:[],
            infopt:[],
            form: new Form ({
                id : "",
                name : "",
                id_golongan : "",
                id_jabatan : "",
                status : ""
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
  mounted() {
    setNavPills();
    this.getJabatan();
    this.getdataPegawai();
    this.getpt();
    this.allgolongan();
},
methods:{
        getFormatedStringFromDays(numberOfDays) {
            var years = Math.floor(numberOfDays / 365);
            var months = Math.floor(numberOfDays % 365 / 30);
            var days = Math.floor(numberOfDays % 365 % 30);

            return [years,'Tahun', months,'Bulan', days, 'Hari'].join(' ');

        },


       format(time){
		if (time != null){
			return time.replace(/(?:0)?(\d+):(?:0)?(\d+).*/,'$1 Jam');
		}
        
		},
        closeModal() {
            this.form.reset();
            $("#updatepegawai").modal("hide");
        },
        editModal(data) {
            // this.form.reset()
            $("#updatepegawai").modal("show")
            this.form.fill({
                id: data.id,
                id_jabatan: data.id_jabatan,
                id_golongan: data.id_golongan,
                status: data.status,
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
        searchdatapeg(val) {
            if (val == "")
            {
                this.getdataPegawai()
            }else {
                this.$axios.get('/api/searchdata/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.pegawai = response.data;
                        // this.LaravelVuePagination = response.data.pagination;
                        // console.log(response)
                    });
            }
        },
        getdataPegawai(page = 1){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/datapegawai?page=' + page,{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.pegawai = response.data.data;
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
        detailPegawai(id){
            $('#detailpegawai').modal('show')
            this.$axios.get('/api/detailpegawai/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detpegawai = response.data.data
            })
        },

         updatePegawai(){
            this.$axios.post('/api/updatepegawai',
                {
                    id: this.form.id,
                    id_jabatan: this.form.id_jabatan,
                    id_golongan:this.form.id_golongan,
                    status: this.form.status
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                  const toast = useToast();
                  toast.success("Berhasil Update Pegawai", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  }),
                     $("#updatepegawai").modal("hide");
                    this.getdataPegawai();
                }
            })
        },

        getJabatan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljabatan2',{
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
        hapusPegawai(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Data Pegawai ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
             confirmButtonColor: '#1BC5BD',
            cancelButtonColor: '',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            }).then((result) => {
                 if (result.isConfirmed) {
                 axios.delete('/api/hapuspegawai/'+id,  {
                headers: { Authorization: "Bearer " + this.token }

            },)
             Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menghapus Data Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    }),
                    this.getdataPegawai()

                }

            },)
            }
        )}
    },

    watch: {
            search: function ()
            {
                this.searchdatapeg(this.search)
            }
        },
};
</script>
<style >
  /* .modal.fade {
  z-index: 10000 !important;
} */
</style>