<template>
  <div class="card card-carousel overflow-hidden h-100 p-0">
    <div class="carousel slide h-100">
      <div class="carousel-inner border-radius-lg h-100 bg-gradient-primary" >
        <div class="card-header border-0 text-end bg-transparent " >
                <a class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  
                </a>
                  <button type="submit" class="btn btn-white text-primary font-weight-bolder" @click="showModal()">Atur Presensi</button>
        </div>
        <div class="card-body d-flex flex-column p-0" style="margin-top:-35px">
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
               <div class="" style="margin-top:20px"  >
													<!--begin::Row-->
													<div class="row m-0 text-center">
														<div class="col">
															<div class="font-size-lg text-white font-weight-bold" >Jam Masuk</div>
															<div class="font-size-h4 text-white font-weight-bolder">{{this.masukpilih}}</div>
														</div>
														<div class="col">
															<div class="font-size-lg text-white font-weight-bold">Jam Pulang</div>
															<div class="font-size-h4 text-white font-weight-bolder mb-4">{{this.pulangpilih}}</div>
														</div>
													</div>
												</div>
              </div>
        <div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="presensi" aria-labelledby="presensiLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="presensiLabel">Pengaturan Presensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
                <div class="row">
                    <div class="col-lg-6">
                      <label class="form-control-label" for="input-email"><h6>Tentukan Hari Kerja</h6></label>
                      <div class="form-check form-switch mb-3 ms-1" v-for="(data) in hariabsen" :key="data.id">
                        <input v-model="hariMultiple" data-on-color="success" :value="data.hari" @click="select" @change="select"  class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label text-bold" for="flexSwitchCheckDefault"><span value={{form.hari_keja}}></span>{{data.hari}}</label>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email"><h6>Tentukan Jam Presensi</h6></label>
                        <div class="mb-1">
                            <label class="form-label">Jam Masuk</label>
                            <input v-model="masukpilih" type="time" placeholder="" class="form-control form-control-sm w-60">
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Jam Pulang</label>
                            <input v-model="pulangpilih" type="time" placeholder="" class="form-control form-control-sm w-60">
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Jam Buka Presensi</label>
                            <input v-model="bukapilih" type="time" placeholder="" class="form-control form-control-sm w-60">
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Jam Tutup Presensi</label>
                            <input v-model="tutuppilih" type="time" placeholder="" class="form-control form-control-sm w-60">
                        </div>
                      </div>
                    </div>
                </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="Submit" @click="aturabsen()" class="btn btn-primary" data-bs-dismiss="modal">Update</button>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
  <div class="modal fade" id="detinfo" aria-labelledby="detinfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered-top modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="card-body" style="height: 300px !important"  id="map">
        <div>
          sadasdas
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</template>

<script>
import Form from "vform";
import ArgonInput from "../components/tes/ArgonInput.vue";
import {useToast} from 'vue-toastification'

export default {
  components: { ArgonInput },
  name: "carousel",
  data(){
    return{
      hariMultiple:[],
      form : new Form({
        hari_kerja : "",
        jam_masuk : "",
        jam_pulang : "",
        batas_pulang: "",
        id : "",
      }),
      haripilih:[],
      masukpilih:[],
      pulangpilih:[],
      bukapilih:[],
      tutuppilih:[],
      jamabsen:[],
      hariabsen:[],
      presensi:[],
      token: localStorage.getItem("token")
    }
  },  
  methods:{
      showModal() {
				$("#presensi").modal("show");
        if(this.haripilih.includes(",")){
          this.hariMultiple = this.haripilih.split(",")
        }else{
          this.hariMultiple = []
        }
			},
      detinfo() {
				$("#detinfo").modal("show");
			},
      select(){
        console.log(this.hariMultiple)
      },
      tampilhari(){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilhari',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.hariabsen = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
      },
      aturabsen(){
             this.$axios.post('/api/aturjamabsen',
                {
                    id: this.form.id,
                    jam_masuk: this.masukpilih,
                    jam_pulang: this.pulangpilih,
                    hari_kerja: this.hariMultiple,
                    buka_presensi: this.bukapilih,
                    tutup_presensi: this.tutuppilih
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                      const toast = useToast();
                      toast.success("Berhasil Mengatur Presensi", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-thumbs-up"
                      });
                    $("#presensi").modal("hide");
                    this.tampilabsen()
                }if(response.data.status == 2){
                  const toast = useToast();
                      toast.error("Jam Buka Presensi Tidak Boleh Lebih Dari Jam Masuk", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-triangle-exclamation"
                      });
                      this.tampilabsen()
                }if(response.data.status == 3){
                  const toast = useToast();
                      toast.error("Jam Tutup Presensi Tidak Boleh Kurang Dari Jam Pulang", {
                      position: "top-center",
                      timeout: 2000,
                      icon: "fa-sharp fa-solid fa-triangle-exclamation"
                      });
                      this.tampilabsen()
                }
            

           })
      },
      tampilabsen(){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampil',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.presensi = response.data.data;
                    if(this.presensi == null){
                      this.masukpilih = []
                      this.pulangpilih = []
                      this.bukapilih = []
                      this.tutuppilih = []
                    }else{
                      this.haripilih = response.data.data.hari_kerja
                      this.masukpilih = response.data.data.jam_masuk
                      this.pulangpilih = response.data.data.jam_pulang
                      this.bukapilih = response.data.data.buka_presensi
                      this.tutuppilih = response.data.data.tutup_presensi
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
  },
  mounted(){
    this.tampilhari()
    this.tampilabsen()
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

<style scoped>

</style>
