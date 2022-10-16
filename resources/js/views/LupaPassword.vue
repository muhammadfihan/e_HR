<template>
    <div class="container mt-8 mb-10">
      <div class="row justify-content-center ">
        <div class="col-lg-4 ">
          <div class="card shadow border-0">
            <div class="card-header bg-gradient-primary">
              <div class="text-center text-muted mb-1">
               <span><b class="text-white text-lg">Form Forgot Password Pegawai</b></span>
              </div>
            </div>
            <div class="card-body">
              <div class="text-center text-muted mb-4">
               <span><b class="text-primary">Masukan Email Pegawai</b></span>
              </div>
              <form role="form">
                <argon-input v-model="email" size="lg" placeholder="Email" type="email"></argon-input>
                <div class="custom-control custom-control-alternative custom-checkbox text-end">
                  <label class="custom-control-label" for=" customCheckLogin"><span style="cursor:pointer" class="text-primary" @click="topegawai()">Back To Login ?</span></label>
                </div>
                <div class="text-center">
                  <div class="my-4">
                    <argon-button color="primary" @click.prevent="lupapegawai()" size="md" fullWidth variant="gradient">Send OTP</argon-button>
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
import {useToast} from 'vue-toastification'

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
    toadmin(){
      this.$router.push('/')
    },  
    topegawai(){
      this.$router.push('/loginpegawai')
    },  

        lupapegawai() {
          let timerInterval
              Swal.fire({
              title: 'Harap Tunggu!',
              text: 'Kami Sedang Mengecek dan Mengirimkan OTP ke Email Anda',
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
                  this.$axios.post('/api/password/email', {
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
                                this.$router.push("/resetpassword");  
                     }
                  })   
                })
        },
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
