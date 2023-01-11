<template>
  <div
    v-show="this.$store.state.layout === 'default'"
    class=" position-absolute w-100"
    :class="`${this.$store.state.darkMode ? 'bg-transparent' : ''}`"
  />
  <aside
  style="z-index: 999 !important;"
    class="bg-white fixed-start overflow-auto border-0 sidenav navbar navbar-vertical navbar-expand-xs"
    id="sidenav-main"
  >
    <div class="sidenav-header" v-if="role == 'Admin'">
      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>
      <a class="m-0 navbar-brand" >
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
        <span class="ms-2 font-weight-bold me-2" >{{nama_perusahaan}}</span>
        <!-- <i class='bx bx-chevron-right bg-primary text-white fw-bolder fs-4 ms-10' style="border-radius: 50%;height: 25px;width:25px;display: flex; align-items: center;justify-content: center;z-index: 999 !important; margin-top:-2rem; margin-right: 20rem"></i> -->
      </a>
    </div>

    <div class="sidenav-header" v-if="role == 'Pegawai'">
      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>
        <a class="m-0 navbar-brand">
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
        <span class="ms-2 font-weight-bold me-4" >{{namapt}}</span>
      </a>
      <!-- <img
          :src="menu
          "
          class="ms-11"
          alt="main_logo"
          style="cursor:pointer; width: 25px; position:absolute"
        /> -->
    </div>
    <div class="sidenav-header" v-if="role == 'Manager'">
      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>
      <a class="m-0 navbar-brand" >
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
        <span class="ms-2 font-weight-bold me-2" >{{nama_perusahaan}}</span>
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
// import menu from "../../assets/img/menu.png";
export default {
  name: "index",
  components: {
    SidenavList
  },
  data() {
    return {
      infopt:[],
      infoptpeg:[],
      logo,
      superadmindata:[],
      logoWhite,
      pegawais: [],
      loggedIn: localStorage.getItem("loggedIn"),
      token: localStorage.getItem("token"),
      name: localStorage.getItem("name"),
      role: localStorage.getItem("role"),
      nama_perusahaan: localStorage.getItem("nama_perusahaan"),
      namapt: localStorage.getItem("namapt")
    };
  },
  created(){

  }, 
  methods:{
    ptinfopeg(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/infoptpeg',{
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
    // this.ptinfopeg()
    // this.ptinfo()
    // this.superadmin()
  },
  props: ["custom_class", "layout"],

};
</script>
<style scoped>

:root{
    /* ===== Colors ===== */
    --body-color: #E4E9F7;
    --sidebar-color: #FFF;
    --primary-color: #695CFE;
    --primary-color-light: #F6F5FF;
    --toggle-color: #DDD;
    --text-color: #707070;

    /* ====== Transition ====== */
    --tran-03: all 0.2s ease;
    --tran-03: all 0.3s ease;
    --tran-04: all 0.3s ease;
    --tran-05: all 0.3s ease;
}
 .toggle{
    position: absolute;
    top: 50%;
    right: -25px;
    transform: translateY(-50%) rotate(180deg);
    height: 25px;
    width: 25px;
    background-color: var(--primary-color);
    color: var(--sidebar-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    cursor: pointer;
    transition: var(--tran-05);
}

</style>