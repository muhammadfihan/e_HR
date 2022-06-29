<template>

<div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Pegawai Dashboard</h2>
										<div class="d-flex align-items-center font-weight-bold my-2">
                                            
										</div>
									</div>
								</div>
							</div>
						</div>
 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
					
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container mb-18">
								<!--begin::Teachers-->
								<div class="d-flex flex-row">
									<!--begin::Aside-->
									<!--end::Aside-->
									<!--begin::Content-->
									<div class="flex-row-fluid ml-md-4">
										<!--begin::Card-->
										<div class="card card-custom">
											<div class="card-body" style="text-align:center;padding: 100px;">
                                                	<div class="date text-primary" style="font-size:40px;">
                                                        <span id="dayname">Day</span>,&nbsp;
                                                        <span id="daynum">00</span>&nbsp;
                                                        <span id="month">Month</span>&nbsp;
                                                        <span id="year">Year</span>
                                                    </div>
                                                    <div class="time text-primary" style="font-size:60px;font-weight: 600; color: #124EB2;">
                                                        <span id="hour">00</span>:
                                                        <span id="minutes">00</span>:
                                                        <span id="seconds">00</span>
                                                    
                                                    </div>
                                                    <div style="margin-top:15px">
                                                    <a class="btn btn-bg-success" data-target="#camera" @click="kamera()" data-toggle="modal" data-backdrop="static" data-keyboard="false" style="margin-right:12px;color:white; outline: none;">Presensi Masuk</a>
                                                    <a class="btn btn-bg-success" data-target="#camera2" @click="kamera2()" data-toggle="modal" data-backdrop="static" data-keyboard="false"  style="color:white; outline: none;">Presensi Pulang</a>
                                                </div>
                                            </div>
                                            
                                    </div>
                                </div>
                             </div>
                         </div>
                    </div>
                </div>								
						

 </div>
<div class="modal fade" id="camera" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="camera"></h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" id="stop-button" class="ki ki-close" @click="closeModal()"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div class="card card-custom card-stretch gutter-b">
													<div class="card-body p-15 pb-20"  v-for="(data) in pegawais" :key="data.id">
														<div class="row mb-17">
															<div class="col-xxl-5 mb-11 mb-xxl-0" id="my_camera">
																<!--begin::Image-->
																<div>
																	<div class="card-body p-0 rounded px-10 py-15 d-flex align-items-center justify-content-center" >
																		<div ></div>
																	</div>
																</div>
																<!--end::Image-->
															</div>
														<div class="col-xxl-7 pl-xxl-20">
																<h2 class="font-weight-bolder text-primary mb-3" style="font-size: 32px;">Presensi Masuk</h2>
                                                                <p class="text-danger mb-2">Silahkan ambil gambar terlebih dahulu dan otomatis akan melakukan presensi masuk !</p>
                                                               <a href="#" @click="ambil()" class="btn btn-success font-weight-bold mr-2">
                                                                    <i class="flaticon-photo-camera"></i>Ambil gambar dan absen
                                                                </a>
															</div>
														</div>
														<div class="row mb-6">
															<!--begin::Info-->
															<div class="col-6 col-md-4">
																<div class="mb-8 d-flex flex-column">
																	<span class="text-dark font-weight-bold mb-4">Email</span>
																	<span class="text-muted font-weight-bolder font-size-lg">{{data.email}}</span>
																</div>
															</div>
															<div class="col-6 col-md-4">
																<div class="mb-8 d-flex flex-column">
																	<span class="text-dark font-weight-bold mb-4">Username</span>
																	<span class="text-muted font-weight-bolder font-size-lg">{{data.name}}</span>
																</div>
															</div>
															<div class="col-6 col-md-4">
																<div class="mb-8 d-flex flex-column">
																	<span class="text-dark font-weight-bold mb-4">No Pegawai</span>
																	<span class="text-muted font-weight-bolder font-size-lg">{{data.no_pegawai}}</span>
																</div>
															</div>
                                                            <div class="col-6 col-md-4">
																<div class="mb-8 d-flex flex-column">
																	<span class="text-dark font-weight-bold mb-4">Pendidikan</span>
																	<span class="text-muted font-weight-bolder font-size-lg">{{data.pendidikan}}</span>
																</div>
															</div>
                                                             <div class="col-6 col-md-4">
																<div class="mb-8 d-flex flex-column">
																	<span class="text-dark font-weight-bold mb-4">Jabatan</span>
																	<span class="text-muted font-weight-bolder font-size-lg"><span v-for="jab in jabatan" :key="jab.id">
                                                                            <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                                                                        </span></span>
																</div>
															</div>
															
															<!--end::Info-->
														</div>
														<!--begin::Buttons-->
														
														<!--end::Buttons-->
													</div>
												</div>
                                                                        <div class="modal-footer">
																		
                                                                        <button type="submit" data-dismiss="modal" aria-label="Close" class=" btn btn-secondary font-weight-bold" @click="closeModal()">Batal</button>
                                                                       
																	</div>
																	</div>
																</div>
                                                                	
															</div>
														</div>

        <div class="modal fade" id="camera2" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="camera2"></h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" id="stop-button" class="ki ki-close" @click="closeModal2()"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div class="card card-custom card-stretch gutter-b">
													<div class="card-body p-15 pb-20"  v-for="(data) in pegawais" :key="data.id">
														<div class="row mb-17">
															<div class="col-xxl-5 mb-11 mb-xxl-0" id="my_camera2">
																<!--begin::Image-->
																<div>
																	<div class="card-body p-0 rounded px-10 py-15 d-flex align-items-center justify-content-center" >
																		<div ></div>
																	</div>
																</div>
																<!--end::Image-->
															</div>
														<div class="col-xxl-7 pl-xxl-20">
																<h2 class="font-weight-bolder text-primary mb-3" style="font-size: 32px;">Presensi Pulang</h2>
                                                                <p class="text-danger mb-2">Silahkan ambil gambar terlebih dahulu dan otomatis akan melakukan presensi pulang !</p>
                                                               <a href="#" @click="ambilpulang(uid)" class="btn btn-success font-weight-bold mr-2">
                                                                    <i class="flaticon-photo-camera"></i>Ambil gambar dan absen
                                                                </a>
															</div>
														</div>
														<div class="row mb-6">
															<!--begin::Info-->
															<div class="col-6 col-md-4">
																<div class="mb-8 d-flex flex-column">
																	<span class="text-dark font-weight-bold mb-4">Email</span>
																	<span class="text-muted font-weight-bolder font-size-lg">{{data.email}}</span>
																</div>
															</div>
															<div class="col-6 col-md-4">
																<div class="mb-8 d-flex flex-column">
																	<span class="text-dark font-weight-bold mb-4">Username</span>
																	<span class="text-muted font-weight-bolder font-size-lg">{{data.name}}</span>
																</div>
															</div>
															<div class="col-6 col-md-4">
																<div class="mb-8 d-flex flex-column">
																	<span class="text-dark font-weight-bold mb-4">No Pegawai</span>
																	<span class="text-muted font-weight-bolder font-size-lg">{{data.no_pegawai}}</span>
																</div>
															</div>
                                                            <div class="col-6 col-md-4">
																<div class="mb-8 d-flex flex-column">
																	<span class="text-dark font-weight-bold mb-4">Pendidikan</span>
																	<span class="text-muted font-weight-bolder font-size-lg">{{data.pendidikan}}</span>
																</div>
															</div>
                                                             <div class="col-6 col-md-4">
																<div class="mb-8 d-flex flex-column">
																	<span class="text-dark font-weight-bold mb-4">Jabatan</span>
																	<span class="text-muted font-weight-bolder font-size-lg"> <span v-for="jab in jabatan" :key="jab.id">
                                                                            <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                                                                        </span></span>
																</div>
															</div>
															
															<!--end::Info-->
														</div>
														<!--begin::Buttons-->
														
														<!--end::Buttons-->
													</div>
												</div>
                                                                        <div class="modal-footer">
																		
                                                                        <button type="submit" data-dismiss="modal" aria-label="Close" class=" btn btn-secondary font-weight-bold" @click="closeModal2()">Batal</button>
                                                                       
																	</div>
																	</div>
																</div>
                                                                	
															</div>
														</div>

                        
        
</template>

<script>
import router from '../router';
const date = new Date();
export default {
    name: "PegawaiDashboard",
    data() {
            return {
                absensimasuk:[],
                pegawais:[],
                jabatan:[],
                currentUrl: "",
                form : new Form({
                    id : "",
                    uid: "",
                    name : "",
                    email : "",
                    nama_lengkap : "",
                    selfie_masuk: "",
                    selfie_pulang: "",
                    jam_masuk : "",
                    jam_pulang : "",
                    jam_kerja : "",
                    keterangan : "",
                    lokasi : "",
                    
                }),

                mimes: "",
                loggedIn: localStorage.getItem("loggedIn"),
                token: localStorage.getItem("token"),
                name: localStorage.getItem("name"),
                role: localStorage.getItem("role")
            };
        },
    
    methods: {
     getJabatan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/jabatanpegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.jabatan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
    
    ambil(){
        var image = ''
        Webcam.snap( function(data_uri) {
                image = data_uri
             } );
            axios.post('/api/absenmasuk',  {
                 selfie_masuk : image
             },
             {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                    title: 'Berhasil Presensi',
                    text: "Klik tombol dibawah ini untuk kembali !",
                    icon: 'success',
                    confirmButtonColor: '#1BC5BD',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload()
                    }
                    })
                }
                if (response.data.success == false){
                    Swal.fire({
                        icon: "error",
                        title: "Sudah Presensi Masuk",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    
                }
                if (response.data.status == false){
                    Swal.fire({
                        icon: "error",
                        title: "Maaf Anda Sedang Izin",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    
                }
            })
       
    },
     ambilpulang(uid){
        var image = ''
        Webcam.snap( function(data_uri) {
                image = data_uri
             } );
            axios.post('/api/absenpulang/' +uid,  {
                 selfie_pulang : image
             },
             {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
               if (response.data.success){
                    Swal.fire({
                    title: 'Berhasil Presensi',
                    text: "Klik tombol dibawah ini untuk kembali !",
                    icon: 'success',
                    confirmButtonColor: '#1BC5BD',
                    }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload()
                    }
                    })
                }
                if (response.data.success == false){
                    Swal.fire({
                        icon: "error",
                        title: "Sudah Presensi Pulang",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    
                }
                if (response.data.status == false){
                    Swal.fire({
                        icon: "error",
                        title: "Harap Presensi Pulang Terlebih Dahulu",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    
                }
            })
       
    },
      
        showModal() {
        $("#camera").modal("show");
        this.kamera();
        },

        showModal2() {
        $("#camera2").modal("show");
        this.kamera2();
        },

        closeModal() {
            $("#camera").modal("hide");
             Webcam.reset();
        },
        closeModal2() {
            $("#camera2").modal("hide");
            Webcam.reset();
        },
        getprofile(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/getprofile',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.pegawais = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        absenmasuk() {
            
            Webcam.snap(function (data_uri) { 
            const arr = data_uri.split(',')
            const mime = arr[0].match(/:(.*?);/)[1]
            const bstr = atob(arr[1])
            let n = bstr.length
            let u8arr = new Uint8Array(n);
                
            while (n > 0) {
                u8arr[n] = bstr.charCodeAt(n);
                n -= 1;
            }
        
        // let File = ''
        // file = data_uri

            gambar = new File([u8arr], 'image.jpg', { type:mime })
            });
             axios.post('/api/absenmasuk',{
                 selfie_masuk : gambar
             }, {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Melakukan Presensi",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                   location.reload()
                }
                if (response.data.success == false){
                    Swal.fire({
                        icon: "error",
                        title: "Sudah Presensi Masuk",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                }
            })
        },
        absenpulang() {
            this.form.post('/api/absenpulang', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil Presensi Pulang",
                        text: "Silahkan Pulang",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    location.reload()
                }
                if (response.data.success == false){
                    Swal.fire({
                        icon: "error",
                        title: "Sudah Presensi Pulang",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                }
            })
        },
        kamera(){
        Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                Webcam.attach('#my_camera');
                
        },
        take_picture() {

        Webcam.snap( function(picture_data) {

            // display results in page
            document.getElementById('results').innerHTML = 
            '<img src="'+picture_data+'"/>';

        } );
    },
        kamera2(){
        Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                Webcam.attach('#my_camera2');
                
        },
        geturl(){
            window.location.href;
        }
    },

    mounted(){
        // this.initClock();
        this.getprofile();
        this.getJabatan();
        // this.kamera();
       

    },
    created(){
        
    },
    beforeDestroy() {
       
    },
     beforeMount() {
     this.timer =  setInterval(function(){
            var now = new Date();
            var dname = now.getDay(),
            mo = now.getMonth(),
            dnum = now.getDate(),
            yr = now.getFullYear(),
            hou = now.getHours(),
            min = now.getMinutes(),
            sec = now.getSeconds()
            
            
            if(hou == 24){
                hou = 0;
            }
            if(hou > 24){
                hou = hou - 24;
            }

            Number.prototype.pad = function(digits){
                for(var n = this.toString(); n.length < digits; n = 0 + n);
                return n;
            }

            var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            var week = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
            var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds"];
            var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2)];
            for(var i = 0; i < ids.length; i++)
            document.getElementById(ids[i]).innerHTML = values[i];
            }, 1000);
            },
            beforeUnmount() {
                clearInterval(this.timer);
            },

}
</script>

<style scoped>

</style>
