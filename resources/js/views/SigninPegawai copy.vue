<template>
    <div class="container mt-8 mb-10">
      <div class="row justify-content-center ">
        <div class="col-lg-4 ">
          <div class="card shadow border-0">
            <div class="card-header bg-gradient-primary">
              <div class="text-white text-center mb-3"><small>Login Sebagai</small></div>
              <div class="text-center">
                <argon-button @click="toadmin()" class="text-primary" style="margin-right:18px" color="white" size="sm" >Admin</argon-button>
                <argon-button @click="topegawai()" class="text-primary" color="white" size="sm">Pegawai</argon-button>
              </div>
            </div>
            <div class="card-body">
              <div class="text-center text-muted mb-4">
                <small>Anda Akan Login Sebagai</small><small><b class="text-primary"> Pegawai</b></small>
              </div>
              <form role="form">
                <argon-input v-model="email" placeholder="Email" type="email"></argon-input>
                <argon-input v-model="password" placeholder="Password" type="password"></argon-input>

                <div class="custom-control custom-control-alternative custom-checkbox text-end">
                  <label class="custom-control-label" for=" customCheckLogin"><span style="cursor:pointer" class="text-primary" @click="tolupapasword()">Forget Password ?</span></label>
                </div>
                <div class="text-center">
                  <div class="my-4">
                    <argon-button color="primary" @click.prevent="loginpegawai" size="md" fullWidth variant="gradient">Login Pegawai</argon-button>
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
    toadmin(){
      this.$router.push('/login')
    },  
    topegawai(){
      this.$router.push('/loginpegawai')
    },  
    tolupapasword(){
      this.$router.push('/lupapassword')
    },
    loginpegawai(e) {
            e.preventDefault()
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/loginpegawai', {
                        email: this.email,
                        password: this.password
                    }).then(response => {
                        if (response.data.success) {
                          const toast = useToast();
                  toast.success("Selamat Datang Kembali", {
                    position: "top-center",
                    timeout: 1500,
                    icon: "fa-solid fa-square-check"
                  })
                            if (response.data.success) {
                                window.localStorage.setItem("loggedIn", true)
                                window.localStorage.setItem("token", response.data.token)
                                window.localStorage.setItem("expired_at", response.data.expired_at)
                                window.localStorage.setItem("role", response.data.user.role)
                                window.localStorage.setItem("name", response.data.user.name)
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
                                    this.$router.push("/pegawaidashboard")
                                }
                                this.loggedIn = true;
                            } else {
                                this.error = response.data.message
                            }

            }
            else {
              const toast = useToast();
                  toast.error("Login Gagal, Terjadi Kesalahan", {
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
