<template>
  <nav
    style="z-index: 1 !important; "
    class="navbar navbar-main navbar-expand-lg px-0 ms-2 me-4 border-radius-lg"
    :class="
      this.$store.state.isRTL ? 'top-0 position-sticky' : ''
    "
    v-bind="$attrs"
    id="navbarBlur"
    data-scroll="true"
  >
    <div class="px-3 py-1 container-fluid" >
      <breadcrumbs :currentPage="currentRouteName" textWhite="text-white" />

      <div
        class="mt-2 collapse navbar-collapse mt-sm-0 me-md-0 me-sm-4"
        :class="this.$store.state.isRTL ? 'px-0' : 'me-sm-4'"
        id="navbar"
      >
        <div
          class="pe-md-3 d-flex align-items-center"
          :class="this.$store.state.isRTL ? 'me-md-auto' : 'ms-md-auto'"
        >
        </div>
      </div>
        <img :src="sidebar" style="width:16px; height:16px; cursor:pointer" class="me-3" @click="toggleSidebar"  id="iconNavbarSidenav"/>
      <!-- <i style="cursor:pointer" class="fa-solid fa-bars text-white me-3 fs-6"  @click="toggleSidebar"  id="iconNavbarSidenav"></i> -->
      <i class="fa-solid fa-bell text-white me-3 fs-6"></i>
      <div class="btn-group me-3">
        <span
              href="#"
              class="text-white border-none shadow-none dropdown-toggle bg-transparent fw-bold fs-7"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              style="cursor:pointer"
            >
            
            <i
                class="fa fa-user bg-white text-primary p-1" style="border-radius: 50%"
                :class="this.$store.state.isRTL ? 'ms-sm-2' : 'me-sm-2'"
              ></i>
              <span v-if="this.$store.state.isRTL" class="d-sm-inline d-none"
                >يسجل دخول</span
              >
              <span v-else class="d-sm-inline d-none" >{{name}}</span>
          </span>
          <ul v-if="role == 'Admin'"
              class="dropdown-menu dropdown-menu-end" style="margin-top:10px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);"
              aria-labelledby="dropdownMenuButton"
            >
              <li class="mb-2" @click="adminprofile">
                <a class="dropdown-item border-radius-md">
                  <div class="py-1 d-flex">
                    <div class="d-flex flex-column justify-content-center" >
                      <h6 class="mb-1 text-sm font-weight-normal">
                        <span><i class="far fa-user text-warning"></i></span>
                        <span style="margin-left:5px; cursor: pointer;" class="font-weight-bold">Informasi Akun</span>
                      </h6>
                    </div>
                  </div>
                </a>
              </li>
              <li class="mb-2" @click="logout">
                <a class="dropdown-item border-radius-md">
                  <div class="py-1 d-flex">
                    <div class="d-flex flex-column justify-content-center">
                     
                      <h6 class="mb-1 text-sm font-weight-normal">
                        <span><i class="fas fa-sign-out-alt text-primary"></i></span>
                        <span style="margin-left:5px; cursor:pointer" class="font-weight-bold">Logout</span>
                      </h6>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
            <ul v-if="role == 'Pegawai'"
              class="dropdown-menu dropdown-menu-end" style="margin-top:10px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);"
              aria-labelledby="dropdownMenuButton"
            >
              <li class="mb-2" @click="pegawaiprofile">
                <a class="dropdown-item border-radius-md">
                  <div class="py-1 d-flex">
                    <div class="d-flex flex-column justify-content-center" >
                      <h6 class="mb-1 text-sm font-weight-normal">
                        <span><i class="far fa-user text-warning"></i></span>
                        <span @click="pegawaiprofile" style="margin-left:5px; cursor: pointer;" class="font-weight-bold">Informasi Akun</span>
                      </h6>
                    </div>
                  </div>
                </a>
              </li>
              <li class="mb-2" @click="logout">
                <a class="dropdown-item border-radius-md">
                  <div class="py-1 d-flex">
                    <div class="d-flex flex-column justify-content-center">
                     
                      <h6 class="mb-1 text-sm font-weight-normal">
                        <span><i class="fas fa-sign-out-alt text-primary"></i></span>
                        <span style="margin-left:5px; cursor:pointer" class="font-weight-bold">Logout</span>
                      </h6>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
            <ul v-if="role == 'Manager'"
              class="dropdown-menu dropdown-menu-end" style="margin-top:10px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);"
              aria-labelledby="dropdownMenuButton"
            >
              <li class="mb-2" @click="superadminprofile">
                <a class="dropdown-item border-radius-md">
                  <div class="py-1 d-flex">
                    <div class="d-flex flex-column justify-content-center" >
                      <h6 class="mb-1 text-sm font-weight-normal">
                        <span><i class="far fa-user text-warning"></i></span>
                        <span style="margin-left:5px; cursor: pointer;" class="font-weight-bold">Informasi Akun</span>
                      </h6>
                    </div>
                  </div>
                </a>
              </li>
              <li class="mb-2" @click="logout">
                <a class="dropdown-item border-radius-md">
                  <div class="py-1 d-flex">
                    <div class="d-flex flex-column justify-content-center">
                     
                      <h6 class="mb-1 text-sm font-weight-normal">
                        <span><i class="fas fa-sign-out-alt text-primary"></i></span>
                        <span style="margin-left:5px; cursor:pointer" class="font-weight-bold">Logout</span>
                      </h6>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
</div>
    </div>
  </nav>
</template>
<script>
import Breadcrumbs from "../Breadcrumbs.vue";
import { mapMutations, mapActions } from "vuex";
import ArgonButton from "../../components/ArgonButton.vue";
import ClickOutside from 'vue-click-outside'
import sidebar from "../../assets/img/menu.png";

export default {
  components: {
    ArgonButton,
  },
  directives: {
    ClickOutside
  },
  name: "navbar",
  data() {
    return {
      cek:[],
      infopt:[],
      sidebar,
      superadmindata:[],
      showMenu: false,
      loggedIn: localStorage.getItem("loggedIn"),
      token: localStorage.getItem("token"),
      name: localStorage.getItem("name"),
      role: localStorage.getItem("role")
    };
  },
  props: ["minNav", "textWhite"],
  created() {
    this.minNav;
  },
  methods: {
    ceking(){
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/ceking',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.cek = response.data.data;
                }).then(()=>{
                  window.localStorage.setItem("status", response.data.data.status)
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
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
    },  
    adminprofile(){
      this.$router.push({name: "Profil Admin"})
    },
    pegawaiprofile(){
      this.$router.push({name: "Profil Pegawai"})
    },
    superadminprofile(){
      this.$router.push({name: "Profil Superadmin"})
    },
    pegawaiprofile(){
      this.$router.push({name: "Profil Pegawai"})
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
    logout() {
      if(this.role == "Pegawai"){
          this.removelok()
       }
      this.$axios.post('/api/logout', {
                        tok: this.token
                    },
                    {
                        headers: {
                            Authorization: "Bearer " + this.token
                        }
                    }).then((response) => {
                    localStorage.clear()
                    this.$router.push('/login')
                    window.localStorage.removeItem("ceklat")
                    window.localStorage.removeItem("ceklon")
                })
        },
    ...mapMutations(["navbarMinimize"]),
    // ...mapActions(["toggleSidebarColor"]),

    toggleSidebar() {
      // this.toggleSidebarColor("bg-white");
      this.navbarMinimize();
    },
    hide () {
      this.navbarMinimize();
    }
  },
  components: {
    Breadcrumbs,
    ArgonButton
  },
  mounted(){

  },  
  computed: {
    currentRouteName() {
      return this.$route.name;
    }
  }
};
</script>
