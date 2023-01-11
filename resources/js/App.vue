<template>
   <div v-if="loggedIn" class="container-fluid bg-gray-100" style="background-color: blue;z-index: 1 !important;width: 2000px !important; height: 35px !important; position: fixed;color: transparent;">Tes</div>
  <div
    v-show="this.$store.state.layout === 'landing'"
    class="landing-bg h-100 bg-gradient-primary position-fixed w-100">
  </div>
    <div v-if="!loggedIn" style="visibility: hidden !important">
    </div>
    <sidenav  v-if="loggedIn"/>
  <main class="main-content max-height-vh-100 h-100">
    <!-- nav -->
    <navbar v-if="loggedIn" class="position-sticky bg-primary left-auto top-2 "/>
    <navbar v-else-if="!loggedIn" class="position-sticky bg-primary left-auto top-2" style="display:none"/>
    <div v-if="loggedIn" class="mt-3" style="margin-start: -1rem">
     <router-view />
    </div>
    <div v-else-if="!loggedIn">
     <router-view />
    </div>
  </main>
</template>
<script>
import Sidenav from "./examples/Sidenav/index.vue";
import Navbar from "./examples/Navbars/Navbar.vue";
import Tes from "./examples/Tes/Tes.vue"
import { mapMutations } from "vuex";
export default {
  data() {
        return {
            token: localStorage.getItem("token"),
            status: localStorage.getItem("status"),
            role: localStorage.getItem("role"),
            exp: localStorage.getItem("expired_at"),
            statuspegawai: [],
            statusadmindat: [],
            loggedIn: null,
            statusPage: null
        };
    },
  name: "App",
  components: {
    Sidenav,
    Tes,
    Navbar,
  },
  methods: {
    getstatuspegawai(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/getstatuspegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.statuspegawai = response.data.data;
                    if(this.statuspegawai == "Tidak Aktif"){
                      localStorage.removeItem("token")
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    getstatusadmin(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/getstatusadmin',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.statusadmindat = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    statuspeg(){
      if(this.loggedIn !== null && this.role == "Pegawai"){
        this.getstatuspegawai()
      }else{
        return
      }
    },
    statusadmin(){
      if(this.loggedIn !== null && this.role == "Admin"){
        this.getstatusadmin()
      }else{
        return
      }
    },
    getLoggedIn() {
            this.loggedIn = localStorage.getItem("token");
        },
      ceking(){
        
       
      },
    logout() {
      this.$axios.post('/api/logout', {
                        tok: this.token
                    },
                    {
                        headers: {
                            Authorization: "Bearer " + this.token
                        }
                    }).then((response) => {
                    localStorage.clear()
                    return this.$router.push({ name: "/" });
                })
        },    
        removelok(){
      var token =  localStorage.getItem("token")
              this.$axios.post('/api/lokasi', {
                latitude: null,
                longitude: null
              },
                {
                  headers : { Authorization: "Bearer " + token },
                },
                )
    }, 
    ...mapMutations(["toggleConfigurator", "navbarMinimize"])
  },
  computed: {
    navClasses() {
      return {
        "position-sticky bg-white left-auto top-2 z-index-sticky":
          this.$store.state.isNavFixed && !this.$store.state.darkMode,
        "position-sticky bg-default left-auto top-2 z-index-sticky":
          this.$store.state.isNavFixed && this.$store.state.darkMode,
        "position-absolute px-4 mx-0 w-100 z-index-2": this.$store.state
          .isAbsolute,
        "px-0 mx-4": !this.$store.state.isAbsolute
      };
    }
  },
  watch: {
        $route: {
            immediate: true,
            handler() {
                this.getLoggedIn();
            },
        },
    },
  mounted(){
    this.getLoggedIn()
    this.ceking()
    this.statusadmin()
    this.statuspeg()
  },
  created(){
    this.$axios.interceptors.response.use(function (response) {
    return response;
    }, function (error) {
    if(error.response.status === 401) {
        localStorage.clear()
        window.location.href = "/login";
    }
    return Promise.reject(error);
  });
  },
  beforeMount() {
        this.$store.state.isTransparent = "bg-transparent";
    },

};
</script>
