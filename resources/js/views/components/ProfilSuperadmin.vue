<template>
  <div class="card bg-gray-100 shadow-none" v-if="role == 'Manager'">
    <div class="row">
      <div class="col">
        <div class="card" style=" overflow-y: auto">
          <div class="card-header pb-0">
            <div class="d-flex align-items-center">
              <p class="mb-0">Profile SuperAdmin</p>
              <argon-button color="primary"  size="sm" class="ms-auto"
                >Update Password</argon-button
              >
              <argon-button color="info"  size="sm" class="ms-2"
                >Update Data</argon-button
              >
            </div>
          </div>
          <div class="card-body" v-for="(data) in superadmin" :key="data.id">
            <p class="text-uppercase text-sm">Informasi Akun</p>
            <div class="row">
              <div class="col-md-6">
                <label for="example-text-input" class="form-control-label"
                  >Username</label
                >
                <div class="form-control form-control-md">{{data.name}}</div>
              </div>
              <div class="col-md-6">
                <label for="example-text-input" class="form-control-label"
                  >Email address</label
                >
                <div class="form-control form-control-md">{{data.email}}</div>
              </div>
            </div>
            <hr class="horizontal dark" />
            <p class="text-uppercase text-sm">Alamat Perusahaan</p>
            <div class="row">
              <div class="col-md-12">
                <label for="example-text-input" class="form-control-label"
                  >Alamat</label
                >
                <div class="form-control form-control-md">{{data.det_alamat}}</div>
              </div>
              <div class="col-md-4">
                <label for="example-text-input" class="form-control-label"
                  >Kota</label
                >
                <div class="form-control form-control-md">{{data.kota}}</div>
              </div>
              <div class="col-md-4">
                <label for="example-text-input" class="form-control-label"
                  >Provinsi</label
                >
                <div class="form-control form-control-md">{{data.provinsi}}</div>
              </div>
              <div class="col-md-4">
                <label for="example-text-input" class="form-control-label"
                  >Kode Pos</label
                >
                <div class="form-control form-control-md">{{data.kode_pos}}</div>
              </div>
            </div>
            <hr class="horizontal dark" />
            <p class="text-uppercase text-sm">Tentang</p>
            <div class="row">
              <div class="col-md-12">
                <label for="example-text-input" class="form-control-label"
                  >Moto Perusahaan</label
                >
                <argon-input
                  type="text"
                  value="A beautiful Dashboard for Bootstrap 5. It is Free and Open Source."
                />
                <label for="example-text-input" class="form-control-label"
                  >Website Perusahaan</label
                >
                <argon-input
                  type="text"
                  value="A beautiful Dashboard for Bootstrap 5. It is Free and Open Source."
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <profile-card />
      </div>
    </div>
  </div>
</template>

<script>
import ProfileCard from "../components/tes/ProfileCard.vue";
import ArgonInput from "../components/tes/ArgonInput.vue";
import ArgonButton from "../components/tes/ArgonButton.vue";
import setNavPills from "../../assets/js/nav-pills.js";
import setTooltip from "../../assets/js/tooltip.js";


export default {
name: "profile",
data() {
  return {
    infopt:[],
    superadmin:[],
    role: localStorage.getItem("role")
  };
},
components: { ProfileCard, ArgonInput, ArgonButton },
methods:{
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
  superadminprofile(){
    this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/superadmin',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.superadmin = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
  }
},
created(){
 
},
mounted() {
  this.ptinfo()
  this.superadminprofile()
  setNavPills();
  setTooltip();
},

};
</script>
