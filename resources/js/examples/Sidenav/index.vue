<template>
  <div
    v-show="this.$store.state.layout === 'default'"
    class=" position-absolute w-100"
    :class="`${this.$store.state.darkMode ? 'bg-transparent' : ''}`"
  />
  <aside
  style="z-index: 999 !important"
    class="my-3 overflow-auto border-0 sidenav navbar navbar-vertical navbar-expand-xs border-radius-xl"
    :class="`${
      this.$store.state.isRTL
        ? 'me-3 rotate-caret fixed-end'
        : 'fixed-start ms-3'
    } 
    ${
      this.$store.state.layout === 'landing'
        ? 'bg-transparent shadow-none'
        : ' '
    } ${this.$store.state.sidebarType}`"
    id="sidenav-main"
  >
    <div class="sidenav-header" v-if="role == 'Admin'">
      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>
      <a class="m-0 navbar-brand" v-for="data in infopt" :key="data.id" >
        <img
          :src="
            this.$store.state.darkMode ||
            this.$store.state.sidebarType === 'bg-default'
              ? logoWhite
              : logo
          "
          class="navbar-brand-img h-100"
          alt="main_logo"
        />
        <span class="ms-2 font-weight-bold me-2" >{{data.nama_perusahaan}}</span>
      </a>
    </div>
    <div class="sidenav-header" v-if="role == 'Manager'">
      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>
      <a class="m-0 navbar-brand" v-for="data in superadmindata" :key="data.id">
        <img
          :src="
            this.$store.state.darkMode ||
            this.$store.state.sidebarType === 'bg-default'
              ? logoWhite
              : logo
          "
          class="navbar-brand-img h-100"
          alt="main_logo"
        />
        <span class="ms-2 font-weight-bold me-2" >{{data.nama_perusahaan}}</span>
      </a>
    </div>
    <hr class="mt-0 horizontal dark" />
    <sidenav-list :cardBg="custom_class" />
  </aside>
</template>
<script>
import SidenavList from "./SidenavList.vue";
import logo from "../../assets/img/logo-ct-dark.png";
import logoWhite from "../../assets/img/logo-ct.png";

export default {
  name: "index",
  components: {
    SidenavList
  },
  data() {
    return {
      infopt:[],
      logo,
      superadmindata:[],
      logoWhite,
      pegawais: [],
      loggedIn: localStorage.getItem("loggedIn"),
      token: localStorage.getItem("token"),
      name: localStorage.getItem("name"),
      role: localStorage.getItem("role")
    };
  },
  created(){

  }, 
  methods:{
    superadmin(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/superadmin',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.superadmindata = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    ptinfo(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/infopt',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.infopt = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    }  
  },
  mounted(){
    this.ptinfo()
    this.superadmin()
  },
  props: ["custom_class", "layout"],

};
</script>
