<template>
   <body id="kt_body" style="background-image: url(assets/media/bg/bg-5.jpg);" class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div id="kt_header_mobile" class="header-mobile">
        <!--begin::Logo-->
        <a href="index.html">
            <img alt="Logo" src="assets/media/logos/logo-letter-1.png" class="logo-default max-h-30px" />
        </a>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button>
            <button class="btn btn-icon btn-hover-transparent-white p-0 ml-3" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
				</button>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header header-fixed">
                    <!--begin::Container-->
                    <div class="container d-flex align-items-stretch justify-content-between">
                        <!--begin::Left-->
                        <div class="d-flex align-items-stretch mr-3">
                            <!--begin::Header Logo-->
                            <div class="header-logo">
                                <a href="index.html">
                                    <img alt="Logo" src="assets/media/logos/logo-letter-9.png" class="logo-default max-h-40px" />
                                    <img alt="Logo" src="assets/media/logos/logo-letter-1.png" class="logo-sticky max-h-40px" />
                                </a>
                            </div>
                            <!--end::Header Logo-->
                            <!--begin::Header Menu Wrapper-->
                            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                                <!--begin::Header Menu-->
                                <div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
                                    <!--begin::Header Nav-->
                                    <ul class="menu-nav" v-if="role === 'Admin'">
                                        
                                        <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" @click="admin">
                                            <a class="menu-link menu-toggle">
                                                <span class="menu-text">Dashboard</span>

                                                <i class="menu-arrow"></i>
                                            </a>
                                        </li>


                                        <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" @click="datapegawai">
                                            <a class="menu-link menu-toggle">
                                               <span class="menu-text">Data Pegawai</span>

                                            </a>
                                        </li>


                                        <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" @click="akunpegawai">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <span class="menu-text">Data User</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" @click="jabatan">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <span class="menu-text">Jabatan</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" @click="kehadiran">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <span class="menu-text">Kehadiran</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" @click="payroll">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <span class="menu-text">Payroll</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" @click="laporan">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <span class="menu-text">Laporan</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-submenu" aria-haspopup="true" @click="approvement">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <span class="menu-text">Approvement</span>
                                            </a>
                                        </li>
                                    </ul>
                                       <ul class="menu-nav" v-if="role === 'Pegawai'">

                                        <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" @click="pegawai">
                                            <a class="menu-link menu-toggle">
                                               <span class="menu-text">Dashboard</span>

                                                <i class="menu-arrow"></i>
                                            </a>
                                        </li>


                                        <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" @click="absen">
                                            <a class="menu-link menu-toggle">
                                               <span class="menu-text">Absensi</span>

                                            </a>
                                        </li>


                                        <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" @click="tugas">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <span class="menu-text">Laporan</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" @click="pengajuan">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <span class="menu-text">Pengajuan</span>
                                            </a>
                                        </li>
                                         <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" @click="penggajian">
                                            <a href="javascript:;" class="menu-link menu-toggle">
                                                <span class="menu-text">Penggajian</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="menu-nav" v-if="role === 'Manager'">

                                        <li class="menu-item menu-item-submenu menu-item-rel" aria-haspopup="true" @click="manager">
                                            <a class="menu-link menu-toggle">
                                               <span class="menu-text">Data User</span>

                                                <i class="menu-arrow"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Header Nav-->
                                </div>
                                <!--end::Header Menu-->
                            </div>
                            <!--end::Header Menu Wrapper-->
                        </div>
                        <!--end::Left-->
                        <!--begin::Topbar-->
                        <div class="topbar">
                                <div class="dropdown" v-if="role === 'Admin'">
                                <!--begin::Toggle-->
                                <div class="topbar-item">
                                    <div class="dropdown dropdown-inline">
                                        <a href="#" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-user"></i>{{name}}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-md py-5">
                                            <ul class="navi navi-hover">
                                                <li class="navi-item">
                                                    <a class="navi-link" href="#" @click="profileAdmin()">
                                                        <span class="navi-icon"><i class="far fa-user text-warning"></i></span>
                                                        <span class="navi-text">Informasi Akun</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item" @click="logout">
                                                    <a class="navi-link" href="#">
                                                        <span class="navi-icon"><i class="fas fa-sign-out-alt text-primary"></i></span>
                                                        <span class="navi-text">Logout</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!--end::Toggle-->
                            </div>

                            <!--begin::User-->
                            <div class="dropdown" v-if="role === 'Pegawai'">

                                <!--begin::Toggle-->
                                <div class="topbar-item">
                                    <div class="dropdown dropdown-inline">
                                        <a href="#" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-user"></i>{{name}}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-md py-5">
                                            <ul class="navi navi-hover">
                                                <li class="navi-item" @click="profile">
                                                    <a class="navi-link" href="#">
                                                        <span class="navi-icon"><i class="far fa-user text-warning"></i></span>
                                                        <span class="navi-text">Informasi Akun</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item" @click="logout">
                                                    <a class="navi-link" href="#">
                                                        <span class="navi-icon"><i class="fas fa-sign-out-alt text-primary"></i></span>
                                                        <span class="navi-text">Logout</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!--end::Toggle-->
                            </div>
                            <div class="dropdown" v-if="role === 'Manager'">

                                <!--begin::Toggle-->
                                <div class="topbar-item">
                                    <div class="dropdown dropdown-inline">
                                        <a href="#" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-user"></i>{{name}}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-md py-5">
                                            <ul class="navi navi-hover">
                                                <li class="navi-item" @click="profile">
                                                    <a class="navi-link" href="#">
                                                        <span class="navi-icon"><i class="far fa-user text-warning"></i></span>
                                                        <span class="navi-text">Informasi Akun</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item" @click="logout">
                                                    <a class="navi-link" href="#">
                                                        <span class="navi-icon"><i class="fas fa-sign-out-alt text-primary"></i></span>
                                                        <span class="navi-text">Logout</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!--end::Toggle-->
                            </div>
                            

                            <!--end::User-->
                        </div>
                        <!--end::Topbar-->
                    </div>
                    <!--end::Container-->
                </div>
                </div>
                </div>
                </div>
                </body>


					
</template>
<script>

export default {
        data() {
            return {
                loggedIn: localStorage.getItem("loggedIn"),
                token: localStorage.getItem("token"),
                name: localStorage.getItem("name"),
                role: localStorage.getItem("role")
            };
        },
        methods: {
            logout() {
                axios.post('/api/logout', {
                        tok: this.token
                    },
                    {
                        headers: {
                            Authorization: "Bearer " + this.token
                        }
                    }).then((response) => {
                    localStorage.clear()
                    return this.$router.push({ name: "Login" });
                })
            },
            fixerror(){
                location.reload();
            },
            manager(){
                this.$router.push("/SuperAdminDashboard")
            },  
            //profile Pegawai
            profile(){
                 this.$router.push("/Profile")
                 
            },
            //profileAdmin
             profileAdmin(){
                 this.$router.push("/ProfileAdmin")
            //Pegawai     
            },
            pegawai(){
                this.$router.push("/PegawaiDashboard");
            },
            absen(){
                this.$router.push("/Absen");
            },
            tugas(){
                this.$router.push("/LaporanHarian");
            },
            pengajuan(){
                this.$router.push("/Pengajuan");
            },
            penggajian(){
                this.$router.push("/Penggajian");
            },
            //admin
            admin(){
                this.$router.push("/AdminDashboard");
            },
            approvement(){
                this.$router.push("/Approvement");
            },
            datapegawai(){
                this.$router.push("/DataPegawai");
            },
            laporan(){
                this.$router.push("/Laporan");
            },
            jabatan(){
                this.$router.push("/Jabatan");
            },
            payroll(){
                this.$router.push("/Payroll");
            },
             akunpegawai(){
                this.$router.push("/AkunPegawai");
            },
             kehadiran(){
                this.$router.push("/Kehadiran");
            },

        },

        mounted() {
            if (!this.loggedIn) {
                return this.$router.push({name: "Login"});
            }
        },

}

</script>
<style></style>


