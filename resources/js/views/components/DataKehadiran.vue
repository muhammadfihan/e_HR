<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Tabel Kehadiran Pegawai</h6>
        </div>
        <div class="col-6 text-end" style="visibility:hidden">
          <argon-button color="success" @click="showModal()" size="sm" variant="gradient">
            <i class="fas fa-plus me-2" ></i>Tambah Jabatan</argon-button>
        </div>
      </div>

        <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Pegawai..." >
          </div>
        </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pegawai</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Nama Lengkap</th>
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
              >Detail Lokasi</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data,index) in absensipegawai.data" :key="data.id">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{index+1}} </span>
              </td>
              <td>
                <p class="text-xs font-weight-bold mb-0">{{ data.name }}</p>
                <p class="text-xs text-secondary mb-0">{{ data.email }}</p>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.nama_lengkap }}</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{data.jam_masuk}}</span>
              </td>
              <td class="align-middle text-center text-xs ">
                <!-- <span class="text-secondary text-xs font-weight-bold">Tes</span> -->
                <span class="badge badge-sm bg-gradient-success" v-if="data.jam_pulang == null" >Sedang bekerja</span>
                <span class="text-secondary text-xs font-weight-bold" v-else-if="data.jam_pulang != null" >{{data.jam_pulang}}</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{ format(data.jam_kerja) }}</span>
              </td>
              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal }}</span>
              </td>
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-gradient-success" v-if="data.keterangan == 'On Time'" >{{data.keterangan}}</span>
                <span class="badge badge-sm bg-gradient-danger" v-else-if="data.keterangan == 'Terlambat'" >{{data.keterangan}}</span>
                <span class="badge badge-sm bg-info" v-else-if="data.keterangan == 'Request Attendance'" >{{data.keterangan}}</span>
                <!-- <span class="badge badge-sm bg-gradient-danger" >{{data.status}}</span> -->
              </td>
              <td class="align-middle text-center text-sm" >
                <span style="margin-right:7px;cursor:pointer" class="badge badge-sm bg-primary" @click.prevent="detailPegawai(data.id)"><i class="fa-solid fa-location-dot me-0"></i> Maps</span>
              </td>
              <td class="align-middle text-center text-sm" >
                <span style="cursor:pointer" class="badge badge-sm bg-primary" @click.prevent="detailPegawai(data.id)">detail</span>
              </td>
            </tr>
          </tbody>
        </table>
        <hr style="border-top: 1.5px solid #bbb;">
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="absensipegawai" @pagination-change-page="tampilabsen" />
      </div>
    </div>
  </div>
</template>

<script>
import setNavPills from "../../assets/js/nav-pills.js";
import ArgonInput from "../components/tes/ArgonInput.vue";
import ArgonBadge from "../components/tes/ArgonBadge.vue";
import ArgonButton from "../components/tes/ArgonButton.vue";
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
            this.$axios.get('/api/tampilabsen',{
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
//   mounted() {
//     setNavPills();
//     this.getJabatan();
//     this.getdataPegawai();
//     this.getpt();
//     this.allgolongan();
// },
methods:{
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
                axios
                    .get('/api/searchabsen/'+ val , {
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
    	detailabsen(uid){
             $('#detailmodal').modal('show')
             axios.get('/api/detailabsen/'+uid,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detabsen = response.data.data
            })
         },
        close(){
             $('#detailmodal').modal('hide')
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
            this.$axios.get('/api/tampilabsen?page=' +page,{
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
        
    },
     watch: {
                search: function ()
                {
                    this.searchabsen(this.search)
                }
        },
    mounted(){
        this.getpt();
		    this.tampilabsen();
        // this.initMap();
    },
};
</script>