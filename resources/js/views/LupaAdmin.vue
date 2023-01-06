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
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Lupa Password Akun</h4>
                </div>
              </div>
              <div class="card-body">
                <div class="text-center text-muted mb-4">
               <span><b class="text-primary">Masukan Email Akun Anda</b></span>
              </div>
                <form role="form" class="text-start mt-3">
                    <div class="form-group">
                    <label for="exampleInputEmail1">Alamat Email</label>
                    <input v-model="email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="Masukan Email Anda">
                    </div>
                    <div class="custom-control custom-control-alternative custom-checkbox text-end">
                  <label class="custom-control-label" for=" customCheckLogin"><span style="cursor:pointer" class="text-primary" @click="toadmin()">Halaman Login</span></label>
                </div>
                  <div class="text-center mb-2 mt-4">
                    <argon-button color="warning" @click.prevent="lupaadmin()" size="md" fullWidth variant="">Send OTP </argon-button>
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
    <!-- <div class="container mt-8 mb-10">
      <div class="row justify-content-center ">
        <div class="col-lg-4 ">
          <div class="card shadow border-0">
            <div class="card-header bg-gradient-primary">
              <div class="text-center text-muted mb-1">
               <span><b class="text-white text-lg">Form Forgot Password</b></span>
              </div>
            </div>
            <div class="card-body">
              <div class="text-center text-muted mb-4">
               <span><b class="text-primary">Masukan Email Perusahaan</b></span>
              </div>
              <form role="form">
                <argon-input v-model="email" size="lg" placeholder="Email" type="email"></argon-input>
                <div class="custom-control custom-control-alternative custom-checkbox text-end">
                  <label class="custom-control-label" for=" customCheckLogin"><span style="cursor:pointer" class="text-primary" @click="toadmin()">Back To Login ?</span></label>
                </div>
                <div class="text-center">
                  <div class="my-4">
                    <argon-button color="primary" @click.prevent="lupaadmin()" size="md" fullWidth variant="gradient">Send OTP</argon-button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div> -->
</template>

<script>
import ArgonInput from "../components/ArgonInput.vue";
import ArgonSwitch from "../components/ArgonSwitch.vue";
import ArgonButton from "../components/ArgonButton.vue";
import {useToast} from 'vue-toastification';

const body = document.getElementsByTagName("body")[0];

export default {
  data() {
        return {
            email: "",
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
    display() {
      console.log("clicked")
      this.show = !this.show
    },
    toadmin(){
      this.$router.push('/login')
    },  
    topegawai(){
      this.$router.push('/loginpegawai')
    },  
    lupaadmin() {
            let timerInterval
              Swal.fire({
              title: 'Harap Tunggu!',
              text: 'Kami Sedang Mengecek dan Mengirimkan OTP ke Email Anda, Jika Berhasil Halaman Ini Akan Diarahkan ke Buat Password Baru',
              timer: 4000,
              timerProgressBar: true,
              didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                    }, 100)
                   },
                    willClose: () => {
                    clearInterval(timerInterval)
                   }
                }).then(()=>{
                  this.$axios.post('/api/password/emailadmin', {
                      email: this.email,
                  }).then((response)=>{
                      if (response.data.success == false){
                          const toast = useToast();
                                toast.error("Maaf Email Tidak Terdaftar", {
                                position: "top-center",
                                timeout: 2000,
                                icon: "fa-solid fa-triangle-exclamation"
                              });
                        }if(response.data.success){
                                const toast = useToast();
                                toast.success("Email Telah Terkirim", {
                                position: "top-center",
                                timeout: 2000,
                                icon: "fa-solid fa-square-check"
                              });
                                this.$router.push("/resetadmin");  
                     }
                  })  
                })           
            }  
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
