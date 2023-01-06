<template>
  <body class="" style="margin-top:-20px;background-color: #F5F5FC;">
  <div class="main-content">
    <!-- Navbar -->
    <!-- Header -->
    <div class="header py-7 py-lg-8" style="background-color: #F5F5FC;">
      <div class="container" style="margin-top:-20px">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-primary">Selamat Datang !</h1>
              <p class="text-lead text-default">Silahkan Daftarkan Perusahaan Anda Dengan Mengisi Form Berikut dan Coba Fitur Yang Kami Tawarkan</p>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- Page content -->
    <div class="container pb-5" style="margin-top:-200px">
      <!-- Table -->
      <div class="row justify-content-center">
        <div class="col-lg-9 col-md-9">
          <div class="card card z-index-0 fadeIn3 fadeInBottom bg-white ">
            <div class="card-body bg-gray-50 px-lg-5 py-lg-5">
              <form>
                <h6 class="heading-small text-muted mb-4">Informasi Akun</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input v-model="name" type="name" class="form-control" placeholder="Masukan Username Akun Anda">
                        </div>
                    </div>
                    <div class="col-lg-6">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Jabatan</label>
                        <input v-model="jabatan" type="text" class="form-control" placeholder="Masukan Jabatan Pemilik Akun">
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input v-model="email" type="email" class="form-control" placeholder="Masukan Email Perusahaan Anda">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input v-model="password" type="password" class="form-control" placeholder="Masukan Password Anda">
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
                        <div class="form-group">
                        <label for="exampleInputEmail1">Alamat Perusahaan</label>
                        <input v-model="det_alamat" type="text" class="form-control" placeholder="Masukan Alamat Lengkap Perusahaan Anda">
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Jumlah Karyawan</label>
                        <input v-model="jumlah_karyawan" type="number" class="form-control" placeholder="Masukan Jumlah Karyawan Perusahaan Anda">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="exampleInputEmail1">NPWP</label>
                        <input v-model="npwp" type="number" class="form-control" placeholder="Masukan Nomor NPWP Perusahaan Anda">
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Kota</label>
                        <input v-model="kota" type="text" class="form-control" placeholder="Kota Tempat Perusahaan">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Provinsi</label>
                        <input v-model="provinsi" type="text" class="form-control" placeholder="Provinsi Tempat Perusahaan">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Kode Pos</label>
                        <input v-model="kode_pos" type="number" class="form-control" placeholder="Masukan Kode Pos">
                        </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4">
                <!-- Description -->
                <h6 class="heading-small text-muted mb-4">Tentang Perusahaan</h6>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Nama Perusahaan</label>
                        <input v-model="nama_perusahaan" type="text" class="form-control" placeholder="Masukan Nama Perusahaan Anda">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Bidang</label>
                        <input v-model="bidang" type="text" class="form-control" placeholder="Perusahaan Bergerak Pada Bidang">
                        </div>
                    </div>
                  </div>
                <div class="pl-lg-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Moto Perusahaan</label>
                        <input v-model="moto" type="text" class="form-control" placeholder="Masukan Moto">
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Website Perusahaan</label>
                        <input v-model="website_pt" type="text" class="form-control" placeholder="Masukan Website">
                        </div>
                    </div>
                  </div>
                <div class="text-center">
                  <div class="my-4">
                    <argon-button color="warning" @click.prevent="register" size="md" fullWidth variant="">Daftar Sekarang</argon-button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <footer class="py-5">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-xl-left text-muted">
            &copy; 2022 <a href="https://www.creative-tim.com/product/argon-dashboard" class="font-weight-bold" target="_blank">HRIS Web and Mobile Apps</a>
          </div>
        </div>
        <div class="col-xl-6">
          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
              <a href="" class="nav-link" target="_blank">Tentang HRIS Apps</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</body>
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