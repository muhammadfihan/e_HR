<template>
  <div class="card bg-gray-100 shadow-none" v-if="role == 'Pegawai'">
    <div class="row">
      <div class="col">
        <div class="card" style=" overflow-y: auto">
          <div class="card-header pb-0">
            <div class="d-flex align-items-center" v-for="(data) in pegawai" :key="data.id">
              <h5 class="text-uppercase mb-0">Informasi Pribadi</h5>
              <argon-button color="primary"  size="sm" class="ms-auto"
                >Update Password</argon-button
              >
              <argon-button color="info" @click.prevent="modalupdate(data)" size="sm" class="ms-2"
                >Update Data</argon-button
              >
            </div>
          </div>
          <div class="card-body" v-for="(data) in pegawai" :key="data.id">
            <p class="text-uppercase text-sm">Informasi Akun</p>
            <div class="row">
              <div class="col-md-6">
                <label for="example-text-input" class="form-control-label"
                  >Username</label
                >
                <div class="form-control form-control-md">{{data.name}}</div>
              </div>
              <div class="col-md-6">
                <label for="example-text-input" class="form-control-label"
                  >Email address</label
                >
                <div class="form-control form-control-md">{{data.email}}</div>
              </div>
            </div>
            <hr class="horizontal dark" />
            <p class="text-uppercase text-sm">Data Diri</p>
            <div class="row">
              <div class="col-md-6">
                <label for="example-text-input" class="form-control-label"
                  >Nama Lengkap</label
                >
                <div class="form-control form-control-md">{{data.nama_lengkap}}</div>
                <div class="form-control form-control-md" v-if="data.nama_lengkap == null">-</div>
              </div>
              <div class="col-md-6">
                <label for="example-text-input" class="form-control-label"
                  >Tanggal Lahir</label
                >
                <div class="form-control form-control-md">{{data.ttl}}</div>
                <div class="form-control form-control-md" v-if="data.ttl == null">-</div>
              </div>
              <div class="col-md-12">
                <label for="example-text-input" class="form-control-label"
                  >Pendidikan Terakhir</label
                >
                <div class="form-control form-control-md">{{data.pendidikan}}</div>
                <div class="form-control form-control-md" v-if="data.pendidikan == null">-</div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="example-text-input" class="form-control-label"
                  >Alamat</label
                >
                <div class="form-control form-control-md">{{data.alamat}}</div>
                <div class="form-control form-control-md" v-if="data.alamat == null">-</div>
              </div>
              <div class="col-md-4">
                <label for="example-text-input" class="form-control-label"
                  >No Hp</label
                >
                <div class="form-control form-control-md">{{data.no_hp}}</div>
                <div class="form-control form-control-md" v-if="data.no_hp == null">-</div>
              </div>
              <div class="col-md-4">
                <label for="example-text-input" class="form-control-label"
                  >No Ktp</label
                >
                <div class="form-control form-control-md">{{data.no_ktp}}</div>
                <div class="form-control form-control-md" v-if="data.no_ktp == null">-</div>
              </div>
              <div class="col-md-4">
                <label for="example-text-input" class="form-control-label"
                  >Jenis Kelamin</label
                >
                <div class="form-control form-control-md">{{data.gender}}</div>
                <div class="form-control form-control-md" v-if="data.gender == null">-</div>
              </div>
              <div class="col-md-4">
                <label for="example-text-input" class="form-control-label"
                  >Jatah Cuti</label
                >
                <div class="form-control form-control-md" v-for="(data) in datacuti" :key="data.id">{{data.jumlah_cuti}}</div>
              </div>
              <div class="col-md-4">
                <label for="example-text-input" class="form-control-label"
                  >Sisa Cuti</label
                >
                <div class="form-control form-control-md" v-for="(data) in datacuti" :key="data.id">{{data.sisa_cuti}}</div>
              </div>
              <div class="col-md-4">
                <label for="example-text-input" class="form-control-label"
                  >Cuti Terpakai</label
                >
                <div class="form-control form-control-md" v-for="(data) in datacuti" :key="data.id">{{data.cuti_terpakai}}</div>
              </div>
              <div class="col-md-12">
          <hr class="horizontal dark" />
          <div class="row">
              <div class="col-lg-5">
                      <p class="text-uppercase text-sm">Metode Penggajian</p>
                <div class="row">
                  <div class="card bg-dark text-white ms-2 card-body border card-plain border-radius-lg d-flex align-items-center flex-row"><b>{{data.jenis_rek}} &nbsp;</b>
                  <h6 class="mb-0 text-white">{{data.no_rek}}</h6>
                    <i
                      class="fa-solid fa-credit-card ms-auto text-white cursor-pointer"
                      data-bs-toggle="tooltip"
                      data-bs-placement="top"
                      title
                      aria-hidden="true"
                      data-bs-original-title="Edit Card"
                      aria-label="Edit Card"
                    ></i>
                      <span class="sr-only">Edit Card</span>
                </div>
              </div>
            </div>
              <div class="col-lg-6">
                      <p class="text-uppercase text-sm">Gaji Pokok</p>
                <div class="row">
                  <div class="card bg-info text-white ms-2 card-body border card-plain border-radius-lg d-flex align-items-center flex-row"><b>{{jab}} &nbsp;</b>
                  <h6 class="mb-0 text-white">{{convertToRupiah(gaji)}}</h6>
                  <i
                    class="fa-solid fa-money-check-dollar ms-auto text-white cursor-pointer"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title
                    aria-hidden="true"
                    data-bs-original-title="Edit Card"
                    aria-label="Edit Card"
                  ></i>
                  <span class="sr-only">Edit Card</span>
            </div>
          </div>
        </div>
       </div>
      </div>
            </div>
            <hr class="horizontal dark" />
            <p class="text-uppercase text-sm">Tentang</p>
            <div class="row">
              <div class="col-md-12">
                <label for="example-text-input" class="form-control-label"
                  >Moto Perusahaan</label
                >
                <argon-input
                  type="text"
                  value="A beautiful Dashboard for Bootstrap 5. It is Free and Open Source."
                />
                <label for="example-text-input" class="form-control-label"
                  >Website Perusahaan</label
                >
                <argon-input
                  type="text"
                  value="A beautiful Dashboard for Bootstrap 5. It is Free and Open Source."
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-profile" v-if="role == 'Pegawai'">
    <img src="../../../assets/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top" />
    <div class="row justify-content-center">
      <div class="col-4 col-lg-4 order-lg-2">
        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
          <a href="javascript:;">
            <img
              src="../../../assets/img/logo.png"
              class="rounded-circle img-fluid border border-3 border-black"
            />
          </a>
        </div>
      </div>
    </div>
    <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
      <div class="d-flex justify-content-between">
        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-none d-lg-block"><span><i class="fa-solid fa-arrow-up-from-bracket me-1"></i></span>Photo</a>
        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none">
          <i class="ni ni-collection"></i>
        </a>
        <a
          href="javascript:;"
          class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block"
        ><span><i class="fa-solid fa-arrow-up-from-bracket me-1"></i></span> Image</a>
        <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none">
          <i class="ni ni-email-83"></i>
        </a>
      </div>
    </div>
    <div class="card-body pt-0" v-for="data in card" :key="data.id">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-center">
            <div class="d-grid text-center">
              <span class="text-lg font-weight-bolder">{{data.jumlah_kerja}}</span>
              <span class="text-sm opacity-8">Total Hari Kerja</span>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center mt-4">
        <h5>
          {{namapt}}
        </h5>
        <div class="h6 font-weight-300" >
          <i class="ni location_pin mr-2"></i>Jabatan - {{jab}}
        </div>
        <div class="h6 mt-4">
          <i class="ni business_briefcase-24 mr-2"></i>Tanggal Masuk
        </div>
        <div>
          <i class="ni education_hat mr-2"></i>{{data.tanggal_masuk}}
        </div>
      </div>
    </div>
  </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="biodata" aria-labelledby="biodataLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered-top modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <h5 class="modal-title" id="biodataLabel">Update Data Diri Pegawai</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card-body bg-gray-50" >
          <form @submit.prevent="updatedata()">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input v-model="form.nama_lengkap" type="text" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <input v-model="form.pendidikan" type="text" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanngal Lahir</label>
                        <input v-model="form.ttl" type="date" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input v-model="form.no_ktp" type="text" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Handphone</label>
                        <input v-model="form.no_hp" type="text" placeholder="" class="form-control form-control-md">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Jenis Kelamin</label>
                        <select v-model="form.gender" class="form-select form-select-md">
                          <option >Laki-Laki</option>
                          <option >Perempuan</option>
                        </select>
                    </div>
                    <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">Jenis Rekening</label>
                        <argon-input v-model="form.jenis_rek" placeholder="Rekening" type="text"></argon-input>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">No Rekening</label>
                        <argon-input v-model="form.no_rek" placeholder="No Rekening Hanya Angka" type="number"></argon-input>
                      </div>
                    </div>
                  </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea v-model="form.alamat" type="text" placeholder="" class="form-control form-control-md"></textarea>
                    </div>
                </form>
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" @click.prevent="updatedata()">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import ArgonInput from "../tes/ArgonInput.vue";
import ArgonButton from "../tes/ArgonButton.vue";
import setNavPills from "../../../assets/js/nav-pills.js";
import setTooltip from "../../../assets/js/tooltip.js";
import {useToast} from 'vue-toastification'

export default {
name: "profile",
data() {
  return {
    infopt:[],
    card:[],
    datacuti:[],
    pegawai:[],
    datpeg:[],
    jab:[],
    gaji:[],
    form : new Form({
                id : "",
                nama_lengkap : "",
                no_ktp : "",
                no_hp : "",
                pendidikan :"",
                gender : "",
                alamat : "",
                jenis_rek : "",
                no_rek : "",
                ttl : ""
            }),
    role: localStorage.getItem("role"),
    token: localStorage.getItem("token"),
    namapt: localStorage.getItem("namapt")
  };
},
components: { ArgonInput, ArgonButton },
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
  updatedata() {
              this.$axios.post('/api/updatedata', 
               {
                    id: this.form.id,
                    nama_lengkap: this.form.nama_lengkap,
                    no_ktp: this.form.no_ktp,
                    no_hp: this.form.no_hp,
                    gender: this.form.gender,
                    alamat: this.form.alamat,
                    pendidikan: this.form.pendidikan,
                    jenis_rek: this.form.jenis_rek,
                    no_rek: this.form.no_rek,
                    ttl: this.form.ttl,
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    const toast = useToast();
                    toast.success("Berhasil Update Data Diri", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                    });
                    $("#biodata").modal("hide")
                    this.pegawaiprofile()
                }
            
            })
           
        },
  pegawaiprofile(){
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/profilepegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.pegawai = response.data.biodata;
                    this.card = response.data.profilecard;
                    this.jab = response.data.jabatan
                    this.datacuti = response.data.cuti,
                    this.gaji = response.data.gaji
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
  },
  modalupdate(data){
    $("#biodata").modal("show")
    this.form.fill({
                nama_lengkap: data.nama_lengkap,
                pendidikan: data.pendidikan,
                no_ktp: data.no_ktp,
                no_hp: data.no_hp,
                gender: data.gender,
                alamat: data.alamat,
                ttl: data.ttl,
                no_rek: data.no_rek,
                jenis_rek: data.jenis_rek
            })
  },
  
},
created(){
 
},
mounted() {
  this.pegawaiprofile()
  setNavPills();
  setTooltip();
},

};
</script>
