<template>
    <body>

    <div class="container-md" >

        <div class="main">
            <div>
                <h3 style="color:#E95A09">Data Pegawai</h3>
           </div>
            <div style="margin-top:20px">
            <table class="table align-middle border" >
                <thead class="" >
                <tr>
                    <th>&nbsp;</th>
                    <th>No</th>
                    <th>Akun Pegawai</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th>No Pegawai</th>
                    <th>Status</th>
                    <th>Gender</th>
                    <th style="text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(data,index) in pegawai" :key="data.id">
                        <td>
						    <label class="checkbox-wrap checkbox-success">
								<input type="checkbox">
								<span class="checkmark"></span>
							</label>
                        </td>
                        <td>{{index+1}} </td>
                        <td>
                            <div class="ms-3">
                                <p class="fw-bold mb-1">{{ data.name }}</p>
                                <p class="text-muted mb-0">{{ data.email }}</p>
                            </div>
                        </td>
                        <td><a>{{ data.nama_lengkap }}</a></td>
                        <td>
                            <a v-for="(dat) in jabatan" :key="dat.id" >
                            <a v-if="dat.id == data.id_jabatan" >{{ dat.jabatan }}</a>
                            </a>
                        </td>
                        <td><a>{{ data.no_pegawai }}</a></td>
                        <td>
                            <span class="badge badge-success" v-if="data.status == 'Aktif'" >{{data.status}}</span>
                            <span class="badge badge-danger" v-else-if="data.status == 'Tidak Aktif'" >{{data.status}}</span>
                        </td>
                        <td>{{ data.gender }}</td>
                        <td style="text-align: center;">
                             <button type="button" class="btn btn-link btn-sm btn-rounded" data-toggle="modal" data-target="#detailmodal" @click.prevent="detailPegawai(data.id)">
                                    Detail
                            </button>
                             <button type="button" class="btn btn-link btn-sm btn-rounded" data-toggle="modal"  @click="editModal(data)">
                                    Edit
                            </button>
                             <button type="button" class="btn btn-link danger btn-sm btn-rounded" style="color:red;" @click.prevent="hapusPegawai(data.id)">
                                    Hapus
                            </button>
                        </td>
                </tr>
            </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" id="detailmodal" tabindex="-1" role="dialog" aria-labelledby="detailmodal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="detailmodal" style="color:#E95A09">Detail Data Pegawai</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding:30px">
                    <div class="alert alert-danger" style="display:none"></div>
                    <form v-for="(data) in detpegawai" :key="data.id">
                        <div class="form-group">
                            <label style="font-weight:bold">Username</label>
                            <div type="text" class="form-control">{{data.name}}</div>
                        </div>
                         <div class="form-group">
                            <label style="font-weight:bold">Nama Lengkap</label>
                            <div type="text" class="form-control">{{data.nama_lengkap}}</div>
                        </div>
                        <div class="form-group" >
                            <label style="font-weight:bold">Jabatan</label>
                            <div v-for="(dat) in jabatan" :key="dat.id ">
                           <div  type="text" class="form-control" v-if="dat.id == data.id_jabatan">{{dat.jabatan}}</div>
                           </div>
                        </div>
                         <div class="form-group">
                            <label style="font-weight:bold">No Pegawai</label>
                           <div type="text"  class="form-control">{{data.no_pegawai}}</div>
                        </div>
                         <div class="form-group">
                            <label style="font-weight:bold">Email</label>
                           <div type="text"  class="form-control">{{data.email}}</div>
                        </div>
                         <div class="form-group">
                            <label style="font-weight:bold">No KTP</label>
                           <div type="text" class="form-control">{{data.no_ktp}}</div>
                        </div>
                         <div class="form-group">
                            <label style="font-weight:bold">No HP</label>
                           <div type="text" class="form-control">{{data.no_hp}}</div>
                        </div>
                         <div class="form-group">
                            <label style="font-weight:bold"> Gender</label>
                           <div type="text"  class="form-control">{{data.gender}}</div>
                        </div>
                         <div class="form-group">
                            <label style="font-weight:bold">Status</label>
                           <div type="text"  class="form-control" >
                              <span class="badge badge-success" v-if="data.status == 'Aktif'" >{{data.status}}</span>
                            <span class="badge badge-danger" v-else-if="data.status == 'Tidak Aktif'" >{{data.status}}</span>
                           </div>
                        </div>
                        <div class="form-group">
                            <label style="font-weight:bold">Alamat</label>
                            <textarea disabled name="description" class="textarea form-control" cols="40" rows="5"
                                style="background-color:white" v-model="data.alamat"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn" style=" border-radius:6px; background-color:#124EB2;color:white;width:100px " data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editPegawai" tabindex="-1" role="dialog" aria-labelledby="editPegawai" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="editPegawai" style="color:#E95A09">Update Data Pegawai</h2>
                    <button type="button" @click="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding:30px">
                    <div class="alert alert-danger" style="display:none"></div>
                    <form @submit.prevent="updatePegawai()" >
                        <div class="form-group" >
                            <label style="font-weight:bold">Jabatan</label>
                            <select class='form-control' v-model="form.id_jabatan">
                            <option disabled selected>Ubah Jabatan</option>
                            <option v-for="data in jabatan" :key="data.id"
                                            :selected="data.id == form.id_jabatan ? selected : null"
                                            :value="data.id">
                                        {{data.jabatan}}
                            </option>
                           </select>

                        </div>
                         <div class="form-group">
                            <label style="font-weight:bold">Status</label>
                           <select class='form-control' v-model="form.status">
                                <option >Aktif</option>
                                <option >Tidak Aktif</option>
                            </select>
                        </div>
                         <div class="modal-footer">
                   <button type="button" class="btn" style=" border-radius:6px; background-color:#E95A09;color:white;   width:100px " @click="closeModal()" data-dismiss="modal">Batal</button>
                     <button type="submit"  class="btn" style=" border-radius:6px; background-color:#124EB2;color:white;  width:100px">Simpan</button>
                </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    </div>
    </body>

</template>


<script>

export default {
    name: "DataPegawai",
    data() {
        return {
            pegawai: [],
            detpegawai: [],
            jabatan:[],
            editpegawai:[],
            updatepegawai :[],
            delpegawai:[],
            form: new Form ({
                id : "",
                name : "",
                id_jabatan : "",
                status : ""
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    created() {
    },
    methods:{
         closeModal() {
            this.form.reset();
            $("#editPegawai").modal("hide");
        },
        editModal(data) {
            // this.form.reset()
            $("#editPegawai").modal("show")
            this.form.fill({
                id: data.id,
                id_jabatan: data.id_jabatan,
                status: data.status,
            })
        },
        getdataPegawai(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/datapegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.pegawai = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
        detailPegawai(id){
            $('#detailPegawai').modal('show')
            axios.get('/api/detailpegawai/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detpegawai = response.data.data
            })
        },

        // editPegawai(id){
        //     $('#editPegawai').modal('show')
        //     axios.get('/api/editpegawai/'+id,  {
        //         headers: { Authorization: "Bearer " + this.token }
        //     }).then((response) => {
        //         this.editpegawai = response.data.data
        //     })
        // },

        // updatePegawai(id){
        //     axios.post('/api/updatepegawai/'+
        //      {
        //             id: this.form.id,
        //             name: this.form.name,
        //             jabatan: this.form.jabatan,
        //             status: this.form.status                },
        //          {
        //         headers: { Authorization: "Bearer " + this.token }
        //     }). then((response) => {
        //         this.updatepegawai = response.data.data
        //     })
        //     // console.log("ubah Data")

        // },
         updatePegawai(){
            axios.post('/api/updatepegawai',
                {
                    id: this.form.id,
                    id_jabatan: this.form.id_jabatan,
                    status: this.form.status
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Data Berhasil Diupdate",
                        showConfirmButton: false,
                        timer: 1600,
                    }),
                    $('#editPegawai').modal('hide');
                    this.getdataPegawai();
                }
            })
        },

        getJabatan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/alljabatan',{
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
        hapusPegawai(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Data Pegawai ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#124EB2',
            cancelButtonColor: '#E95A09',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            }).then((result) => {
                 if (result.isConfirmed) {
                 axios.delete('/api/hapuspegawai/'+id,  {
                headers: { Authorization: "Bearer " + this.token }

            },)
             Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menghapus Data Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    }),
                    this.getdataPegawai()

                }

            },)
            }
        )}
    },

    mounted() {
        this.getJabatan();
        this.getdataPegawai();
    },
    // beforeRouteEnter(to, from, next) {
    //     if (JSON.parse(window.localStorage.getItem("loggedIn"))) {
    //         if(window.localStorage.getItem("role") == 'Manager'){
    //             return next();
    //         } else if (window.localStorage.getItem("role") == 'Admin') {
    //             return next();
    //         } else if (window.localStorage.getItem("role") == 'Pegawai') {
    //             return next();
    //         }
    //     }
    //     next();
    // },


}


</script>


