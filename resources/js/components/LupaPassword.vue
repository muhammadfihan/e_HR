<template>
     <div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="login-aside d-flex flex-column flex-row-auto">
					<!--begin::Aside Top-->
					<div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
						<!--begin::Aside header-->
						<a href="#" class="login-logo text-center pt-lg-25 pb-10">
							<img src="assets/media/logos/custom.png" class="max-h-70px" style="border-radius:10px" alt="" />
						</a>
						<!--end::Aside header-->
						<!--begin::Aside Title-->
						<h3 class="font-weight-bolder text-center font-size-h4 text-dark-50 line-height-xl">User Experience &amp; Interface Design
						<br />Strategy SaaS Solutions</h3>
						<!--end::Aside Title-->
					</div>
					<!--end::Aside Top-->
					<!--begin::Aside Bottom-->
					<div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-x-center" style="background-position-y: calc(100% + 5rem); background-image: url(assets/media/svg/illustrations/login-visual-5.svg)"></div>
					<!--end::Aside Bottom-->
				</div>
				<!--begin::Aside-->
				<!--begin::Content-->
				<div class="login-content flex-row-fluid d-flex flex-column p-10">
					<!--begin::Top-->
					<div class="text-right d-flex justify-content-center">
						<div class="top-signin text-right d-flex justify-content-end pt-5 pb-lg-0 pb-10" @click="reload()">
						</div>
					</div>
					<!--end::Top-->
					<!--begin::Wrapper-->
					<div class="d-flex flex-row-fluid flex-center">
						<!--begin::Forgot-->
						<div class="login-form">
							<!--begin::Form-->
							<form class="form" action="">
								<!--begin::Title-->
								<div class="pb-5 pb-lg-15">
									<h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Lupa Password ?</h3>
									<p class="text-muted font-weight-bold font-size-h4">Masukan Email Untuk Membuat Password Baru</p>
								</div>
								<!--end::Title-->
								<!--begin::Form group-->
								<div class="form-group">
									<input class="form-control h-auto py-7 px-6 border-0 rounded-lg font-size-h6" type="email" placeholder="Email" v-model="email" name="email" autocomplete="off" />
								</div>
								<!--end::Form group-->
								<!--begin::Form group-->
								<div class="form-group d-flex flex-wrap">
									<button type="submit" id="kt_login_forgot_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4" @click.prevent="passwordlupa()">Submit</button>
									<a @click.prevent="loginlagi()" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</a>
								</div>
								<!--end::Form group-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Forgot-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Login-->
		</div>
      
</template>

<script>


import stubFalse from "lodash/stubFalse";
import Dashboard from "./Dashboard";
export default {
    components: {Dashboard},
    mounted() {
    
    },
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
    methods: {
        reset_admin() {
        document.getElementById("reset_admin").reset();
        localStorage.clear()
        },
        reset_peg() {
        document.getElementById("reset_peg").reset();
        localStorage.clear();
        },
         loginlagi(){
          this.$router.push("/Login");  
        },

        toPegawai(){
          this.$router.push("/LoginPegawai");  
        },
         toRegister(){
          this.$router.push("/");  
        },
        reload(){
          location.reload()
        },

        loginAdmin(e) {
            e.preventDefault()
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/login', {
                        email: this.email,
                        password: this.password
                    }).then(response => {
                        if (response.data.success) {
              Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                text: 'Anda berhasil masuk',
                showConfirmButton: false,
                timer: 1500
              })
                            if (response.data.success) {
                                window.localStorage.setItem("loggedIn", true)
                                window.localStorage.setItem("token", response.data.token)
                                window.localStorage.setItem("role", response.data.user.role)
                                window.localStorage.setItem("name", response.data.user.name)

                                if (response.data.user.role == 'Manager') {
                                    this.$router.push("/SuperAdminDashboard")
                                } else if (response.data.user.role == 'Admin') {
                                    this.$router.push("/AdminDashboard")
                                } else if (response.data.user.role == 'Pegawai') {
                                    this.$router.push("/PegawaiDashboard")
                                }
                                this.loggedIn = true;
                            } else {
                                this.error = response.data.message
                            }

            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal!!',
                    text: 'Terjadi Kesalahan',
                    showConfirmButton: false,
                    timer: 1800
                })
            }  
                      
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
        },
        loginPegawai(e) {
            e.preventDefault()
            if (this.password.length > 0) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/loginpegawai', {
                        email: this.email,
                        password: this.password
                    })
                        .then(response => {
                            console.log(response.data)
                            if (response.data.success) {
                                window.localStorage.setItem("loggedIn", true)
                                window.localStorage.setItem("token", response.data.token)
                                window.localStorage.setItem("role", response.data.user.role)
                                window.localStorage.setItem("name", response.data.user.name)

                                if (response.data.user.role == 'Manager') {
                                    this.$router.push("/SuperAdminDashboard")
                                } else if (response.data.user.role == 'Admin') {
                                    this.$router.push("/AdminDashboard")
                                } else if (response.data.user.role == 'Pegawai') {
                                    this.$router.push("/PegawaiDashboard")
                                }
                                this.loggedIn = true;
                            } else {
                                this.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
            }
        },
        passwordlupa() {
            Swal.fire({
                title: 'Mohon Tunggu Sebentar',
                text: "Kami Sedang Mengirim Email",
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 8000,
                onOpen: () => {
                swal.showLoading();
                }
            })
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.post('/api/lupa', {
                        email: this.email,
                    })
                    .then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Email Telah Dikirim Silahkan Cek Email",
                        showConfirmButton: false,
                        timer: 2000,
                    })
                     this.$router.push("/LoginPegawai");  
                }
                    
                    }
                )
                    })
        },
    },
     
    beforeRouteEnter(to, from, next) {
        if (JSON.parse(window.localStorage.getItem("loggedIn"))) {
            if (window.localStorage.getItem("role") == 'Manager') {
                return next("/SuperAdminDashboard");
            } else if (window.localStorage.getItem("role") == 'Admin') {
                return next("/AdminDashboard");
            } else if (window.localStorage.getItem("role") == 'Pegawai') {
                return next("/PegawaiDashboard");
            }
        }
        next();
    },

}
</script>

 <!-- console.log(response.data)
                            if (response.data.success) {
                                window.localStorage.setItem("loggedIn", true)
                                window.localStorage.setItem("token", response.data.token)
                                window.localStorage.setItem("role", response.data.user.role)
                                window.localStorage.setItem("name", response.data.user.name)

                                if (response.data.user.role == 'Manager') {
                                    this.$router.push("/ManagerDashboard")
                                } else if (response.data.user.role == 'Admin') {
                                    this.$router.push("/AdminDashboard")
                                } else if (response.data.user.role == 'Pegawai') {
                                    this.$router.push("/PegawaiDashboard")
                                }
                                this.loggedIn = true;
                            } else {
                                this.error = response.data.message
                            } -->