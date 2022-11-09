<!--
=========================================================
* Vue Argon Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://creative-tim.com/product/vue-argon-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<template>
  <div v-if="loggedIn" class="container-fluid bg-gray-100" style="background-color: blue;z-index: 1 !important;width: 2000px !important; height: 35px !important; position: fixed;color: transparent;">Tes</div>
  <div
    v-show="this.$store.state.layout === 'landing'"
    class="landing-bg h-100 bg-gradient-primary position-fixed w-100">
  </div>
    <div v-if="!loggedIn" style="visibility: hidden !important">
    </div>
    <sidenav  v-if="loggedIn"/>
  <main class="main-content max-height-vh-100 h-100 border-radius-lg">
    <!-- nav -->
    <navbar class="position-sticky bg-primary left-auto top-2 "
      :class="[navClasses]"
      :textWhite="this.$store.state.isAbsolute ? 'text-white opacity-8' : 'text-white'"
      :minNav="navbarMinimize"
      v-if="this.$store.state.showNavbar"
    />
    <div  class="mt-3">
     <router-view />
    </div>
  </main>
</template>
<script>
import Sidenav from "./examples/Sidenav/index.vue";
import Navbar from "./examples/Navbars/Navbar.vue";
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
        window.location.href = "/";
    }
    return Promise.reject(error);
  });
  },
  beforeMount() {
        this.$store.state.isTransparent = "bg-transparent";

    },
};
</script>
