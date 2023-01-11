<template>
  <div class="card h-1000" style="height:630px !important">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">Riwayat Penggajian Pegawai</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button  color="success" @click="buatgaji()" size="sm" style="visibility:hidden" variant="gradient">
            <i class="fas fa-plus me-2" ></i>Buat Gaji</argon-button>
        </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="search" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Gaji Pegawai..." >
          </div>
        </div>
      </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
        <div v-if="this.riwayatgaji.data == ''" class="table-responsive p-0">
        <table class="table align-items-center mb-0">
            <thead>
                <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >No</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Periode</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >email</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Jabatan</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Gaji Bersih</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Gaji Kotor</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Total Tunjangan</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Total Bonus</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Total Potongan</th>
                <th
                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Transaksi</th>
                <th
                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Action</th>
            </thead>
        </table>
        <p class="text-center text-secondary text-xl font-weight-bold mt-9" style="font-size:23px">Data Kosong</p>
      </div>
      <div v-else-if="this.riwayatgaji.data != ''" class="table-responsive p-0 border-bottom">
        <table class="table align-items-center mb-0">
            <thead>
                <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >No</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Periode</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >email</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Jabatan</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Gaji Bersih</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Gaji Kotor</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Total Tunjangan</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Total Bonus</th>
                <th
                  class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Total Potongan</th>
                <th
                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Transaksi</th>
                <th
                  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                >Action</th>
            </thead>
          <tbody >
            <tr v-for="(data,index) in riwayatgaji.data" :key="data.id">
                <td class="align-middle text-center">
                     <span class="text-secondary text-xs font-weight-bold">{{index+1}}</span>
                </td>
                <td  class="align-middle">
                  <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal_ambil}}</span>
                </td>
                <td  class="align-middle">
                  <span class="text-secondary text-xs font-weight-bold">{{ data.email}}</span>
                </td>
                <td  class="align-middle">
                  <span class="text-secondary text-xs font-weight-bold" v-for="jab in detjabatan" :key="jab.id">
                    <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                  </span>
                </td>
                <td  class="align-middle">
                  <span class="text-secondary text-xs font-weight-bold">
                      <a>{{convertToRupiah(data.gaji_bersih)}}</a>
                  </span>
                </td>
                <td  class="align-middle">
                  <span class="text-secondary text-xs font-weight-bold">
                      <a>{{convertToRupiah(data.gaji_kotor)}}</a>
                  </span>
                </td>
                <td  class="align-middle">
                  <span class="text-secondary text-xs font-weight-bold">
                      <a>{{convertToRupiah(data.total_tunjangan)}}</a>
                  </span>
                </td>
                <td  class="align-middle">
                  <span class="text-secondary text-xs font-weight-bold">
                      <a>{{convertToRupiah(data.total_bonus)}}</a>
                  </span>
                </td>
                <td  class="align-middle">
                  <span class="text-secondary text-xs font-weight-bold">
                      <a>{{convertToRupiah(data.total_potongan)}}</a>
                  </span>
                </td>
                <td  class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-success" v-if="data.status == 'Cair'">Berhasil</span>
                </td>
                <td  class="align-middle text-sm text-center">
                    <span  @click.prevent="getriwayatdetail(data.id)" style="cursor:pointer" class="badge badge-sm bg-primary" data-toggle="modal" >Detail</span>
                </td>
              </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mb-2">
        <Pagination class="pagination pagination-sm pagination justify-content-end" align="center" size="small" :data="riwayatgaji" @pagination-change-page="riwayat" />
      </div>
    </div>
  </div>

  <div class="modal fade" id="detriwayat" aria-labelledby="detriwayatLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detriwayatLabel">Detail Gaji Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5 class="modal-title" id="detriwayat" v-for="(data) in detriwayat" :key="data.id">Detail Penggajian 
            <a style="font-weight:bolder">{{data.email}}</a></h5>
        <br>
        <div class="table-responsive">
            <table class="table table-borderless"  v-for="(data) in detriwayat" :key="data.id">
                <thead class="">
                    <tr class="text-bold">
                        <td>Jenis</td>
                        <td class="text-right">Nominal</td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td class="text-right">{{convertToRupiah(data.gaji_pokok)}}</td>
                    </tr>
                    <h6 class="" style="margin-left:7px">Detail Tunjangan</h6>
                    <tr>
                        <td>
                            <span v-for="x in data.detritun" :key="x.id">
                                <li style="list-style:none;">{{x}}</li>
                            </span>
                        </td> 
                        <td class="text-right">
                            <span v-for="x in data.detrinomtun" :key="x.id">
                                <li style="list-style:none">{{convertToRupiah(x)}}</li>
                            </span>
                        </td> 
                    </tr>
                    <h6 class="" style="margin-left:7px">Detail Bonus</h6>
                    <tr>
                        <td>
                            <span v-for="x in data.detribon" :key="x.id">
                                <li style="list-style:none;">{{x}}</li>
                            </span>
                        </td> 
                        <td class="text-right">
                            <span v-for="x in data.detrinombon" :key="x.id">
                                <li style="list-style:none">{{convertToRupiah(x)}}</li>
                            </span>
                        </td> 
                    </tr>
                </thead>
                <thead class="" >
                    <tr class="text-bold">
                        <td>Sub Total/Gaji Kotor</td>
                        <td class="text-start">{{convertToRupiah(data.gaji_kotor)}}</td>
                    </tr>
                </thead>
                <thead>
                    <h6 class="" style="margin-left:7px">Detail Potongan</h6>
                    <tr>
                        <td>
                            <span v-for="x in data.detripot" :key="x.id">
                                <li style="list-style:none;">{{x}}</li>
                            </span>
                        </td> 
                        <td class="text-right">
                            <span v-for="x in data.detrinompot" :key="x.id">
                                <li style="list-style:none">{{convertToRupiah(x)}}</li>
                            </span>
                        </td> 
                    </tr>
                </thead>
                <thead class="" >
                    <tr class="text-bold">
                        <td>Total Potongan</td>
                        <td class="text-right">
                            <span>
                                <a>(-) {{convertToRupiah(data.total_potongan)}}</a>
                            </span>
                        </td> 
                    </tr>
                </thead>
                <thead class="" >
                    <tr class="text-bold">
                        <td>Terima Bersih</td>
                        <td class="text-right">
                          <a>{{convertToRupiah(data.gaji_bersih)}}</a>
                        </td>
                    </tr>
                </thead>
            </table>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import setNavPills from "../../../assets/js/nav-pills.js";
import ArgonButton from "../tes/ArgonButton.vue";
import ArgonCheckbox from "../tes/ArgonCheckbox.vue";
import LaravelVuePagination from 'laravel-vue-pagination';
import {useToast} from 'vue-toastification'

export default {
  components: {
    ArgonButton,
    ArgonCheckbox,
    'Pagination': LaravelVuePagination
  },
  name: "data-payroll",
  data() {
        return {
            search: '',
            detritun: [],
            detrinomtun: [],
            detribon: [],
            detrinombon: [],
            detripot: [],
            detrinompot: [],
            detriwayat:[],
            riwayatgaji: [],
            subtotal: [],
            totjab: [],
            totalgaji: [],
            detpot: [],
            nompot: [],
            totpot: [],
            detbon: [],
            nombon: [],
            totbon: [],
            dettun : [],
            totun : [],
            nomdettun : [],
            akhir: [],
            nilai:[],
            bon: [],
            potong: [],
            cekbok:[],
            infopt:[],
            tunjangan:[],
            bonus:[],
            potongan:[],
            golongan:[],
            datagaji:[],
            detgaji: [],
            status: [],
            datagajipeg:[],
            detjabatan:[],
            infopt:[],
            detpegawai:[],
            datapegawai:[],
            statusmodal: false,
            statusmodal2: false,
            statusmodal3: false,
             form : new Form({
                id : "",
                email: "",
                // id_jabatan: "",
                id_tunjangan : [],
                id_bonus : [],
                id_potongan : [],
            }),
            
            form : new Form({
                id : "",
                jenis_tunjangan : "",
                golongan : "",
                pendidikan : "",
                jenis_bonus : "",
                jenis_potongan : "",
                nominal : "",
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    computed: {
    filteremail() {
        return this.datapegawai.filter(data => data.status == 'Aktif');
    },
    },
     watch: {
        search: function ()
            {
                this.searchriwayat(this.search)
            },
        },
        
    methods:{
   
        format(time){
        return time.replace(/(?:0)?(\d+):(?:0)?(\d+).*/,'$1 Jam');
		},
        getdataPegawai(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/sudahisi',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.datapegawai = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        sumNumbers(numbers) {
            var sum = 0;
            for (let i = 0; i < numbers.length; i++) {
                var elements = numbers[i];
                sum = sum + elements;
            }
            return sum;
        },
   
        //GAJI
         searchriwayat(val) {
            if (val == "")
            {
                this.riwayat()
            }else {
                this.$axios
                    .get('/api/searchriwayat/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.riwayatgaji = response.data;
                    });
            }
        },
        searchgaji(val) {
            if (val == "")
            {
                this.tampilgaji()
            }else {
                this.$axios
                    .get('/api/searchgaji/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                    this.datagajipeg = response.data.data;
                    // this.nilai = response.data.nominal;
                    this.nilai = response.data.tunjangan;
                    this.bon = response.data.bonus;
                    this.potong = response.data.potongan;
                    this.akhir = response.data.hasil;

                    for (let i = 0; i < this.nilai.length; i++) {
                        Object.assign(this.datagajipeg[i], { nilai: this.nilai[i] })
                    }
                    for (let i = 0; i < this.bon.length; i++) {
                        Object.assign(this.datagajipeg[i], { bon: this.bon[i] })
                    }
                    for (let i = 0; i < this.potong.length; i++) {
                        Object.assign(this.datagajipeg[i], { potong: this.potong[i] })
                    }
                    for (let i = 0; i < this.akhir.length; i++) {
                        Object.assign(this.datagajipeg[i], { akhir: this.akhir[i] })
                    }
                    });
            }
        },
          riwayat(page = 1){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/riwayatpenggajian?page=' +page,{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.riwayatgaji = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
         tampilgaji(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/allgaji',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.datagajipeg = response.data.data;
                    this.nilai = response.data.tunjangan;
                    this.bon = response.data.bonus;
                    this.potong = response.data.potongan;
                    this.akhir = response.data.hasil;

                    for (let i = 0; i < this.nilai.length; i++) {
                        Object.assign(this.datagajipeg[i], { nilai: this.nilai[i] })
                    }
                    for (let i = 0; i < this.bon.length; i++) {
                        Object.assign(this.datagajipeg[i], { bon: this.bon[i] })
                    }
                    for (let i = 0; i < this.potong.length; i++) {
                        Object.assign(this.datagajipeg[i], { potong: this.potong[i] })
                    }
                    for (let i = 0; i < this.akhir.length; i++) {
                        Object.assign(this.datagajipeg[i], { akhir: this.akhir[i] })
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
    
        closeriwayat() {
            this.form.reset();
            $("#detriwayat").modal("hide");
        },
        buatgaji(data, id) {
           $("#buatgaji").modal("show");
           this.form.fill(data)
        },
         closeDetGaji() {
            this.form.reset();
            $("#detailgaji").modal("hide");
        },
   
        detailGaji(id){
            $('#detailgaji').modal('show')
            this.$axios.get('/api/detailgaji/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detgaji = response.data.data
                //TUNJANGAN
                this.dettun = response.data.tunjangan;
                this.nomdettun = response.data.nominal;
                this.totun = response.data.arrtun;
                //BONUS
                this.detbon = response.data.bonus;
                this.nombon = response.data.nominal_bonus;
                this.totbon = response.data.arrbon;
                //POTONGAN
                this.detpot = response.data.potongan;
                this.nompot = response.data.nominal_potongan;
                this.totpot = response.data.arrpot;
                //TOTAL GAJI
                this.totalgaji = response.data.hasil;
                this.totjab = response.data.arrjab;

                this.subtotal = response.data.subtotal;
                //TUNJANGAN
                for (let i = 0; i < this.dettun.length; i++) {
                        Object.assign(this.detgaji[i], { dettun: this.dettun[i] })
                    }
                for (let i = 0; i < this.nomdettun.length; i++) {
                        Object.assign(this.detgaji[i], { nomdettun: this.nomdettun[i] })
                    }
                for (let i = 0; i < this.totun.length; i++) {
                        Object.assign(this.detgaji[i], { totun: this.totun[i] })
                    }    
                //BONUS
                for (let i = 0; i < this.detbon.length; i++) {
                        Object.assign(this.detgaji[i], { detbon: this.detbon[i] })
                    }
                for (let i = 0; i < this.nombon.length; i++) {
                        Object.assign(this.detgaji[i], { nombon: this.nombon[i] })
                    }
                for (let i = 0; i < this.totbon.length; i++) {
                        Object.assign(this.detgaji[i], { totbon: this.totbon[i] })
                    }    
                //POTONGAN
                for (let i = 0; i < this.detpot.length; i++) {
                        Object.assign(this.detgaji[i], { detpot: this.detpot[i] })
                    }
                for (let i = 0; i < this.nompot.length; i++) {
                        Object.assign(this.detgaji[i], { nompot: this.nompot[i] })
                    }
                for (let i = 0; i < this.totpot.length; i++) {
                        Object.assign(this.detgaji[i], { totpot: this.totpot[i] })
                    }
                //TOTAL GAJI
                for (let i = 0; i < this.totalgaji.length; i++) {
                        Object.assign(this.detgaji[i], { totalgaji: this.totalgaji[i] })
                    }
                for (let i = 0; i < this.totjab.length; i++) {
                        Object.assign(this.detgaji[i], { totjab: this.totjab[i] })
                    }
                  for (let i = 0; i < this.subtotal.length; i++) {
                        Object.assign(this.detgaji[i], { subtotal: this.subtotal[i] })
                    }   
    

            })
        },
          //Detail Riwayat
         getriwayatdetail(id){
            $('#detriwayat').modal('show')
            this.$axios.get('/api/detriwayatgaji/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detriwayat = response.data.data
                //ssds
                this.detritun = response.data.tunjangan
                this.detrinomtun = response.data.nomtun
                this.detribon = response.data.bonus
                this.detrinombon = response.data.nombon
                this.detripot = response.data.potongan
                this.detrinompot = response.data.nompot

                    for (let i = 0; i < this.detritun.length; i++) {
                        Object.assign(this.detriwayat[i], { detritun: this.detritun[i] })
                    }   
                    for (let i = 0; i < this.detrinomtun.length; i++) {
                        Object.assign(this.detriwayat[i], { detrinomtun: this.detrinomtun[i] })
                    }
                    for (let i = 0; i < this.detribon.length; i++) {
                        Object.assign(this.detriwayat[i], { detribon: this.detribon[i] })
                    }   
                    for (let i = 0; i < this.detrinombon.length; i++) {
                        Object.assign(this.detriwayat[i], { detrinombon: this.detrinombon[i] })
                    }    
                    for (let i = 0; i < this.detripot.length; i++) {
                        Object.assign(this.detriwayat[i], { detripot: this.detripot[i] })
                    }   
                    for (let i = 0; i < this.detrinompot.length; i++) {
                        Object.assign(this.detriwayat[i], { detrinompot: this.detrinompot[i] })
                    }        
            })
        },
        submitgaji(){
             this.$axios.post('/api/buatgaji',
                {
                    id: this.form.id,
                    email: this.form.email,
                    // id_jabatan: this.form.id_jabatan,
                    id_tunjangan: this.gajiMultiple,
                    id_bonus: this.bonusMultiple,
                    id_potongan:this.potonganMultiple
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Membuat Gaji",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $("#buatgaji").modal("hide");
                    this.tampilgaji()
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Data Kurang Lengkap",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                }
            

           })
        },
        showgaji(id){
            this.$axios.get('/api/detailpegawai/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detpegawai = response.data.data
            })
        },
         closeModalgaji() {
            this.form.reset();
            $("#buatgaji").modal("hide");
        },
        allJabatan(){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljabatan',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.detjabatan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
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
      
 

          convertToRupiah(value) {
            // value = value.toString()
            value = parseFloat(value)
            let rupiah = ''
            let valueRev = value.toString().split('').reverse().join('')
            for (let i = 0; i < valueRev.length; i++) {
                if (i % 3 === 0) rupiah += `${valueRev.substr(i, 3)}.`
            }

            const rp = rupiah
                .split('', rupiah.length - 1)
                .reverse()
                .join('')
            // console.log('rupiah', isNaN(rp), rupiah.length, rp, rupiah)
            if (rupiah === 'NaN.' || rupiah === 'NaN') {
                return '...'
            }
            return `Rp ${rp}`
        },
       


        
    },
     created() {
    },

    mounted () {
            setNavPills();
            this.riwayat();
            this.getpt();
            this.tampilgaji();
            this.allJabatan();
            this.getdataPegawai();
    }

};
</script>
