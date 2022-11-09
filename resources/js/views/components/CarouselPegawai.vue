<template>
  <div class="card card-carousel overflow-hidden h-100 p-0">
    <div class="carousel slide h-100">
      <div class="carousel-inner border-radius-lg h-100 bg-gradient-primary" >
        <div class="card-header mt-4 border-0 text-end bg-transparent " >
                <a class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  
                </a>
        </div>
        <div v-if="this.cekhari == true">
          <div class="card-body d-flex flex-column p-0"  style="margin-top:-35px">
							<div class="card-body" style="text-align:center;">
                  <div class="date text-white" style="font-size:28px;">
                      <span id="dayname">Day</span>,&nbsp;
                      <span id="daynum">00</span>&nbsp;
                      <span id="month">Month</span>&nbsp;
                      <span id="year">Year</span>
                  </div>
                  <div class="time text-white" style="font-size:40px;font-weight: 600; color: #124EB2;">
                      <span id="hour">00</span>:
                      <span id="minutes">00</span>:
                      <span id="seconds">00</span>
                  </div>
               </div>
               <div class="" style="margin-top:20px" >
													<!--begin::Row-->
													<div class="row m-0 text-center" >
														<div class="col">
															<div class="font-size-lg text-white font-weight-bold" >Jam Masuk</div>
															<div class="font-size-h4 text-white font-weight-bolder" v-for="(data) in presensi" :key="data.id">{{data.jam_masuk}}</div>
														</div>
														<div class="col">
															<div class="font-size-lg text-white font-weight-bold">Jam Pulang</div>
															<div class="font-size-h4 text-white font-weight-bolder mb-4" v-for="(data) in presensi" :key="data.id">{{data.jam_pulang}}</div>
														</div>
													</div>
												</div>
              </div>
              <div class="text-center">
                    <div v-if="cekpresensi == null">
                      <button  @click="showModal()" data-toggle="modal" class=" btn btn-white text-primary mt-4 text-center font-weight-bolder"><i class="fa-solid fa-right-to-bracket me-1"></i> Presensi Masuk Disini</button>
                    </div>
                    <div v-else-if="cekpresensi !== null">
                      <button v-if="cekpresensi.jam_masuk !== null && cekpresensi.jam_pulang == null" @click="pulangModal()" data-toggle="modal" class=" btn btn-white text-primary mt-4 text-center font-weight-bolder"><i class="fa-solid fa-right-to-bracket me-1"></i> Presensi Pulang Disini</button>
                      <p v-else-if="cekpresensi.selfie_pulang !== null" class="text-white mt-2 text-center text-bold p-3 ">Anda telah bekerja dengan baik hari ini, Silahkan Beristirahat</p>
                    </div>
                </div>
              </div>
        <div v-if="this.cekhari == false">
          <div class="date text-white" style="font-size:28px; display: none;">
                      <span id="dayname">Day</span>,&nbsp;
                      <span id="daynum">00</span>&nbsp;
                      <span id="month">Month</span>&nbsp;
                      <span id="year">Year</span>
                  </div>
                  <div class="time text-white" style="font-size:40px;font-weight: 600; display: none; color: #124EB2;">
                      <span id="hour">00</span>:
                      <span id="minutes">00</span>:
                      <span id="seconds">00</span>
                  </div>
          <div class="card-header border-0 text-end bg-transparent " >
            <img src="../../assets/img/libur5.svg" alt="Image placeholder" class="card-img-top" style="padding:70px; margin-top: -90px">
          </div>
          <div class="card-body d-flex flex-column p-0" style="margin-top:-35px">
            <div class="text-center" style="margin-top:-27px">
                      <button data-toggle="modal" class=" btn btn-white text-primary mt-4 text-center font-weight-bolder">Hari Ini Sedang Libur</button>
                </div>
          </div>
        </div>
      <div>
          
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="camera" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header border-bottom-0">
        <b class="modal-title" id="camera">Presensi Masuk</b>
        <b @click="closeModal()" type="button">Close</b>
      </div>
      <div class="modal-body">
          <h5 class="modal-title text-center" id="camera">Presensi Menggunakan Take Selfie</h5>
          <div class="text-center mt-2 ms-md-5" id="my_camera" style="border-radius: 20px;"></div>
          <div class="text-center mb-1 mt-3">
            <button  @click="ambil()" class="btn btn-primary" type="submit" >Presensi Masuk</button>
          </div>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="camera2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header border-bottom-0">
        <b class="modal-title" id="camera">Presensi Pulang</b>
        <b @click="closePulang()" type="button">Close</b>
      </div>
      <div class="modal-body">
          <h5 class="modal-title text-center" id="camera">Presensi Menggunakan Take Selfie</h5>
          <div class="text-center mt-2 ms-md-5" id="my_camera2" style="border-radius: 20px;"></div>
          <div class="text-center mb-1 mt-3">
            <button  @click="ambilpulang(uid)" class="btn btn-primary" type="submit" >Presensi Pulang</button>
          </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import axios from 'axios'
import { useToast } from 'vue-toastification';
export default {
  name: "carousel",
  data(){
    return{
      presensi:[],
      cekhari: "",
      map : '',
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
						latitude: "",
						longitude:""
						
					}),
          cek:[],
          cek2:[],
          cek3:[],
          cekpresensi:[],
					jamabsen: [],
					mimes: "",
					loggedIn: localStorage.getItem("loggedIn"),
					token: localStorage.getItem("token"),
					name: localStorage.getItem("name"),
					role: localStorage.getItem("role"),
          lat : localStorage.getItem("lat"),
          lon: localStorage.getItem("lon")
    }
  },
  methods:{
    cekabsen(){
      var token =  localStorage.getItem("token")
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/cekabsen',{
                headers: {Authorization: "Bearer " + token},
            })
                .then(response => {
                    this.cekpresensi = response.data.data
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    tampilabsen(){
            var token =  localStorage.getItem("token")
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampiljampeg',{
                headers: {Authorization: "Bearer " + token},
            })
                .then(response => {
                    this.presensi = response.data
                    this.cekhari = response.data.status
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
      showModal() {;
      $('#camera').modal({backdrop: 'static', keyboard: false}).modal("show")
			this.kamera();
			},
      closeModal() {
				$("#camera").modal("hide");
				 Webcam.reset();
			},
      pulangModal() {;
      $('#camera2').modal({backdrop: 'static', keyboard: false}).modal("show")
			this.kamera2();
			},
      closePulang() {
				$("#camera2").modal("hide");
				 Webcam.reset();
			},

      ambil(){
			 var image = ''
			 Webcam.snap( function(data_uri) {
					image = data_uri
				 });
					   var tok = localStorage.getItem("token")
						  axios.post('/api/absenmasuk', 
              
				 {
							 selfie_masuk : image,
							 latitude : localStorage.getItem("lat"),
							 longitude : localStorage.getItem("lon")
					 
				 },
				  {
					headers : { Authorization: "Bearer " + tok },
				},).then((response) => {
					if (response.data.success){
            Webcam.reset();
            $('#camera').modal({backdrop: 'static', keyboard: false}).modal("hide")
						const toast = useToast();
                  toast.success("Berhasil Melakukan Presensi Masuk", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
                  this.cekabsen()
					}
					if (response.data.success == false){
            const toast = useToast();
                  toast.error("Sudah Presensi Masuk", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						
					}
					if (response.data.status == false){
						const toast = useToast();
                  toast.error("Maaf, Anda Sedang Izin", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						
					}
          if (response.data.status == 13){
						const toast = useToast();
                  toast.error("Maaf, Saat ini bukan jam kerja", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						
					}
          if (response.data.status == 12){
						const toast = useToast();
                  toast.error("Presensi Gagal, Anda tidak mengizinkan lokasi, Harap logout kemudian login kembali kemudian periksa akses lokasi perangkat anda, Terimakasih", {
                  position: "top-center",
                  timeout: 4000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						
					}
				})
						},
           
      ambilpulang(uid){
			var image = ''
			Webcam.snap( function(data_uri) {
					image = data_uri
				 } );
				this.$axios.post('/api/absenpulang/' +uid,  {
					 selfie_pulang : image
				 },
				 {
					headers : { Authorization: "Bearer " + this.token },
				}).then((response) => {
				   if (response.data.success){
            Webcam.reset();
            $('#camera2').modal({backdrop: 'static', keyboard: false}).modal("hide")
            const toast = useToast();
                  toast.success("Berhasil Melakukan Presensi Pulang", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
            this.cekabsen()
					}
					if (response.data.status == false){
						const toast = useToast();
                  toast.error("Belum Saatnya Jam Pulang", {
                  position: "top-center",
                  timeout: 2500,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						
					}
				})
		   
		},
      kamera(){
			Webcam.set({
            width: 370,
            height: 290,
            dest_width: 640,
            dest_height: 480,
						image_format: 'jpeg',
						jpeg_quality: 90
					});
					Webcam.attach('#my_camera');
					
			},
      kamera2(){
			Webcam.set({
            width: 370,
            height: 290,
            dest_width: 640,
            dest_height: 480,
						image_format: 'jpeg',
						jpeg_quality: 90
					});
					Webcam.attach('#my_camera2');
					
			},
			take_picture() {
	
			Webcam.snap( function(picture_data) {
	
				// display results in page
				document.getElementById('results').innerHTML = 
				'<img src="'+picture_data+'"/>';
	
			} );
		},
  },
  mounted(){
    this.tampilabsen()
    this.cekabsen()
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
};
</script>
