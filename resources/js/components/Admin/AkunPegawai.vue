<template>
    <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Data Akun Pegawai</h2>
                                        
										<div class="d-flex align-items-center font-weight-bold my-2">
										</div>
									</div>
								</div>
							</div>
						</div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
					
						<!--end::Subheader-->
						<!--begin::Entry-->
					<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container mb-13">   
										<!--begin::Card-->
										<div class="card card-custom">
											<!--begin::Header-->
											<div class="card-header flex-wrap border-0 pt-6 pb-0">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label font-weight-bolder text-dark" >Akun Pegawai</span>
													<span class="text-muted mt-1 font-weight-bold font-size-sm" v-for="(data) in infopt" :key="data.id">Management Akun Pegawai {{ data.nama_perusahaan }}</span>
												</h3>
                                                <div class="card-toolbar">
													<div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
														<!--begin::Trigger Modal-->
														<a href="#" class="btn btn-success font-weight-bolder font-size-sm" aria-haspopup="true" aria-expanded="false" data-toggle="modal" @click="showModal()">Tambah Akun</a>
                                                    </div>
                                                </div>

												
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body">
												<!--begin::Search Form-->
												<!--begin::Search Form-->
												<div class="mb-10">
													<div class="row align-items-center">
														<div class="col-lg-9 col-xl-8">
															<div class="row align-items-center">
																<div class="col-md-4 my-2 my-md-0">
																	<div class="input-icon">
																		<input type="text" class="form-control form-control-solid" placeholder="Search..." id="kt_datatable_search_query" />
																		<span>
																			<i class="flaticon2-search-1 text-muted"></i>
																		</span>
																	</div>
																</div>
																<div class="col-md-4 my-2 my-md-0">
																	<select class="form-control form-control-solid" id="kt_datatable_search_status">
																		<option value="">Status</option>
																		<option value="1">Pending</option>
																		<option value="2">Delivered</option>
																		<option value="3">Canceled</option>
																	</select>
																</div>
																<div class="col-md-4 my-2 my-md-0">
																	<select class="form-control form-control-solid" id="kt_datatable_search_type">
																		<option value="">Type</option>
																		<option value="4">Success</option>
																		<option value="5">Info</option>
																		<option value="6">Danger</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
															<a href="#" class="btn btn-light-primary px-6 font-weight-bold">Search</a>
														</div>
													</div>
												</div>
												<!--end::Search Form-->
												<!--end: Search Form-->
												<!--begin::Datatable-->
												<div class="table-responsive">
													<table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                                                        <thead class="" >
                                                       <tr>
                                                            <th>No</th>
                                                            <th>Username</th>
                                                            <th>Email</th>
                                                            <th>Jabatan</th>
                                                            <th>Golongan</th>
                                                            <th>Status</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr v-for="(data, index) in akunpegawai" :key="data.name">
                                                                     <td>{{index+1}} </td>
                                                                    <td>{{ data.name }}</td>
                                                                    <td>{{ data.email }}</td>
                                                                    <td>
                                                                         <span v-for="jab in detjabatan" :key="jab.id">
                                                                            <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                         <span v-for="gol in golongan" :key="gol.id">
                                                                            <a v-if="data.id_golongan == gol.id">{{gol.golongan}}</a>
                                                                        </span>
                                                                    </td>
                                                                      <td>
                                                                        <span class="badge badge-success" v-if="data.status == 'Aktif'" >{{data.status}}</span>
                                                                        <span class="badge badge-danger" v-if="data.status == 'Tidak Aktif'" >{{data.status}}</span>
                                                                    </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
												<!--end::Datatable-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Teachers-->
							</div>
							<!--end::Container-->
						
                            <div class="modal fade" id="tambahAkun" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
                                                                        <h5 class="modal-title" v-show="!statusmodal" id="tambahAkun">Tambah Akun Pegawai</h5>
																		<h5 class="modal-title" v-show="statusmodal" id="tambahAKun">Edit Akun Pegawai</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" class="ki ki-close" @click="closeModal()"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form @submit.prevent="statusmodal ? editAkun() : addAkun()">
																				<div class="form-group row" :class="{ error: v$.form.name.$errors.length }">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Username</label>
																					<div class="col-lg-9 col-xl-6">
																						 <input placeholder="Masukan Username Pegawai" v-model="v$.form.name.$model" type="name" class="form-control form-control-lg form-control-solid">
                                                                                          <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                                                                                            <span class="error-msg" style="color:red">Harap Masukan Username Pegawai</span>
                                                                                        </div>
																					</div>
																				</div>
																				<div class="form-group row" :class="{ error: v$.form.email.$errors.length }">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Email</label>
																					<div class="col-lg-9 col-xl-6">
																						 <input placeholder="Masukan Email Pegawai" v-model="v$.form.email.$model" type="name" class="form-control form-control-lg form-control-solid">
                                                                                         <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                                                                                            <span class="error-msg" style="color:red">Harap Masukan Email</span>
                                                                                        </div>
																					</div>
																				</div>
                                                                                <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Jabatan</label>
																					<div class="col-lg-9 col-xl-6">
																						 <select class="form-control form-control-lg form-control-solid" v-model="form.id_jabatan">
                                                                                        <option v-for="data in detjabatan" :key="data.id"
                                                                                                        :selected="data.jabatan == form.id_jabatan ? selected : null"
                                                                                                        :value="data.id">
                                                                                                    {{data.jabatan}}
                                                                                        </option>
                                                                                    </select>
																					</div>
																				</div>
                                                                                 <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Golongan</label>
																					<div class="col-lg-9 col-xl-6">
																						<select class="form-control form-control-lg form-control-solid" v-model="form.id_golongan">

                                                                                            <option v-for="data in golongan" :key="data.id"
                                                                                                            :selected="data.golongan == form.id_golongan ? selected : null"
                                                                                                            :value="data.id">
                                                                                                        {{data.golongan}}
                                                                                            </option>
                                                                                        </select>
																					</div>
																				</div>
                                                                                <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Tanggal Masuk pegawai</label>
																					<div class="col-lg-9 col-xl-6">
																						 <input v-model="form.tanggal_masuk" placeholder="Tanggal Pegawai Masuk Perusahaan" type="date" class="form-control form-control-lg form-control-solid">
																					</div>
																				</div>
																			</form>
																		</div>
																	</div>
																	<div class="modal-footer">
																		
																		<button :disabled="v$.form.$invalid" type="submit" v-show="!statusmodal"  @click="addAkun()"  class="btn btn-primary font-weight-bold">Tambah</button>
                                                                        <button type="submit" v-show="statusmodal"   @click="editAkun()"  class="btn btn-primary font-weight-bold">Update</button>
                                                                        <button type="button"  data-dismiss="modal" @click="closeModal()" class="btn btn-primary font-weight-bold">Batal</button>
																	</div>
																</div>
															</div>
														</div>
</template>


<script>
import useVuelidate from '@vuelidate/core'
import { required, email, minLength } from '@vuelidate/validators'
export default {
    name: "AkunPegawai",
     setup () {
        return { v$: useVuelidate() }
    },
    
    data() {
        return {
            infopt:[],
            statusmodal: false,
            akunpegawai :[],
            detjabatan:[],
            golongan:[],
            form : new Form({
                id : "",
                name : "",
                id_jabatan : "",
                id_golongan : "",
                tanggal_masuk: "",
                email : "",
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    validations() {
        return {
        form: {
            name: {
            required, name
            },
            email: {
            required, email 
            },
        },
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
              axios.post('/api/updateUser', 
               {
                    id: this.form.id,
                    name: this.form.name,
                    id_jabatan: this.form.id_jabatan,
                    id_golongan: this.form.id_golongan,
                    email: this.form.email,
                    tanggal_masuk: this.form.tanggal_masuk
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
                    $("#tambahAkun").modal("hide");
                    this.allUser()
                }
            
            })
           
        },
        closeEdit() {
            this.form.reset();
            $("#editAkun").modal("hide");
        },
        addAkun() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
              this.form.post('/api/addAkunPegawai', {
                    headers: {Authorization: "Bearer " + this.token},
                }).then((response) => {
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
         allUser(){
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

        hapusAkun(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Akun Pegawai ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1BC5BD',
            cancelButtonColor: '',
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

    },

    mounted() {
        this.allJabatan();
        this.getpt();
        this.allgolongan();
        // axios.get('/api/allUser',{
        //         headers: {Authorization: "Bearer " + this.token},
        //     })
        //         .then(response => {
        //             this.akunpegawai = response.data.data;
        //         })
        //         .catch(function (error) {
        //             console.error(error);
        //         });
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


