<template>
  <div class="card card-profile" v-if="role == 'Admin'">
    <img src="../../../assets/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top" />
    <div class="row justify-content-center">
      <div class="col-4 col-lg-4 order-lg-2">
        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
          <a href="javascript:;">
            <img
              src="../../../assets/img/logo.png"
              class="rounded-circle img-fluid border border-3 border-black"
            />
          </a>
        </div>
      </div>
    </div>
    <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
      <div class="d-flex justify-content-between">
        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-none d-lg-block"><span><i class="fa-solid fa-arrow-up-from-bracket me-1"></i></span>Logo</a>
        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none">
          <i class="ni ni-collection"></i>
        </a>
        <a
          href="javascript:;"
          class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block"
        ><span><i class="fa-solid fa-arrow-up-from-bracket me-1"></i></span> Image</a>
        <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none">
          <i class="ni ni-email-83"></i>
        </a>
      </div>
    </div>
    <div class="card-body pt-0" v-for="data in infopt" :key="data.id">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-center">
            <div class="d-grid text-center">
              <span class="text-lg font-weight-bolder">{{data.jumlah_karyawan}}</span>
              <span class="text-sm opacity-8">Karyawan</span>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center mt-4">
        <h5>
          {{data.nama_perusahaan}}
        </h5>
        <div class="h6 font-weight-300">
          <i class="ni location_pin mr-2"></i>{{data.kota}}, {{data.provinsi}}
        </div>
        <div class="h6 mt-4">
          <i class="ni business_briefcase-24 mr-2"></i>{{data.jabatan}} - {{data.bidang}}
        </div>
        <div>
          <i class="ni education_hat mr-2"></i>{{data.nama_perusahaan}}
        </div>
      </div>
    </div>
  </div>

  <div class="card card-profile" v-if="role == 'Manager'">
    <img src="../../../assets/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top" />
    <div class="row justify-content-center">
      <div class="col-4 col-lg-4 order-lg-2">
        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
          <a href="javascript:;">
            <img
              src="../../../assets/img/logo.png"
              class="rounded-circle img-fluid border border-3 border-black"
            />
          </a>
        </div>
      </div>
    </div>
    <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
      <div class="d-flex justify-content-between">
        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-none d-lg-block"><span><i class="fa-solid fa-arrow-up-from-bracket me-1"></i></span>Logo</a>
        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none">
          <i class="ni ni-collection"></i>
        </a>
        <a
          href="javascript:;"
          class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block"
        ><span><i class="fa-solid fa-arrow-up-from-bracket me-1"></i></span> Image</a>
        <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none">
          <i class="ni ni-email-83"></i>
        </a>
      </div>
    </div>
    <div class="card-body pt-0" v-for="data in superadmin" :key="data.id">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-center">
            <div class="d-grid text-center">
              <span class="text-lg font-weight-bolder">{{data.jumlah_karyawan}}</span>
              <span class="text-sm opacity-8">Karyawan</span>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center mt-4">
        <h5>
          {{data.nama_perusahaan}}
        </h5>
        <div class="h6 font-weight-300">
          <i class="ni location_pin mr-2"></i>{{data.kota}}, {{data.provinsi}}
        </div>
        <div class="h6 mt-4">
          <i class="ni business_briefcase-24 mr-2"></i>{{data.jabatan}} - {{data.bidang}}
        </div>
        <div>
          <i class="ni education_hat mr-2"></i>{{data.nama_perusahaan}}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "profile-card",
  data(){
    return {
      infopt:[],
      superadmin:[],
      role: localStorage.getItem("role")
    }
  },
  methods:{
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
    },
    adminprofile(){
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
  created(){
  },
  mounted(){
    this.superadminprofile()
    this.adminprofile()
  }
};
</script>