<template>
  <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Tabel Kehadiran Pegawai</h6>
        </div>
        <div class="col-6 text-end" style="visibility:hidden">
          <argon-button color="primary" @click="showModal()" size="sm" variant="gradient">Buat Laporan</argon-button>
        </div>
      </div>
        <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="search" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Berdasarkan Tanggal/Keterangan..." >
          </div>
        </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div v-if="this.absensipegawai.data == ''" class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Masuk</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Pulang</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Kerja</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal Absen</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Keterangan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Detail Presensi</th>
            </tr>
          </thead>
        </table>
        <p class="text-center text-secondary text-xl font-weight-bold mt-9" style="font-size:23px">Data Kosong</p>
      </div>
      <div v-else-if="this.absensipegawai.data != ''" class="table-responsive p-0 border-bottom">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Masuk</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Pulang</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jam Kerja</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal Absen</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Keterangan</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Detail Presensi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in absensipegawai.data" :key="data.uid">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="text-secondary text-xs font-weight-bold" v-if="data.jam_masuk == null" >Null</span>
                <span class="text-secondary text-xs font-weight-bold" v-else-if="data.jam_masuk != null" >{{data.jam_masuk}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <!-- <span class="text-secondary text-xs font-weight-bold">Tes</span> -->
                <span class="text-secondary text-xs font-weight-bold" v-if="data.jam_pulang == null" >Null</span>
                <span class="text-secondary text-xs font-weight-bold" v-else-if="data.jam_pulang != null" >{{data.jam_pulang}}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="text-secondary text-xs font-weight-bold">{{ format(data.jam_kerja) }}</span>
                <span class="text-secondary text-xs font-weight-bold" v-if="data.jam_kerja == null" >Null</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal }}</span>
              </td>
              <td class="align-middle text-center text-xs">
                <span class="text-success fw-bolder text-xs" v-if="data.keterangan == 'On Time'" >{{data.keterangan}}</span>
                <span class="text-warning fw-bolder text-xs" v-else-if="data.keterangan == 'Terlambat'" >{{data.keterangan}}</span>
                <span class="text-info fw-bolder text-xs" v-else-if="data.keterangan == 'Request Absen'" >{{data.keterangan}}</span>
                <span class="text-primary fw-bolder text-xs" v-else-if="data.keterangan == 'Izin'" >{{data.keterangan}}</span>
                <span class="text-dark fw-bolder text-xs" v-else-if="data.keterangan == 'Cuti'" >{{data.keterangan}}</span>
                <span class="text-danger fw-bolder text-xs" v-else-if="data.keterangan == 'Tidak Hadir'" >{{data.keterangan}}</span>
                <!-- <span class="badge badge-sm bg-gradient-danger" >{{data.status}}</span> -->
              </td>
             <td class="align-middle text-center text-sm" >
                <span style="margin-right:7px;cursor:pointer" class="badge badge-sm bg-success" @click.prevent="modalmap(data.latmasuk, data.lonmasuk)"><i class="fa-solid fa-location-dot me-0"></i></span>
                <span style="margin-right:7px;cursor:pointer" class="badge badge-sm bg-danger" @click.prevent="modalmappulang(data.latpulang, data.lonpulang)"><i class="fa-solid fa-location-dot me-0"></i></span>
                <span style="cursor:pointer" class="badge badge-sm bg-primary" @click.prevent="detailabsen(data.uid)"><i class="fa-solid fa-camera"></i></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mb-1">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="absensipegawai" @pagination-change-page="tampilabsen" />
      </div>
    </div>
  </div>
  <div class="modal fade" id="detreq" aria-labelledby="detreqLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered-top modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <h5 class="modal-title" id="detreqLabel">Request Attendance yang Diterima</h5>
          <h7 class="modal-title" id="detreqLabel">Jumlah Kerja Request Attendance : {{jmlh}} Hari</h7>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Alasan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Surat/Bukti Pendukung</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Tanggal Request</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in absenreq" :key="data.id">
              <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{data.alasan}}</span>
              </td>
              <td class="align-middle text-sm">
                <span style="cursor:pointer" class="text-primary text-xs"><i class="fa-solid fa-file"></i><a class="text-primary" :href="`files/${data.bukti_pendukung}`"  target="_blank"> Document</a></span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal_req}}</span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="lokasi" aria-labelledby="lokasiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered-top modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <h5 class="modal-title" id="lokasiLabel">Lokasi Presensi Masuk Pegawai</h5>
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
  <div class="modal fade" id="lokasi2" aria-labelledby="lokasiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered-top modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <h5 class="modal-title" id="lokasiLabel">Lokasi Presensi Pulang Pegawai</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="card-body" style="height: 500px !important"  id="mappulang">
        <div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="detail" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <h5 class="modal-title" id="detailLabel">Foto Presensi Harian</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row"  v-for="(data) in detabsen" :key="data.id">
                    <div class="col-lg-6">
                      <h6 class="form-control-label text-center" >Foto Presensi Masuk</h6>
                        <div v-if="data.selfie_masuk == null" class="mt-2 mb-2 card border-1 shadow-none text-center" style="height:360px !important"><p class="mt-9 text-muted">Belum Melakukan Presensi</p>
                        </div>
                        <img v-if="data.selfie_masuk !== null" :src="`upload/${data.selfie_masuk}`" class="mt-2 mb-2 card border-1 shadow-none text-center mx-auto" style="height:360px !important; width:360px !important">
                    </div>
                    <div class="col-lg-6">
                      <h6 class="form-control-label text-center" >Foto Presensi Pulang</h6>
                      <div v-if="data.selfie_pulang == null" class="mt-2 mb-2 card border-1 shadow-none text-center" style="height:360px !important"><p class="mt-9 text-muted">Belum Melakukan Presensi</p>
                      </div>
                      <img v-if="data.selfie_pulang !== null" :src="`upload/${data.selfie_pulang}`" class="mt-2 mb-2 card border-1 shadow-none text-center mx-auto" style="height:360px !important; width:360px !important">  
                    </div>
                </div>
      </div>
      <div class="modal-footer border-top-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import setNavPills from "../../../assets/js/nav-pills.js";
import ArgonInput from "../tes/ArgonInput.vue";
import ArgonBadge from "../tes/ArgonBadge.vue";
import ArgonButton from "../tes/ArgonButton.vue";
import LaravelVuePagination from 'laravel-vue-pagination';
import { useToast } from "vue-toastification";

export default {
  components: {
    ArgonInput,
    ArgonBadge,
    ArgonButton,
    'Pagination': LaravelVuePagination
},
  name: "data-pegawai",
  data() {
      return {
			      search: '',
            infopt:[],
            detabsen:[],
            absenreq:[],
            jmlh:"",
            absensipegawai : [],
            lon: '',
            lat: '',
            map: '',
            infoWindow: '',
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
  created() {
         this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilpegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.absensipegawai = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
  },
methods:{
        presensi(){
          this.$router.push({name: "Presensi Harian"})
        },
        detailabsen(uid){
             $('#detail').modal('show')
             this.$axios.get('/api/detailabsenpeg/'+uid,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detabsen = response.data.data
            })
         },  
         modalmap(latitude, longitude){
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
         modalmappulang(latitude, longitude){
             $('#lokasi2').modal('show')
             this.latt = latitude
             this.long = longitude
            navigator.geolocation.getCurrentPosition(
                position => {
                    var lat = position.coords.latitude
                    var lon = position.coords.longitude    
                },
            )   
             const lokasi = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
              const map = new google.maps.Map(document.getElementById("mappulang"), {
            zoom: 16,
            center: lokasi,
            });
            const marker = new google.maps.Marker({
                position: lokasi,
                map: map,
            });
         },  
        initMap() {
        // The location of Uluru
        const uluru = { lat: -25.344, lng: 131.031 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
            position: uluru,
            map: map,
        });
        },
        
         searchabsen(val) {
            if (val == "")
            {
                this.tampilabsen()
            }else {
                this.$axios.get('/api/searchabsenpeg/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.absensipegawai = response.data;
                    });
            }
        },
		format(time){
		if (time != null){
			return time.replace(/(?:0)?(\d+):(?:0)?(\d+).*/,'$1 Jam');
		}
        
		},
		
		convertToSeconds(hours, minutes, seconds) {
		return Number(hours) * 60 * 60 + Number(minutes) * 60 + Number(seconds);
		},
        mapmodal(latitude, longitude){
             $('#mapmodal').modal('show')
             this.latt = latitude
             this.long = longitude
            navigator.geolocation.getCurrentPosition(
                position => {
                    var lat = position.coords.latitude
                    var lon = position.coords.longitude    
                },
            )   
             console.log(parseFloat(latitude))
             console.log(parseFloat(longitude))
             const lokasi = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
            //  this.initMap();
              const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: lokasi,
            });
            // The marker, positioned at Uluru
            const marker = new google.maps.Marker({
                position: lokasi,
                map: map,
            });
         },
         reqabsen(){
             $('#detreq').modal('show')
             this.tampilreq()
         },
        close(){
             $('#detail').modal('hide')
         },
         closeMap(){
             $('#mapmodal').modal('hide')
         },
        getpt(){
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
		  tampilabsen(page = 1){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilpegawai?page=' +page,{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.absensipegawai = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
		},
    tampilreq(){
			 this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/listreq',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.absenreq = response.data.data;
                    this.jmlh = response.data.jmlh
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
		},
        
    },
     watch: {
                search: function ()
                {
                    this.searchabsen(this.search)
                }
        },
    mounted(){
        this.getpt();
        this.tampilreq();
		    this.tampilabsen();
        // this.initMap();
    },
};
</script>