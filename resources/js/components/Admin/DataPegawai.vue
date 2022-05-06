<template>
    <body>

    <div class="container-md" >

        <div class="main">
            <div class="row" style=" margin-bottom:6px; margin-left:-2px; font-style: normal; font-size:30px; line-height: 47px;color: #E95A09;">
                <p>Data Pegawai</p>
                <button class="btn print" style="margin-left:933px; color:white">Print</button>
                <button class="btn download" style="margin-left:10px; color:white" >Download</button>
            </div>
            <table class="table align-middle border" >
                <thead class="" >
                <tr>
                    <th>&nbsp;</th>
                    <th>No</th>
                    <th>Pegawai</th>
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
                        <td>{{ data.jabatan }}</td>
                        <td>{{ data.no_pegawai }}</td>
                        <td>
                            <span class="badge badge-success rounded-pill">{{data.status}}</span>
                        </td>
                        <td>{{ data.gender }}</td>
                        <td style="text-align: center;">
                             <button type="button" class="btn btn-link btn-sm btn-rounded" data-toggle="modal" data-target=".bd-example-modal-lg" @click.prevent="detailPegawai(data.id)">
                                    Detail
                            </button>
                             <button type="button" class="btn btn-link btn-sm btn-rounded" >
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

       <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="detailPegawaiLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div style="padding:35px">
                    <h2 style="color:#E95A09" >Detail Data Pegawai</h2>
                    <table class="table align-left border" style="table-layout:fixed">
                    <thead class="" v-for="(data) in detpegawai" :key="data.id" >
                        <tr>
                            <td style="font-weight:bold">Pegawai</td>
                            <td>{{ data.name }}</td> 
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Jabatan</td>
                            <td>{{ data.jabatan }}</td> 
                        </tr>
                        <tr>
                            <td style="font-weight:bold">No Pegawai</td>
                            <td>{{ data.no_pegawai }}</td> 
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Email</td>
                            <td>{{ data.email }}</td> 
                        </tr>
                        <tr >
                            <td style="font-weight:bold">No KTP</td>
                            <td>{{ data.no_ktp }}</td> 
                        </tr>
                        <tr>
                            <td style="font-weight:bold">No HP</td>
                            <td>{{ data.no_hp }}</td> 
                        </tr>
                        <tr >
                            <td style="font-weight:bold">Alamat</td>
                            <td>{{ data.alamat }}</td> 
                        </tr>
                        <tr >
                            <td style="font-weight:bold">Gender</td>
                            <td>{{ data.gender }}</td> 
                        </tr>
                        <tr >
                            <td style="font-weight:bold">Status</td>
                            <td><span class="badge badge-success rounded-pill">{{data.status}}</span></td> 
                        </tr>
                    </thead>
                    
                    </table>
                    <div style="text-align:right;">
                     <button type="button" class="btn" style=" border-radius:6px; background-color:#124EB2;color:white;width:100px " data-dismiss="modal">Close</button>   
                    </div> 
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
            delpegawai:[],
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    created() {
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
    methods:{
        // detailPegawaid(id){
        //     $('#detailPegawai').modal('show')
        //     this.$axios.get('/sanctum/csrf-cookie').then(response => {
        //     this.$axios.get('/api/detailpegawai'+id,{
        //         headers: {Authorization: "Bearer " + this.token},
        //     })
        //         .then(response => {
        //             this.pegawai = response.data.data;
        //         })
        //         .catch(function (error) {
        //             console.error(error);
        //         });
        //      })
        // },
        detailPegawai(id){
            $('#detailPegawai').modal('show')
            axios.get('/api/detailpegawai/'+id,  {
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detpegawai = response.data.data
                console.log(this.detpegawai)
            })
        },
        // hapusPegawai(id){
        //     this.showAlertConfirm(),
        //     axios.delete('/api/hapusPegawai/'+id,  {
        //         headers: { Authorization: "Bearer " + this.token }
        //     }).then((response) => {
        //         this.delpegawai = response.data.data
        //         console.log(this.delpegawai)
        //     })
        // },
        hapusPegawai(id){
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
                 axios.delete('/api/hapusPegawai/'+id,  {
                headers: { Authorization: "Bearer " + this.token }
                
            }, location.reload())
                }
               
            },

            )
            
             
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


