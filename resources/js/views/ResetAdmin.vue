<template>
    <body class="bg-gray-200">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-color: #F5F5FC;">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-5 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Halaman Reset Password</h4>
                </div>
              </div>
              <div class="card-body">
                <div class="text-center text-muted mb-4">
               <span><b class="text-primary">Masukan Code OTP Dari Email dan Password Baru Anda</b></span>
              </div>
                <form role="form" class="text-start">
                    <div class="form-group">
                    <label for="exampleInputEmail1">Code OTP</label>
                    <input v-model="code" type="number" class="form-control" aria-describedby="emailHelp" placeholder="Masukan Code OTP Anda">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password Baru</label>
                        <input v-model="password" type="password" class="form-control" placeholder="Masukan Password Baru Anda">
                    </div>
                    <div class="col">
                        <div class="custom-control custom-control-alternative text-end">
                           <label class="label"><span style="cursor:pointer" class="text-primary" @click="toadmin()">Halaman Login</span></label>
                        </div>
                    </div>
                  <div class="text-center my-4 mb-2">
                    <argon-button color="warning" @click.prevent="lupaadmin()" size="md" fullWidth variant="">Buat Password Baru</argon-button>
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
import {useToast} from 'vue-toastification'
import VOtpInput from 'vue3-otp-input';

const body = document.getElementsByTagName("body")[0];

export default {
  
  data() {
        return {
            email: "",
            code:"",
            password: "",
            role :"",
            error: null,
            loggedIn: localStorage.getItem("loggedIn"),
            token: localStorage.getItem("token"),

        }
    },
  name: "signin",
  components: {
    VOtpInput,
    ArgonInput,
    ArgonSwitch,
    ArgonButton,
  },
  methods:{
    handleOnChange(value) {
      console.log(value);
      this.code = value
    },
    toadmin(){
      this.$router.push('/login')
    },  
    topegawai(){
      this.$router.push('/loginpegawai')
    }, 
    lupaadmin() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.post('/api/password/resetadmin', {
                        code: this.code,
                        password: this.password,

                    }).then((response) => {
                if (response.data.success){
                  const toast = useToast();
                      toast.success("Password Berhasil Diubah, Silahkan Login", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      })
                     this.$router.push("/login");  
                }
                if (response.data.success == false){
                  const toast = useToast();
                      toast.error("Gagal, Code Telah Expired", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-triangle-exclamation"
                      })
                }
                if (response.data.success == null){
                  const toast = useToast();
                      toast.error("Code Tidak Valid", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-triangle-exclamation"
                      })
                }
                    
                    }
                )
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
<style>
.otp-input {
  width: 40px;
  height: 40px;
  padding: 5px;
  margin: 0 7px;
  margin-bottom:20px;
  display:flex;
  display:inline-block;
  align-items:center;
  justify-content:center; 
  font-size: 20px;
  border-radius: 4px;
  border: 1px solid rgba(0, 0, 255, 0.3);
}
/* Background colour of an input field with value */
.otp-input.is-complete {
  background-color: #ffffff;
}
.otp-input::-webkit-inner-spin-button,
.otp-input::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
