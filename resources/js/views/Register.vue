<template>
    <div class="container mt-5 ">
      <div class="row justify-content-center mb-8">
        <div class="col-lg-8 mb-6">
          <div class="card shadow border-1">
            <div class="card-header bg-gradient-primary">
              <h5 class="text-white text-center text-bold text-xl mb-1">Registrasi Akun Perusahaan</h5>
            </div>
            <div class="card-body bg-gray-50">
              <form>
                <h6 class="heading-small text-muted mb-4">Informasi Akun</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">Username</label>
                        <argon-input placeholder="Username" type="name" v-model="name"></argon-input>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Jabatan</label>
                        <argon-input placeholder="Jabatan Pendaftar Akun" type="text" v-model="jabatan"></argon-input>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">Email</label>
                        <argon-input placeholder="Masukan Email Perusahaan/Admin" type="email" v-model="email"></argon-input>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Password</label>
                        <argon-input placeholder="Masukan Password" type="password" v-model="password"></argon-input>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4">
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Informasi Perusahaan</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-address">Address</label>
                        <argon-input placeholder="Alamat Lengkap Perusahaan" type="text" v-model="det_alamat"></argon-input>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">Jumlah Karyawan</label>
                        <argon-input placeholder="Masukan Jumlah Karyawan" type="number" v-model="jumlah_karyawan"></argon-input>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">No NPWP</label>
                        <argon-input placeholder="Masukan Nomor NPWP" type="number" v-model="npwp"></argon-input>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-city">Kota</label>
                        <argon-input placeholder="Masukan Kota" type="text" v-model="kota"></argon-input>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-country">Provinsi</label>
                        <argon-input placeholder="Masukan Provinsi" type="text" v-model="provinsi"></argon-input>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Kode Pos</label>
                        <argon-input placeholder="Masukan Kode Pos" type="number" v-model="kode_pos"></argon-input>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4">
                <!-- Description -->
                <h6 class="heading-small text-muted mb-4">Tentang Perusahaan</h6>
                <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">Nama Perusahaan</label>
                        <argon-input placeholder="Masukan Nama Perusahaan" type="text" v-model="nama_perusahaan"></argon-input>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Bidang Perusahaan</label>
                        <argon-input placeholder="Perusahaan Bergerak Pada Bidang..." type="text" v-model="bidang"></argon-input>
                      </div>
                    </div>
                  </div>
                <div class="pl-lg-4">
                  <div class="form-group">
                    <label>Moto Perusahaan (Optional)</label>
                    <textarea rows="4" class="form-control" placeholder="Moto Perusahaan Anda ..." v-model="moto"></textarea>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-address">Website Perusahaan (Optional)</label>
                        <argon-input placeholder="Website Perusahaan" type="website" v-model="website_pt"></argon-input>
                      </div>
                    </div>
                  </div>
                <div class="text-center">
                  <div class="my-4">
                    <argon-button color="primary" @click.prevent="register" size="md" fullWidth variant="gradient">Daftar Sekarang</argon-button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import ArgonInput from "../components/ArgonInput.vue";
import ArgonSwitch from "../components/ArgonSwitch.vue";
import ArgonButton from "../components/ArgonButton.vue";
import { useToast } from "vue-toastification";

const body = document.getElementsByTagName("body")[0];

export default {
  data() {
        return {
            email: "",
            password: "",
            name:"",
            jabatan:"",
            npwp:"",
            provinsi:"",
            kota:"",
            det_alamat:"",
            nama_perusahaan:"",
            bidang:"",
            moto:"",
            website_pt:"",
            kode_pos:"",
            jumlah_karyawan:"",
            role :"",
            error: null,
            loggedIn: localStorage.getItem("loggedIn"),
            token: localStorage.getItem("token"),
        }
    },
  name: "signin",
  components: {
    ArgonInput,
    ArgonSwitch,
    ArgonButton,
  },
  methods:{
    register(e) {
            e.preventDefault()
            if (this.password.length > 0) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/register', {
                        name: this.name,
                        email: this.email,
                        nama_perusahaan:this.nama_perusahaan,
                        jabatan:this.jabatan,
                        bidang:this.bidang,
                        kota:this.kota,
                        npwp:this.npwp,
                        kode_pos:this.kode_pos,
                        provinsi:this.provinsi,
                        det_alamat:this.det_alamat,
                        jumlah_karyawan:this.jumlah_karyawan,
                        password: this.password,
                        moto:this.moto,
                        website_pt:this.website_pt
                    }).then(response => {
                            if (response.data.success) {
                              const toast = useToast();
                                toast.success("Akun Berhasil Dibuat, Harap Menunggu Verifikasi Akun, Kami Akan Menginformasikan Melalui Email Yang Digunakan Untuk Mendaftar", {
                                position: "top-center",
                                timeout: 5000,
                                icon: "fa-solid fa-square-check"
                              });
                               this.$router.push("/")
                            }
                            else {
                                 this.error = response.data.message
                                }
                            })
                            .catch(function (error) {
                              console.error(error);
                        });

                })
            }
        },
    topegawai(){
      this.$router.push('/loginpegawai')
    },
    toadmin(){
      this.$router.push('/')
    },
    loginAdmin(e) {
            e.preventDefault()
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/login', {
                        email: this.email,
                        password: this.password
                    }).then(response => {
                        if (response.data.success) {
                  const toast = useToast();
                  toast.success("Selamat Datang Kembali", {
                    position: "top-center",
                    timeout: 1500,
                    icon: "fa-solid fa-square-check"
                  });
                            if (response.data.success) {
                                window.localStorage.setItem("loggedIn", true)
                                window.localStorage.setItem("token", response.data.token)
                                window.localStorage.setItem("expired_at", response.data.expired_at)
                                window.localStorage.setItem("role", response.data.user.role)
                                window.localStorage.setItem("name", response.data.user.name)

                                if (response.data.user.role == 'Manager') {
                                    this.$router.push("/SuperAdminDashboard")
                                } else if (response.data.user.role == 'Admin') {
                                    this.$router.push("/dashboard-default")
                                } else if (response.data.user.role == 'Pegawai') {
                                    this.$router.push("/PegawaiDashboard")
                                }
                                this.loggedIn = true;
                            } else {
                                this.error = response.data.message
                            }

            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal!!',
                    text: 'Terjadi Kesalahan',
                    showConfirmButton: false,
                    timer: 1800
                })
            }  
                      
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
        },
  },  
  mounted(){
  },
  created() {
    this.$store.state.hideConfigButton = true;
    this.$store.state.showNavbar = false;
    this.$store.state.showSidenav = false;
    this.$store.state.showFooter = false;
    body.classList.remove("bg-gray-100");
  },
  beforeUnmount() {
    this.$store.state.hideConfigButton = false;
    this.$store.state.showNavbar = true;
    this.$store.state.showSidenav = true;
    this.$store.state.showFooter = true;
    body.classList.add("bg-gray-100");
  },  
};
</script>
