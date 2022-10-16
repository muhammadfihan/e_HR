<template>
    <div class="container mt-8 mb-10">
      <div class="row justify-content-center">
        <div class="col-lg-4">
          <div class="card shadow border-0">
            <div class="card-header bg-gradient-primary">
              <div class="text-white text-center mb-3"><small>Login Sebagai</small></div>
              <div class="text-center">
                <argon-button class="text-primary" @click="toadmin()" style="margin-right:18px" color="white" size="sm" >Admin</argon-button>
                <argon-button class="text-primary" color="white" @click="topegawai()" size="sm">Pegawai</argon-button>
              </div>
            </div>
            <div class="card-body">
              <div class="text-center text-muted mb-4">
                <small>Anda Akan Login Sebagai</small><small><b class="text-primary"> Admin</b></small>
              </div>
              <form role="form">
                <argon-input v-model="email" placeholder="Email"  type="email"></argon-input>
                <argon-input v-model="password" placeholder="Password" type="password"></argon-input>
                <div class="col">
                  <div class="custom-control custom-control-alternative custom-checkbox text-end">
                    <label class="custom-control-label" for=" customCheckLogin"><span style="cursor:pointer" class="text-primary" @click="tolupaadmin()">Forget Password ?</span></label>
                  </div>
                </div>
               
                <div class="text-center">
                  <div class="my-4">
                    <argon-button color="primary" @click="loginAdmin" size="md" fullWidth variant="gradient">Login Admin</argon-button>
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
    tolupaadmin(){
      this.$router.push('/lupaadmin')
    },
    getLoggedIn() {
            this.loggedIn = localStorage.getItem("token");
            if (window.localStorage.getItem("role") == 'Admin') {
                return this.$router.push({ name: "Dashboard" });
            }if (window.localStorage.getItem("role") == 'Pegawai') {
                return this.$router.push({ name: "Dashboard" });
            }if (window.localStorage.getItem("role") == 'Manager') {
                return this.$router.push({ name: "Dashboard Superadmin" });
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
