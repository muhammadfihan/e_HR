<template>
    <div class="container mt-8 mb-10">
      <div class="row justify-content-center ">
        <div class="col-lg-4 ">
          <div class="card shadow border-0">
            <div class="card-header bg-gradient-primary">
              <div class="text-center text-muted mb-1">
               <span><b class="text-white text-lg">Form Reset Password Pegawai</b></span>
              </div>
            </div>
            <div class="card-body">
              <div class="text-center text-muted mb-4">
               <span><b class="text-primary">Masukan OTP dan Password Baru</b></span>
              </div>
              <form role="form">
                <div class="d-flex justify-content-center align-items-center">
                  <v-otp-input
                  v-model="code"
                  ref="otpInput"
                  input-classes="otp-input"
                  :num-inputs="6"
                  :is-input-num="true"
                  @on-change="handleOnChange"
                />
                </div>
                <argon-input v-model="password" size="lg" placeholder="New Password" type="password"></argon-input>
                <div class="custom-control custom-control-alternative custom-checkbox text-end">
                  <label class="custom-control-label" for=" customCheckLogin"><span style="cursor:pointer; visibility:hidden" class="text-primary" @click="topegawai()">Back To Login ?</span></label>
                </div>
                <div class="text-center">
                  <div class="my-4">
                    <argon-button color="primary" @click.prevent="resetpegawai()" size="md" fullWidth variant="gradient">Reset Password</argon-button>
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
import VOtpInput from 'vue3-otp-input';

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
      this.$router.push('/')
    },  
    topegawai(){
      this.$router.push('/loginpegawai')
    },
    resetpegawai() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.post('/api/password/reset', {
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
                     this.$router.push("/loginpegawai");  
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
