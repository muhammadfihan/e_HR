<template>
  <div class="card card-carousel overflow-hidden h-100 p-0">
    <div class="carousel slide h-100">
      <div class="carousel-inner border-radius-lg h-100 bg-white" >
        <div class="card-header border-0 text-end bg-transparent " >
          <button type="submit" class="me-2 btn btn-xs btn-outline-danger text-danger font-weight-bolder" @click="hapuspresensi()">Hapus</button>
            <button type="submit" class="btn btn-xs btn-outline-primary text-primary font-weight-bolder" @click="showModal()">Atur Presensi</button>
        </div>
        <div class="card-body d-flex flex-column p-0" style="margin-top:-35px">
							<div class="card-body" style="text-align:center;">
                  <div class="date text-primary" style="font-size:28px;">
                      <span id="dayname">Day</span>,&nbsp;
                      <span id="daynum">00</span>&nbsp;
                      <span id="month">Month</span>&nbsp;
                      <span id="year">Year</span>
                  </div>
                  <div class="time text-primary" style="font-size:40px;font-weight: 600; color: #124EB2;">
                      <span id="hour">00</span>:
                      <span id="minutes">00</span>:
                      <span id="seconds">00</span>
                  </div>
               </div>
               <div class="" style="margin-top:20px"  >
													<!--begin::Row-->
													<div class="row m-0 text-center">
														<div class="col">
															<div class="font-size-lg text-primary font-weight-bold" >Jam Masuk</div>
															<div class="font-size-h4 text-primary font-weight-bolder">{{this.masukpilih}}</div>
														</div>
														<div class="col">
															<div class="font-size-lg text-primary font-weight-bold">Jam Pulang</div>
															<div class="font-size-h4 text-primary font-weight-bolder mb-4">{{this.pulangpilih}}</div>
														</div>
													</div>
												</div>
              </div>
              <div class="text-center mb-2">
                <button v-if="this.bukapresencek == false" type="submit" class="btn btn-sm btn-white bg-warning text-white font-weight-bolder w-60" @click="bukapresensi()">Buka Presensi</button>
                <button v-else-if="this.bukapresencek == 12" type="submit" class="btn btn-sm btn-white bg-success text-white font-weight-bolder w-60">Presensi Sedang Berjalan</button>
                <button v-else-if="this.bukapresencek == null" type="submit" class="btn btn-sm btn-white bg-danger text-white font-weight-bolder w-60">Presensi Hari Ini Telah Berakhir</button>
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
      absensigrafik:[],
      hariabsen:[],
      bukapresencek:[],
      presensi:[],
      token: localStorage.getItem("token")
    }
  },  
  methods:{
      bukapresensi(){
        const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-success me-2 text-white',
              cancelButton: 'btn bg-warning text-white',
            },
            buttonsStyling: false
          })
        custom.fire({
            title: 'Buka Presensi Untuk Hari Ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Buka',
            cancelButtonText: 'Batal',
          }).then((result) => {
            if(result.isConfirmed){
              this.$axios.post('/api/bukapresensi',
               {
                headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
          if (response.data.success == 15){
                this.cekbuka()
                const toast = useToast();
                  toast.error("Maaf, Karyawan Anda Hari Ini Sedang Izin Semua", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-solid fa-triangle-exclamation"
                  });
          }        
          if (response.data.success == true){
                this.cekbuka()
                const toast = useToast();
                  toast.success("Presensi Hari Ini Berhasil Dibuka", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-sharp fa-solid fa-thumbs-up"
                  });
          }if (response.data.success == 12){
                  const toast = useToast();
                  toast.error("Jam Presensi Belum Buka", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-solid fa-triangle-exclamation"
                  });
          }if (response.data.success == null){
                  const toast = useToast();
                  toast.error("Bukan Hari Kerja, Tidak Bisa Membuka Presensi", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-solid fa-triangle-exclamation"
                  });
          }if (response.data.success == false){
                   const toast = useToast();
                   toast.error("Presensi Hari Ini Telah Dibuka", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-solid fa-triangle-exclamation"
                  });
          }
                })
            }
          })
      },
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
      cekbuka(){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/cekbuka',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.bukapresencek = response.data.success;
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
                    this.cekbuka()
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
        hapuspresensi(){
          this.$axios.get('/sanctum/csrf-cookie').then(response => {
          const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-success',
              cancelButton: 'btn bg-gradient-danger',
            },
            buttonsStyling: false
          })
            custom.fire({
            title: 'Hapus Presensi Hari Ini ?',
            text: "Anda Akan Menghapus Presensi Hari Ini",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '',
            showConfirmButton:true,
            confirmButtonText:'Hapus',
            cancelButtonText: 'Batal',
              }).then((result) => {
                  if (result.isConfirmed) {
                      this.$axios.delete('/api/hapusabsen', {headers: { Authorization: "Bearer " + this.token }})
                      .then((response) => {
                        if(response.data.success == 1){
                          const toast = useToast();
                          toast.success("Berhasil Menghapus Presensi Hari Ini", {
                          position: "top-center",
                          timeout: 2000,
                          icon: "fa-sharp fa-solid fa-thumbs-up"
                          })
                          this.cekbuka()  
                        };
                        if(response.data.success == 0){
                        const toast = useToast();
                          toast.error("Tidak Ada Presensi Berjalan Hari Ini", {
                          position: "top-center",
                          timeout: 2000,
                          icon: "fa-solid fa-triangle-exclamation"
                          })
                          this.cekbuka()
                          this.loadgrafik()
                        };
                      })}
                    
                  }
                )
              })
        },
        loadgrafik(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/grafikadmin',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.absensigrafik = response.data;
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
    this.cekbuka()
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
