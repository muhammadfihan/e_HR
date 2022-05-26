<template>
    <body>

    <div class="container-md" >

        <div class="main">
            <!-- <div class="row" style=" margin-bottom:6px; margin-left:-2px; font-style: normal; font-size:30px; line-height: 47px;color: #E95A09;">
                <p>Data Akun Pegawai</p>
                <button class="btn tambah" data-toggle="modal" @click="showModal()" style="margin-left:942px; color:white">Add Akun</button>
            </div> -->
            <div class="row">
                <div class="col-md-12 text-left">
                    <h3 style="color:#E95A09">Data Akun Pegawai</h3>
                    <!-- <button type="button" class="btn btn-warning ">Save</button> -->
                </div>
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" @click="showModal()"  style="background-color:#124EB2">Tambah Akun</button>
                    <!-- <button type="button" class="btn btn-warning ">Save</button> -->
                </div>
                </div>
            <div style="margin-top:10px">
                  <table class="table align-start border"  >
                <thead class="" >
                <tr>
                    <th>&nbsp;</th>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th style="text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(data,index) in akunpegawai" :key="data.id">
                        <td>
						    <label class="checkbox-wrap checkbox-success">
								<input type="checkbox">
								<span class="checkmark"></span>
							</label>
                        </td>
                        <td>{{index+1}} </td>
                        <td>{{ data.name }}</td>
                        <td>{{ data.email }}</td>
                        <td style="text-align: center;">
                             <button type="button" class="btn btn-link btn-sm btn-rounded" data-toggle="modal" @click.prevent="showModalEdit(data)">
                                    Edit
                            </button>
                             <button type="button" class="btn btn-link danger btn-sm btn-rounded" style="color:red;" @click.prevent="hapusAkun(data.id)">
                                    Hapus
                            </button>
                        </td>
                </tr>
            </tbody>
            </table>
            </div>
          
        </div>

    <div class="modal fade" id="tambahAkun" tabindex="-1" role="dialog" aria-labelledby="tambahAkun" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" v-show="!statusmodal"  id="tambahAkun" style="color:#E95A09">Tambah Akun Pegawai</h2>
                    <h2 class="modal-title" v-show="statusmodal"  id="tambahAkun" style="color:#E95A09">Update Akun Pegawai</h2>
                    <button type="button" @click="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form @submit.prevent=" statusmodal ? editAkun() : addAkun()" >
                <div class="modal-body" style="padding:30px">
                    <div class="alert alert-danger" style="display:none"></div>
                    
                        <div class="form-group">
                            <label style="font-weight:bold">Username</label>
                            <input v-model="form.name" type="name" class="form-control">
                        </div>
                        <div class="form-group" >
                            <label style="font-weight:bold">Email</label>
                            <input v-model="form.email" type="email" class="form-control">
                        </div>
                          <div class="form-group" >
                            <label style="font-weight:bold">Password</label>
                            <input v-model="form.password" type="password" class="form-control">
                        </div>

                        <div class="modal-footer end">
                        <button type="button" class="btn" style=" border-radius:6px; background-color:#E95A09;color:white;   width:100px " @click="closeModal()" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn" style=" border-radius:6px; background-color:#124EB2;color:white;  width:100px "  v-show="!statusmodal">Tambah</button>
                         <button type="submit" class="btn" style=" border-radius:6px; background-color:#124EB2;color:white;  width:100px " v-show="statusmodal">Ubah</button>
                     </div>
                       
                    
                </div>
                </form>
            </div>
        </div>
        
    </div>

    </div>
    </body>

</template>


<script>

export default {
    name: "AkunPegawai",
    data() {
        return {
            statusmodal: false,
            akunpegawai :[],
            form : new Form({
                id : "",
                name : "",
                email : "",
                password : "",
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/allUser',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.akunpegawai = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods:{
        showModal() {
            this.statusmodal = false;
            this.form.reset();
            $("#tambahAkun").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#tambahAkun").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#tambahAkun").modal("hide");
        },
       editAkun() {
           this.$axios.get('/sanctum/csrf-cookie').then(response => {
              this.form.post('/api/updateUser', + this.form.id).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Update Akun Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $("#tambahAkun").modal("hide");
                    this.allUser()
                }
            
            })
           })
        },
        closeEdit() {
            this.form.reset();
            $("#editAkun").modal("hide");
        },
        addAkun() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
              this.form.post('/api/addAkunPegawai').then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menambahkan Akun Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $('#tambahAkun').modal('hide')
                    this.allUser()
                }
            
            }
        )
            })
        },
        // editAkun(id) {
        //      $("#editAkun").modal("show");
        //       axios.post('/api/updateUser', +id).then((response) => {
        //         if (response.data.success){
        //             Swal.fire({
        //                 icon: "success",
        //                 title: "Berhasil",
        //                 text: "Berhasil Update Akun Pegawai",
        //                 showConfirmButton: false,
        //                 timer: 1600,
        //             })
        //             this.form.reset();
        //             $('#editAkun').modal('hide')
        //             this.allUser()
        //         }
            
        //     }
        // )},

        hapusAkun(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Akun Pegawai ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#124EB2',
            cancelButtonColor: '#E95A09',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            }).then((result) => {
                 if (result.isConfirmed) {
                 axios.delete('/api/hapusUser/'+id,  {
                headers: { Authorization: "Bearer " + this.token },
                },
                )
                  Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menghapus Akun Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    };
           
                    this.allUser()

            },

            )

            })
        },

        allUser() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/allUser',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.akunpegawai = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        }
    },

    mounted() {
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


