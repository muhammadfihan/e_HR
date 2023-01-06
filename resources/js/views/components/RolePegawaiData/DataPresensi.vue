<template>
  <div class="card card-carousel overflow-hidden h-100 p-0" style="height:630px !important; overflow-y: scroll;">
    <div class="carousel slide h-100">
      <div class="carousel-inner border-radius-lg h-100 bg-white" >
        <div v-if="this.cekhari == true" style="overflow-y: scroll;overflow-x: hidden;max-height: 570px;">
          <div v-if="this.lonlat == false || this.lonlat == 12" class="card-header border-0 text-end bg-transparent" >
                  <a class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                  <button type="submit" class="btn btn-warning btn-sm font-weight-bolder me-2" @click="cekizin()">Izinkan Lokasi</button>
                  <button type="submit" class="btn btn-primary btn-sm font-weight-bolder me-2" @click="showDetail()">Detail Presensi</button>
          </div>
          <div v-else-if="this.lonlat == null">
            <div class="card-header border-0 text-end bg-transparent" >
                  <a class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                  <button type="submit" class="btn btn-danger btn-sm  font-weight-bolder me-2" @click="cekizin()">Perbarui Lokasi Lokasi</button>
                  <button type="submit" class="btn btn-primary btn-sm font-weight-bolder me-2" @click="showDetail()">Detail Presensi</button>
           </div>
          </div>
          <div v-else-if="this.lonlat == true">
            <div v-for="(data) in ceklok" :key="data.id" class="card-header border-0 text-end bg-transparent" >
                  <a class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                  <button type="submit" class="btn btn-success btn-sm font-weight-bolder me-2" @click.prevent="ceklokasi(data.latitude,data.longitude)">Lokasi Anda</button>
                  <button type="submit" class="btn btn-primary btn-sm font-weight-bolder me-2" @click="showDetail()">Detail Presensi</button>
           </div>
          </div>
          <div class="card-body d-flex flex-column p-0 mt-3"  style="margin-top:-35px" v-if="cekpresensi == null">
							<div class="card-body" style="text-align:center;">
                  <div class="date text-dark" style="font-size:32px;">
                      <span id="dayname">Day</span>,&nbsp;
                      <span id="daynum">00</span>&nbsp;
                      <span id="month">Month</span>&nbsp;
                      <span id="year">Year</span>
                  </div>
                  <div class="time text-dark" style="font-size:45px;font-weight: 600; color: #124EB2;">
                      <span id="hour">00</span>:
                      <span id="minutes">00</span>:
                      <span id="seconds">00</span>
                  </div>
                  <div v-for="(data) in detabsen" :key="data.id">
                    <span v-if="data.keterangan == 'Terlambat'" class="badge bg-danger badge-md text-white font-weight-bolder me-2">Anda Terlambat Hari Ini</span>
                    <span v-if="data.keterangan == 'On Time'" class="badge bg-success badge-md text-white font-weight-bolder me-2">Anda Presensi Tepat Waktu Hari Ini</span>
                  </div>
               </div>
               <div class="row d-flex justify-content-center">
                  <div class="col-lg-2">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-center">Jam Masuk</h5>
                        <h5 class="card-title text-center" v-for="(data) in presensi" :key="data.id">{{data.jam_masuk}}</h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="card">
                      <div class="card-body text-center">
                        <h5 class="card-title">Jam Pulang</h5>
                        <h5 class="card-title text-center" v-for="(data) in presensi" :key="data.id">{{data.jam_pulang}}</h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center mt-2">
                      <button class=" btn bg-gradient-primary text-white mt-4 text-center font-weight-bolder">Presensi Belum Dibuka</button>
                    </div>
              </div>
              <div class="card-body d-flex flex-column p-0 mt-3"  style="margin-top:-35px" v-else-if="cekpresensi !== null">
							<div class="card-body" style="text-align:center;" v-if="cekpresensi.selfie_pulang == null">
                  <div class="date text-dark" style="font-size:32px;">
                      <span id="dayname">Day</span>,&nbsp;
                      <span id="daynum">00</span>&nbsp;
                      <span id="month">Month</span>&nbsp;
                      <span id="year">Year</span>
                  </div>
                  <div class="time text-dark" style="font-size:45px;font-weight: 600; color: #124EB2;">
                      <span id="hour">00</span>:
                      <span id="minutes">00</span>:
                      <span id="seconds">00</span>
                  </div>
                  <div v-for="(data) in detabsen" :key="data.id">
                    <span v-if="data.keterangan == 'Terlambat'" class="badge bg-danger badge-md text-white font-weight-bolder me-2">Anda Terlambat Hari Ini</span>
                    <span v-if="data.keterangan == 'On Time'" class="badge bg-success badge-md text-white font-weight-bolder me-2">Anda Presensi Tepat Waktu Hari Ini</span>
                  </div>
               </div>
               <div class="card-body" style="text-align:center;" v-if="cekpresensi.selfie_pulang !== null">
                <div style="display:none">
                  <div class="date text-dark" style="font-size:32px;">
                      <span id="dayname">Day</span>,&nbsp;
                      <span id="daynum">00</span>&nbsp;
                      <span id="month">Month</span>&nbsp;
                      <span id="year">Year</span>
                  </div>
                  <div class="time text-dark" style="font-size:45px;font-weight: 600; color: #124EB2;">
                      <span id="hour">00</span>:
                      <span id="minutes">00</span>:
                      <span id="seconds">00</span>
                  </div>
                  <div v-for="(data) in detabsen" :key="data.id">
                    <span v-if="data.keterangan == 'Terlambat'" class="badge bg-danger badge-md text-white font-weight-bolder me-2">Anda Terlambat Hari Ini</span>
                    <span v-if="data.keterangan == 'On Time'" class="badge bg-success badge-md text-white font-weight-bolder me-2">Anda Presensi Tepat Waktu Hari Ini</span>
                  </div>
                </div>
               </div>
               <div class="row d-flex justify-content-center" v-if="cekpresensi.selfie_pulang == null">
                  <div class="col-lg-2">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-center">Jam Masuk</h5>
                        <h5 class="card-title text-center" v-for="(data) in presensi" :key="data.id">{{data.jam_masuk}}</h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="card">
                      <div class="card-body text-center">
                        <h5 class="card-title">Jam Pulang</h5>
                        <h5 class="card-title text-center" v-for="(data) in presensi" :key="data.id">{{data.jam_pulang}}</h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row d-flex justify-content-center" v-if="cekpresensi.selfie_pulang !== null">
                  <div style="display:none">
                    <div class="col-lg-2">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-center">Jam Masuk</h5>
                        <h5 class="card-title text-center" v-for="(data) in presensi" :key="data.id">{{data.jam_masuk}}</h5>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="card">
                      <div class="card-body text-center">
                        <h5 class="card-title">Jam Pulang</h5>
                        <h5 class="card-title text-center" v-for="(data) in presensi" :key="data.id">{{data.jam_pulang}}</h5>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                <div v-if="cekpresensi.selfie_pulang !== null" class="text-center mt-9">
                  <img src="../../../assets/img/pulang.svg" alt="Image placeholder" class="card-img-top" style="width: auto;height: 300px; margin-top: -200px">
                </div>
              </div>
              <div class="text-center mt-2" v-if="cekpresensi !== null">
                      <button v-if="cekpresensi.jam_masuk == null" @click="showModal()" data-toggle="modal" class=" btn bg-gradient-primary text-white mt-4 text-center font-weight-bolder"><i class="fa-solid fa-right-to-bracket me-1"></i> Presensi Masuk Disini</button>
                      <button v-else-if="cekpresensi.jam_masuk !== null && cekpresensi.jam_pulang == null" @click="pulangModal()" data-toggle="modal" class=" btn bg-gradient-primary text-white mt-4 text-center font-weight-bolder"><i class="fa-solid fa-right-to-bracket me-1"></i> Presensi Pulang Disini</button>
                      <h5 v-else-if="cekpresensi.selfie_pulang !== null" class="text-primary mt-3 text-center text-bold p-3 ">Selamat Beristirahat</h5>
                </div>
              </div>
        <div v-if="this.cekhari == false" style="overflow-y: hidden;max-height: 570px;">
          <div class="card-header border-0 text-end bg-transparent " >
                <a class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  
                </a>
                  <button type="submit" class="btn btn-outline-primary btn-sm text-primary font-weight-bolder" style="visibility:hidden">Kehadiran</button>
        </div>
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
                <img src="../../../assets/img/libur5.svg" alt="Image placeholder" class="card-img-top" style="padding:230px; margin-top: -280px">
              </div>
              <div class="card-body d-flex flex-column p-0" style="margin-top:-200px">
                <div class="text-center" style="margin-top:-27px">
                          <button data-toggle="modal" class=" btn bg-gradient-primary text-white mt-4 text-center font-weight-bolder">Hari Ini Sedang Libur</button>
                    </div>
              </div>
            </div>
          <div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="detail" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <h5 class="modal-title" id="detailLabel">Foto Harian Pegawai</h5>
        </div>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" v-if="detabsen == ''">
          <div class="row" style="height:450px">
            <div class="mt-2 mb-2 card shadow-none text-center bg-transparent" style="height:23.5rem !important"><h4 class="mt-9 text-muted">Belum Melakukan Presensi</h4>
                      </div>
          </div>
      </div>
      <div class="modal-body">
        <div class="row"  v-for="(data) in detabsen" :key="data.id">
                    <div class="col-lg-6">
                      <h6 class="form-control-label text-center" >Presensi Masuk</h6>
                      <div v-if="data.selfie_masuk == null" class="mt-2 mb-2 card border-1 mx-auto shadow text-center" style="height:23.5rem !important; width: 22rem;"><p class="mt-9 text-muted">Belum Melakukan Presensi</p>
                      </div>
                        <div class="card border-0 shadow text-center mx-auto" style="width: 22rem;">
                          <img class="card-img-top" v-if="data.selfie_masuk !== null" :src="`upload/${data.selfie_masuk}`">
                          <div class="card-body"  v-if="data.selfie_masuk !== null">
                            <h5 class="card-title text-center" >Jam Masuk</h5>
                            <p class="card-text text-center">{{data.jam_masuk}}</p>
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                      <h6 class="form-control-label text-center" >Presensi Pulang</h6>
                      <div v-if="data.selfie_pulang == null"  class="mt-2 mb-2 card border-1 mx-auto shadow text-center" style="height:23.5rem !important; width: 22rem;"><p class="mt-9 text-muted">Belum Melakukan Presensi</p>
                      </div>
                      <div class="card border-0 shadow text-center mx-auto" style="width: 22rem;" v-if="data.selfie_pulang !== null">
                          <img class="card-img-top"  :src="`upload/${data.selfie_pulang}`">
                          <div class="card-body">
                            <h5 class="card-title text-center">Jam Pulang</h5>
                            <p class="card-text text-center">{{data.jam_pulang}}</p>
                          </div>
                      </div>
                    </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
  <div class="modal fade" id="lokasi" aria-labelledby="lokasiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered-top modal-xl  modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <h5 class="modal-title" id="lokasiLabel">Lokasi Anda Saat Ini</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="card-body" style="height: 500px !important"  id="map">
        <div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
						latmasuk: "",
						lonmasuk:"",
            latpulang:"",
            lonpulang:""
					}),
          cek:[],
          cek2:[],
          cek3:[],
          cekpresensi:[],
					jamabsen: [],
          detabsen:[],
					mimes: "",
					loggedIn: localStorage.getItem("loggedIn"),
					token: localStorage.getItem("token"),
					name: localStorage.getItem("name"),
					role: localStorage.getItem("role"),
          lat : localStorage.getItem("lat"),
          lon: localStorage.getItem("lon"),
          ceklok: "",
          lonlat:""

    }
  },
  methods:{
    getlokasi(){
      this.$axios.get('/api/getlokasi',{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.ceklok = response.data.data
                this.lonlat = response.data.success
                window.localStorage.setItem("ceklat", response.data.latitude)
                window.localStorage.setItem("ceklon", response.data.longitude)
            })
    },
    ceklokasi(latitude, longitude){
      $('#lokasi').modal('show')
             this.latt = latitude
             this.long = longitude
            navigator.geolocation.getCurrentPosition(
                position => {
                    var lat = position.coords.latitude
                    var lon = position.coords.longitude    
                },
            )   
             const lokasi = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
              const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: lokasi,
            });
            const marker = new google.maps.Marker({
                position: lokasi,
                map: map,
            });
    },
    cekizin(){
      let timerInterval
              Swal.fire({
              title: 'Harap Tunggu!',
              text: 'Kami Sedang Memeriksa Lokasi Terbaru Anda',
              timer: 4000,
              timerProgressBar: true,
              didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                    }, 100)
                   },
                    willClose: () => {
                    clearInterval(timerInterval)
                   }
                })
      this.izin()
      setTimeout(() => this.getlokasi(), 5000);
    },
    izin(){
         navigator.geolocation.getCurrentPosition(
           function (position) {
            var token =  localStorage.getItem("token")
              axios.post('/api/lokasi', {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
              },
                {
                  headers : { Authorization: "Bearer " + token },
                },
                ).then((response) => {
                  if (response.data.success){
                    const toast = useToast();
                          toast.success("Berhasil Mendapatkan Izin Lokasi", {
                          position: "top-center",
                          timeout: 2000,
                          icon: "fa-sharp fa-solid fa-thumbs-up"
                          });
                  }
                 
                    }
                  )
           },
          //  this.getlokasi(),
           error => {
              console.log(error.message);
           },
        )
       
    },
    kehadiran(){
          this.$router.push({name: "Kehadiran Pegawai"})
    },
    showDetail(){
             $('#detail').modal('show')
    }, 
    get(){
      this.$axios.get('/api/getabsen',{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detabsen = response.data.data
            })
    },
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
      showDetail() {;
      $('#detail').modal("show")
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
							 latmasuk : localStorage.getItem("ceklat"),
					     lonmasuk : localStorage.getItem("ceklon")
					 
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
                  this.get()
					}
          if (response.data.status == 2){
            const toast = useToast();
                  toast.error("Presensi Masuk Belum Dibuka", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						
					}
          if (response.data.status == 25){
            const toast = useToast();
                  toast.error("Anda Sedang Cuti", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						
					}
          if (response.data.status == 15){
            const toast = useToast();
                  toast.error("Harap Perbarui Lokasi Terlebih Dahulu", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						this.getlokasi()
					}
					if (response.data.success == false){
            const toast = useToast();
                  toast.error("Sudah Presensi Masuk", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						
					}
					if (response.data.status == 20){
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
                  toast.error("Presensi Gagal, Anda tidak mengizinkan lokasi, Harap Izinkan Lokasi Terlebih Dahulu, Terimakasih", {
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
					 selfie_pulang : image,
           latpulang : localStorage.getItem("ceklat"),
					 lonpulang : localStorage.getItem("ceklon")
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
            this.get()
					}
					if (response.data.status == false){
						const toast = useToast();
                  toast.error("Belum Saatnya Jam Pulang", {
                  position: "top-center",
                  timeout: 2500,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						
					}
          if (response.data.status == 15){
            const toast = useToast();
                  toast.error("Harap Perbarui Lokasi Terlebih Dahulu", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						this.getlokasi()
					}
          if (response.data.status == 3){
            const toast = useToast();
                  toast.error("Presensi Pulang Telah Ditutup", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-triangle-exclamation"
                  });
						
					}
          if (response.data.status == 12){
						const toast = useToast();
                  toast.error("Presensi Gagal, Anda tidak mengizinkan lokasi, Harap Izinkan Lokasi Terlebih Dahulu, Terimakasih", {
                  position: "top-center",
                  timeout: 4000,
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
    this.get()
    this.getlokasi()
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
