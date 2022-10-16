<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h6 class="mb-0">On Proses Penggajian Pegawai</h6>
        </div>
        <div class="col-6 text-end">
          <argon-button  color="success" @click="buatgaji()" size="sm" variant="gradient">
            <i class="fas fa-plus me-2" ></i>Buat Gaji</argon-button>
        </div>
      </div>
      <div class="col-md-4 mt-2 mb-3">
          <div class="d-flex form-input input-group">
            <span class="input-group-text text-body bg-gray-100" style="outline-width: 2px; border:none">
              <i class="fas fa-search"></i>
            </span>
            <input v-model="search2" style="border:none; box-shadow: none;" class="form-control form-control-md bg-gray-100" type="text" placeholder="Cari Gaji Pegawai..." >
          </div>
        </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2 mb-3">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
              <th></th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Email</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Periode</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Jabatan</th>
              <th
                class="ps-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Total Gaji</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Status</th>
              <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
              >Action</th>
          </thead>
          <tbody >
            <tr v-for="data in datagajipeg" :key="data.id">
              <td v-if="data.status == 'Belum Diambil'"></td>
              <td v-if="data.status == 'Belum Diambil'" class="align-middle">
                  <span class="text-secondary text-xs font-weight-bold">{{ data.email }}</span>
              </td>
              <td v-if="data.status == 'Belum Diambil'" class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ data.tanggal}}</span>
              </td>
              <td v-if="data.status == 'Belum Diambil'" class="align-middle">
                <span class="text-secondary text-xs font-weight-bold" v-for="jab in detjabatan" :key="jab.id">
                  <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                </span>
              </td>
              <td v-if="data.status == 'Belum Diambil'" class="align-middle">
                <span class="text-secondary text-xs font-weight-bold" v-if="data.status == 'Belum Diambil'">
                    <a v-for="tes in data.akhir" :key="tes.id">{{convertToRupiah(tes)}}</a>
                </span>
              </td>
              <td v-if="data.status == 'Belum Diambil'" class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-warning" v-if="data.status == 'Belum Diambil'">Belum Diambil</span>
              </td>
              <td v-if="data.status == 'Belum Diambil'" class="align-middle text-sm text-center">
                <span v-if="data.status == 'Belum Diambil'">
                  <span  @click.prevent="detailGaji(data.id)" style="margin-right:7px;cursor:pointer" class="badge badge-sm bg-primary" data-toggle="modal" >Detail</span>
                  <span  @click.prevent="modaledit(data, data.id)" style="margin-right:7px;cursor:pointer" class="badge badge-sm bg-danger" data-toggle="modal" >Edit</span>
                  <span  @click.prevent="hapusgaji(data.id)" class="badge badge-sm bg-warning" style="cursor:pointer" data-toggle="modal" >Hapus</span>
                </span>
                <div v-if="data.status == 'Sudah Diambil'">
                  <span  @click.prevent="detailGaji(data.id)" style="margin-right:7px;cursor:pointer" class="badge badge-sm bg-primary" data-toggle="modal" >Detail</span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <!-- <hr style="border-top: 1.5px solid #bbb;"> -->
      </div>
    </div>
  </div>
  <div class="modal fade" @click.self="clear()" id="buatgaji" aria-labelledby="buatgajiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title" id="buatgajiLabel">Buat Gaji Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Email Pegawai</label>
                        <select class="form-select" v-model="form.email">
                          <option v-for="data in filteremail" :key="data.email" :selected="data.email == form.email ? selected : null" :value="data.email">{{data.email}}</option>
                        </select>
                    </div>
                    <hr style="border-top: 1.5px solid #bbb;">
                    <label class="form-label text-md">Pilih Tunjangan Pegawai</label>
                    <div class="form-check">
                        <label class="col-9 form-label" v-for="data in tunjangan" :key="data.id">
                            <input class="form-check-input" type="checkbox" v-model="gajiMultiple" :value="data.id" @click="select" @change="select"/>
                            <span value={{form.id_tunjangan}}></span>{{data.jenis_tunjangan}} : {{convertToRupiah (data.nominal) }}
                        </label>
                    </div>
                    <hr style="border-top: 1.5px solid #bbb;">
                    <label class="form-label text-md">Pilih Bonus Pegawai</label>
                    <div class="form-check">
                        <label class="col-9 form-label" v-for="data in bonus" :key="data.id">
                            <input class="form-check-input" type="checkbox" v-model="bonusMultiple" :value="data.id" @click="select" @change="select"/>
                            <span value={{form.id_bonus}}></span>{{data.jenis_bonus}} : {{convertToRupiah (data.nominal) }}
                        </label>
                    </div>	
                    <hr style="border-top: 1.5px solid #bbb;">
                    <label class="form-label text-md">Pilih Potongan Pegawai</label>
                    <div class="form-check">
                        <label class="col-9 form-label" v-for="data in potongan" :key="data.id">
                            <input class="form-check-input" type="checkbox" v-model="potonganMultiple" :value="data.id" @click="select" @change="select"/>
                            <span value={{form.id_potongan}}></span>{{data.jenis_potongan}} : {{convertToRupiah (data.nominal) }}
                        </label>
                    </div>								
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" @click="clear()">Clear</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" type="submit" @click="submitgaji()" >Buat Gaji</button>
      </div>
    </div>
  </div>
  </div>

  <div class="modal fade" @click.self="clear()" id="editgaji" aria-labelledby="editgajiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editgajiLabel">Update Gaji Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form>
                    <label class="form-label">Email</label>
                        <div class="form-control form-control-md" v-for="(data) in detgaji" :key="data.id">{{data.email}}</div>
                    <hr style="border-top: 1.5px solid #bbb;">
                    <label class="form-label text-md">Edit Tunjangan Pegawai</label>
                    <div class="form-check">
                        <label class="col-9 form-label" v-for="data in tunjangan" :key="data.id">
                            <input class="form-check-input" type="checkbox" v-model="gajiMultiple" :value="parseInt(data.id)" @click="select" @change="select"/><span value={{form.id_tunjangan}}></span>{{data.jenis_tunjangan}} : {{convertToRupiah (data.nominal) }}
                        </label>
                    </div>
                    <hr style="border-top: 1.5px solid #bbb;">
                    <label class="form-label text-md">Edit Bonus Pegawai</label>
                    <div class="form-check">
                        <label class="col-9 form-label" v-for="data in bonus" :key="data.id">
                            <input class="form-check-input" type="checkbox" v-model="bonusMultiple" :value="parseInt(data.id)" @click="select" @change="select"/><span></span>{{data.jenis_bonus}} : {{convertToRupiah (data.nominal) }}
                        </label>
                    </div>	
                    <hr style="border-top: 1.5px solid #bbb;">
                    <label class="form-label text-md">Edit Potongan Pegawai</label>
                    <div class="form-check">
                        <label class="col-9 form-label" v-for="data in potongan" :key="data.id">
                            <input class="form-check-input" type="checkbox" v-model="potonganMultiple" :value="parseInt(data.id)" @click="select" @change="select"/><span></span>{{data.jenis_potongan}} : {{convertToRupiah (data.nominal) }}
                        </label>
                    </div>								
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" @click="clear()">Clear</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closegajiedit()">Batal</button>
        <button class="btn btn-primary" type="submit" @click="submiteditgaji()" >Update</button>
      </div>
    </div>
  </div>
  </div>

  <div class="modal fade" id="detailgaji" aria-labelledby="detailgajiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailgajiLabel">Detail Gaji Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5 class="modal-title" id="detailgaji" v-for="(data) in detgaji" :key="data.id">Detail Penggajian 
            <a style="font-weight:bolder">{{data.email}}</a></h5>
        <br>
        <div class="table-responsive">
            <table class="table table-borderless"  v-for="(data) in detgaji" :key="data.id">
                <thead class="">
                    <tr class="text-bold">
                        <td>Jenis</td>
                        <td class="text-right">Nominal</td>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td class="text-right" v-for="jabgaji in data.totjab" :key="jabgaji.id">{{convertToRupiah(jabgaji)}}</td>
                    </tr>
                    <h6 class="" style="margin-left:7px">Detail Tunjangan</h6>
                    <tr>
                        <td>
                            <span v-for="tundet in data.dettun" :key="tundet.id">
                                <li style="list-style:none;">{{tundet}}</li>
                            </span>
                        </td> 
                        <td class="text-right">
                            <span v-for="nomtun in data.nomdettun" :key="nomtun.id">
                                <li style="list-style:none">{{convertToRupiah(nomtun)}}</li>
                            </span>
                        </td> 
                    </tr>
                    <h6 class="" style="margin-left:7px">Detail Bonus</h6>
                    <tr>
                        <td>
                            <span v-for="bondet in data.detbon" :key="bondet.id">
                                <li style="list-style:none;">{{bondet}}</li>
                            </span>
                        </td> 
                        <td class="text-right">
                            <span v-for="nomibon in data.nombon" :key="nomibon.id">
                                <li style="list-style:none">{{convertToRupiah(nomibon)}}</li>
                            </span>
                        </td> 
                    </tr>
                </thead>
                <thead class="" >
                    <tr class="text-bold">
                        <td>Sub Total/Gaji Kotor</td>
                        <td class="text-start" v-for="sub in data.subtotal" :key="sub.id">{{convertToRupiah(sub)}}</td>
                    </tr>
                </thead>
                <thead>
                    <h6 class="" style="margin-left:7px">Detail Potongan</h6>
                    <tr>
                        <td>
                            <span v-for="potdet in data.detpot" :key="potdet.id">
                                <li style="list-style:none;">{{potdet}}</li>
                            </span>
                        </td> 
                        <td class="text-right">
                            <span v-for="nomipot in data.nompot" :key="nomipot.id">
                                <li style="list-style:none">{{convertToRupiah(nomipot)}}</li>
                            </span>
                        </td> 
                    </tr>
                </thead>
                <thead class="" >
                    <tr class="text-bold">
                        <td>Total Potongan</td>
                        <td class="text-right">
                            <span v-for="totapot in data.totpot" :key="totapot.id">
                                <a>(-) {{convertToRupiah(totapot)}}</a>
                            </span>
                        </td> 
                    </tr>
                </thead>
                <thead class="" >
                    <tr class="text-bold">
                        <td>Terima Bersih</td>
                        <td class="text-right" v-for="totagaj in data.totalgaji" :key="totagaj.id">
                            <a>{{convertToRupiah(totagaj)}}</a>
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
import setNavPills from "../../assets/js/nav-pills.js";
import ArgonButton from "../components/tes/ArgonButton.vue";
import ArgonCheckbox from "../components/tes/ArgonCheckbox.vue";
import {useToast} from 'vue-toastification';

export default {
  components: {
    ArgonButton,
    ArgonCheckbox
  },
  name: "data-payroll",
  data() {
        return {
            searchpot: '',
            searchtun: '',
            searchbon: '',
            searchgol: '',
            search2: '', 
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
            gajiMultiple: [],
            bonusMultiple: [],
            potonganMultiple: [],
            tunjangan:[],
            bonus:[],
            potongan:[],
            golongan:[],
            datagaji:[],
            detgaji: [],
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
        search2: function ()
            {
                this.searchgaji(this.search2)
            },
         searchtun: function ()
            {
                this.searchtunjangan(this.searchtun)
            },
         searchbon: function ()
            {
                this.searchbonus(this.searchbon)
            },
         searchgol: function ()
            {
                this.searchgolongan(this.searchgol)
            },
        searchpot: function ()
            {
                this.searchpotongan(this.searchpot)
            },               
        },
        
    methods:{
        select() {
            console.log(this.gajiMultiple)
            console.log(this.bonusMultiple)
            console.log(this.potonganMultiple)
        },
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
         searchtunjangan(val) {
            if (val == "")
            {
                this.alltunjangan()
            }else {
                this.$axios
                    .get('/api/searchtunjangan/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.tunjangan = response.data;
                    });
            }
        },
         searchbonus(val) {
            if (val == "")
            {
                this.allbonus()
            }else {
                this.$axios
                    .get('/api/searchbonus/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.bonus = response.data;
                    });
            }
        },
         searchgolongan(val) {
            if (val == "")
            {
                this.allgolongan()
            }else {
                this.$axios
                    .get('/api/searchgolongan/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.golongan = response.data;
                    });
            }
        },
         searchpotongan(val) {
            if (val == "")
            {
                this.allpotongan()
            }else {
                this.$axios
                    .get('/api/searchpotongan/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.potongan = response.data;
                    });
            }
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
          riwayat(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/riwayatgaji',{
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
        modaledit(data, id) {
           $("#editgaji").modal("show");
           this.$axios.get('/api/detailgaji/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response)=>{
                this.detgaji = response.data.data
            })
           this.idModal = id
           console.log(id)
           if(data.id_tunjangan.toString().includes(",")){
            this.gajiMultiple = []
            this.gajiMultiple = data.id_tunjangan.split(",")
           }else{
            this.gajiMultiple = []
            this.gajiMultiple.push(parseInt(data.id_tunjangan))
           }

            if(data.id_bonus.toString().includes(",")){
            this.bonusMultiple = []
            this.bonusMultiple = data.id_bonus.split(",")
           }else{
            this.bonusMultiple = []
            this.bonusMultiple.push(parseInt(data.id_bonus))
           }

            if(data.id_potongan.toString().includes(",")){
            this.potonganMultiple = []
            this.potonganMultiple = data.id_potongan.split(",")
           }else{
            this.potonganMultiple = []
            this.potonganMultiple.push(parseInt(data.id_potongan))
           }
        },
        closegajiedit() {
            this.form.reset();
            $("#editgaji").modal("hide");
            this.gajiMultiple = []
            this.bonusMultiple = []
            this.potonganMultiple = []
        },
        clear(){
            this.gajiMultiple = []
            this.bonusMultiple = []
            this.potonganMultiple = []
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
         submiteditgaji(){
            this.$axios.post('/api/updategaji',
                {
                    id: parseInt(this.idModal),
                    id_tunjangan: this.gajiMultiple,
                    id_bonus: this.bonusMultiple,
                    id_potongan:this.potonganMultiple
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    const toast = useToast();
                    toast.success("Berhasil Update Data", {
                        position: "top-center",
                        timeout: 2000,
                        icon: "fa-sharp fa-solid fa-thumbs-up"
                    });
                     $("#editgaji").modal("hide");
                    this.tampilgaji();
                    this.clear()
                }else{
                    const toast = useToast();
                    toast.error("Gagal, Data Tidak Lengkap", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-solid fa-triangle-exclamation"
                  });
                }
            })
        },
        hapusgaji(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            const custom = Swal.mixin({
            customClass: {
              confirmButton: 'btn bg-gradient-success',
              cancelButton: 'btn bg-gradient-danger',
            },
            buttonsStyling: false
          })
      custom.fire({
        title: 'Hapus Gaji Pegawai ?',
        text: "Anda tidak akan bisa mengembalikannya lagi!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '',
        showConfirmButton:true,
        confirmButtonText: 'Hapus Gaji',
        cancelButtonText: 'Batal',
      }).then((result) => {
           if (result.isConfirmed) {
              this.$axios.delete('/api/hapusgaji/'+id, {headers: { Authorization: "Bearer " + this.token }})
              .then((response) => {
                if(response.data.success == true){
                  const toast = useToast();
                  toast.success("Berhasil Menghapus Gaji Pegawai", {
                  position: "top-center",
                  timeout: 2000,
                  icon: "fa-sharp fa-solid fa-thumbs-up"
                  })
                  this.tampilgaji()  
                };
              })}
             
          }
        )
      })
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
                    const toast = useToast();
                    toast.success("Berhasil Membuat Gaji", {
                        position: "top-center",
                        timeout: 2000,
                        icon: "fa-sharp fa-solid fa-thumbs-up"
                    });
                    this.form.reset();
                    $("#buatgaji").modal("hide");
                    this.tampilgaji()
                    this.clear()
                }else{
                    const toast = useToast();
                    toast.error("Gagal, Data Tidak Lengkap", {
                    position: "top-center",
                    timeout: 2000,
                    icon: "fa-solid fa-triangle-exclamation"
                  });
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
        //TUNJANGAN
         showModal() {
            this.statusmodal = false;
            this.form.reset();
            $("#tambahtunjangan").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#tambahtunjangan").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#tambahtunjangan").modal("hide");
        },
        //BONUS
         showModal2() {
            this.statusmodal2 = false;
            this.form.reset();
            $("#tambahbonus").modal("show");
        },
        showModalEdit2(data) {
            this.statusmodal2 = true;
            this.form.reset();
            $("#tambahbonus").modal("show");
            this.form.fill(data);
        },
        closeModal2() {
            this.form.reset();
            $("#tambahbonus").modal("hide");
        },
        //GOLONGAN
        showModal3() {
            this.statusmodal3 = false;
            this.form.reset();
            $("#tambahgolongan").modal("show");
        },
        showModalEdit3(data) {
            this.statusmodal3 = true;
            this.form.reset();
            $("#tambahgolongan").modal("show");
            this.form.fill(data);
        },
        closeModal3() {
            this.form.reset();
            $("#tambahgolongan").modal("hide");
        },
         //POTONGAN
        showModal4() {
            this.statusmodal3 = false;
            this.form.reset();
            $("#tambahpotongan").modal("show");
        },
        showModalEdit4(data) {
            this.statusmodal3 = true;
            this.form.reset();
            $("#tambahpotongan").modal("show");
            this.form.fill(data);
        },
        closeModal4() {
            this.form.reset();
            $("#tambahpotongan").modal("hide");
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
      
        //TUNJANGAN
        edittunjangan(){
        
              this.$axios.post('/api/updatetunjangan',
                {
                    id: this.form.id,
                    jenis_tunjangan: this.form.jenis_tunjangan,
                    nominal: this.form.nominal,
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Update Tunjangan",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $("#tambahtunjangan").modal("hide");
                    this.alltunjangan()
                }
            

           })
        },
        addtunjangan() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.form.post('/api/tambahtunjangan', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menambahkan Tunjangan",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $('#tambahtunjangan').modal('hide')
                    this.alltunjangan()
                }
                    
                    }
                )
                    })
        },
         alltunjangan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alltunjangan',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.tunjangan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
         hapustunjangan(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Tunjangan ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1BC5BD',
            cancelButtonColor: '',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            }).then((result) => {
                 if (result.isConfirmed) {
                 this.$axios.delete('/api/hapustunjangan/'+id,  {
                headers: { Authorization: "Bearer " + this.token },
                },
                )
                  Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menghapus Tunjangan Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    };
           
                    this.alltunjangan()

            },

            )

            })
        },
        //BONUS
        editbonus(){
        
              this.$axios.post('/api/updatebonus',
                {
                    id: this.form.id,
                    jenis_bonus: this.form.jenis_bonus,
                    nominal: this.form.nominal,
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Update Bonus",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $("#tambahbonus").modal("hide");
                    this.allbonus()
                }
            

           })
        },
        addbonus() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.form.post('/api/tambahbonus', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menambahkan Bonus",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $('#tambahbonus').modal('hide')
                    this.allbonus()
                }
                    
                    }
                )
                    })
        },
         allbonus(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/allbonus',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.bonus = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
         hapusbonus(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Bonus ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1BC5BD',
            cancelButtonColor: '',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            }).then((result) => {
                 if (result.isConfirmed) {
                 this.$axios.delete('/api/hapusbonus/'+id,  {
                headers: { Authorization: "Bearer " + this.token },
                },
                )
                  Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menghapus Bonus Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    };
           
                    this.allbonus()

            },

            )

            })
        },
         //BONUS
        editpotongan(){
              this.$axios.post('/api/updatepotongan',
                {
                    id: this.form.id,
                    jenis_potongan: this.form.jenis_potongan,
                    nominal: this.form.nominal,
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Update Akun Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $("#tambahpotongan").modal("hide");
                    this.allpotongan()
                }
            

           })
        },
        addpotongan() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.form.post('/api/tambahpotongan', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menambahkan Potongan",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $('#tambahpotongan').modal('hide')
                    this.allpotongan()
                }
                    
                    }
                )
                    })
        },
         allpotongan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/allpotongan',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.potongan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
         hapuspotongan(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Potongan ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1BC5BD',
            cancelButtonColor: '',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            }).then((result) => {
                 if (result.isConfirmed) {
                 this.$axios.delete('/api/hapuspotongan/'+id,  {
                headers: { Authorization: "Bearer " + this.token },
                },
                )
                  Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menghapus Potongan Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    };
           
                    this.allpotongan()

            },

            )

            })
        },
        //GOLONGAN
        editgolongan(){
        
              this.$axios.post('/api/updategolongan',
                {
                    id: this.form.id,
                    golongan: this.form.golongan,
                    pendidikan: this.form.pendidikan,
                    nominal: this.form.nominal,
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Update Akun Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $("#tambahgolongan").modal("hide");
                    this.allgolongan()
                }
            

           })
        },
        addgolongan() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.form.post('/api/tambahgolongan', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menambahkan Golongan",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $('#tambahgolongan').modal('hide')
                    this.allgolongan()
                }
                    
                    }
                )
                    })
        },
         allgolongan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/allgolongan',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.golongan = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
         hapusgolongan(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Golongan ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1BC5BD',
            cancelButtonColor: '',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            }).then((result) => {
                 if (result.isConfirmed) {
                 this.$axios.delete('/api/hapusgolongan/'+id,  {
                headers: { Authorization: "Bearer " + this.token },
                },
                )
                  Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menghapus Golongan Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    };
           
                    this.allgolongan()

            },

            )

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
            this.alltunjangan();
            this.allgolongan();
            this.allpotongan();
            this.allbonus();
            this.getpt();
            this.tampilgaji();
            this.allJabatan();
            this.getdataPegawai();
    }

};
</script>
