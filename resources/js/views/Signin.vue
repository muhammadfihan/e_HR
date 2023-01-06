<template>
<body class="bg-gray-200">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-color: #F5F5FC;">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-primary shadow-primary border-radius-lg py-5 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login HRIS</h4>
                </div>
              </div>
              <div class="card-body">
                <form role="form" class="text-start">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alamat Email</label>
                        <input v-model="email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="Masukan Email Anda">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input v-model="password" type="password" class="form-control" placeholder="Masukan Password Anda">
                    </div>
                    <div class="col">
                        <div class="custom-control custom-control-alternative text-end">
                           <label class="label"><span style="cursor:pointer" class="text-primary" @click="tolupaadmin()">Lupa Password ?</span></label>
                        </div>
                    </div>
                  <div class="text-center my-4 mb-2">
                    <argon-button color="warning" @click="loginAdmin" size="md" fullWidth variant="">Login</argon-button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!--   Core JS Files   -->

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
  tolupaadmin(){
    this.$router.push('/lupaadmin')
  },
  getLoggedIn() {
          this.loggedIn = localStorage.getItem("token");
          if (window.localStorage.getItem("role") == 'Admin') {
              return this.$router.push({ name: "Dashboard" });
          }if (window.localStorage.getItem("role") == 'Pegawai') {
              return this.$router.push({ name: "Dashboard Pegawai" });
          }if (window.localStorage.getItem("role") == 'Manager') {
              return this.$router.push({ name: "Dashboard Superadmin" });
          }
      },
  topegawai(){
    this.$router.push('/loginpegawai')
  },
  toadmin(){
    this.$router.push('/login')
  },
  loginAdmin(e) {
          e.preventDefault()
              this.$axios.get('/sanctum/csrf-cookie').then(response => {
                  this.$axios.post('api/teslogin', {
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
                              window.localStorage.setItem("nama_perusahaan", response.data.user.nama_perusahaan)
                              window.localStorage.setItem("namapt", response.data.namapt)
                              window.localStorage.setItem("status", response.data.user.status)
                              navigator.geolocation.getCurrentPosition(
                              function (position) {
                                    window.localStorage.setItem("lat", position.coords.latitude)
                                    window.localStorage.setItem("lon", position.coords.longitude)
                                  },
                                  error => {
                                    console.log(error.message);
                                  },
                              )

                              if (response.data.user.role == 'Manager') {
                                  this.$router.push("/superadmindashboard")
                              } else if (response.data.user.role == 'Admin') {
                                  this.$router.push("/dashboard-default")
                              } else if (response.data.user.role == 'Pegawai') {
                                  this.$router.push("/PegawaiDashboard")
                              }
                              this.loggedIn = true;
                          } else {
                              this.error = response.data.message
                          }

          }if(response.data.success == null){
            const toast = useToast();
                toast.error("Login Gagal, Akun Belum Terverifikasi", {
                  position: "top-center",
                  timeout: 1500,
                  icon: "fa-solid fa-triangle-exclamation"
                });
          }if(response.data.akun == false){
            const toast = useToast();
                toast.error("Login Gagal, Terjadi Kesalahan", {
                  position: "top-center",
                  timeout: 1500,
                  icon: "fa-solid fa-triangle-exclamation"
                });
          }if(response.data.nonaktif == true){
            const toast = useToast();
                toast.error("Login Gagal, Akun Telah Dinonaktifkan", {
                  position: "top-center",
                  timeout: 1500,
                  icon: "fa-solid fa-triangle-exclamation"
                });
          }if(response.data.input == false) {
            const toast = useToast();
                toast.error("Login Gagal, Terjadi Kesalahan", {
                  position: "top-center",
                  timeout: 1500,
                  icon: "fa-solid fa-triangle-exclamation"
                });
          }if(response.data.error == true) {
            const toast = useToast();
                toast.error("Login Gagal, Input Salah", {
                  position: "top-center",
                  timeout: 1500,
                  icon: "fa-solid fa-triangle-exclamation"
                });
          }  
                    
                      })
                      .catch(function (error) {
                          console.error(error);
                      });
              })
      },
},  
mounted(){
  this.getLoggedIn()
         
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
