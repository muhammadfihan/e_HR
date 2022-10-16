<template>
  <nav
    style="z-index: 1 !important; "
    class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl"
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
        <ul class="navbar-nav justify-content-end">
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a
              href="#"
              @click="toggleSidebar"
              class="p-0 nav-link text-white"
              id="iconNavbarSidenav"
            >
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line bg-white"></i>
                <i class="sidenav-toggler-line bg-white"></i>
                <i class="sidenav-toggler-line bg-white"></i>
              </div>
            </a>
          </li>
          <li class="px-3 nav-item d-flex align-items-center ">
          </li>
        </ul>
      </div>
      <div class="btn-group">
        <argon-button
              href="#"
              class="text-primary dropdown-toggle"
              color="white" size="sm"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
            
            <i
                class="fa fa-user"
                :class="this.$store.state.isRTL ? 'ms-sm-2' : 'me-sm-2'"
              ></i>
              <span v-if="this.$store.state.isRTL" class="d-sm-inline d-none"
                >يسجل دخول</span
              >
              <span v-else class="d-sm-inline d-none" >{{name}}</span>
          </argon-button>
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

export default {
  components: {
    ArgonButton,
  },
  name: "navbar",
  data() {
    return {
      cek:[],
      infopt:[],
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
      this.$router.push({name: "Admin Profile"})
    },
    superadminprofile(){
      this.$router.push({name: "Superadmin Profile"})
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
    ...mapMutations(["navbarMinimize", "toggleConfigurator"]),
    ...mapActions(["toggleSidebarColor"]),

    toggleSidebar() {
      this.toggleSidebarColor("bg-white");
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
