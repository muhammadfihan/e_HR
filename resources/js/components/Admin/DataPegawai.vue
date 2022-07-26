<template>

    <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Data Pegawai</h2>
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
													<span class="card-label font-weight-bolder text-dark" >Informasi Pegawai</span>
													<span class="text-muted mt-1 font-weight-bold font-size-sm" v-for="(data) in infopt" :key="data.id">Daftar Pegawai Yang Bekerja di {{ data.nama_perusahaan }}</span>
												</h3>
												
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
                                                            <th>Akun Pegawai</th>
                                                            <th>Nama Pegawai</th>
                                                            <th>Jabatan</th>
                                                            <th>No Pegawai</th>
                                                            <th>Status</th>
                                                            <th>Total Jam Kerja</th>
                                                            <th>Gender</th>
                                                            <th style="text-align: center;">Action</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr v-for="(data,index) in pegawai" :key="data.id">
                                                                    <td>{{index+1}} </td>
                                                                    <td>
                                                                        <div class="ms-3">
                                                                            <p class="fw-bold mb-1">{{ data.name }}</p>
                                                                            <p class="text-muted mb-0">{{ data.email }}</p>
                                                                        </div>
                                                                    </td>
                                                                    <td><a>{{ data.nama_lengkap }}</a></td>
                                                                    <td>
                                                                         <span v-for="jab in jabatan" :key="jab.id">
                                                                            <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                                                                        </span>
                                                                    </td>
                                                                    <td><a>{{ data.no_pegawai }}</a></td>
                                                                    <td>
                                                                        <span class="badge badge-success" v-if="data.status == 'Aktif'" >{{data.status}}</span>
                                                                        <span class="badge badge-danger" v-else-if="data.status == 'Tidak Aktif'" >{{data.status}}</span>
                                                                    </td>
                                                                    <td><a>{{ format(data.jam_kerja)}}</a></td>
                                                                    <td>{{ data.gender }}</td>
                                                                    <td style="text-align: center;">
                                                                          <a  class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 flaticon2-document" data-toggle="modal" data-target="#detailmodal" @click.prevent="detailPegawai(data.id)">
                                                                          </a>
                                                                          <a  class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 far fa-edit" data-toggle="modal" @click.prevent="editModal(data)">
                                                                          </a>
                                                                          <a  class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 far fa-trash-alt" @click.prevent="hapusPegawai(data.id)">
                                                                          </a>
                                                                       
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

                    <div class="modal fade" id="detailmodal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="detailmodal">Detail Data Pegawai</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" class="ki ki-close"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form class="form pt-9" v-for="(data) in detpegawai" :key="data.id">
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Username</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="form-control form-control-lg form-control-solid" type="text">{{data.name}}</div>
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Email</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="form-control form-control-lg form-control-solid" type="text">{{data.email}}</div>
																					</div>
																				</div>
																				<div class="separator separator-dashed my-10"></div>
                                                                                <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Nama Lengkap</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="form-control form-control-lg form-control-solid" type="text">{{data.nama_lengkap}}</div>
																					</div>
																				</div>
                                                                                <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">No Pegawai</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="form-control form-control-lg form-control-solid" type="text">{{data.no_pegawai}}</div>
																					</div>
																				</div>
                                                                                 <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Golongan</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="form-control form-control-lg form-control-solid" type="text">
                                                                                            <span v-for="gol in golongan" :key="gol.id">
                                                                            <a v-if="data.id_golongan == gol.id">{{gol.golongan}}</a>
                                                                        </span>
                                                                                        </div>
																					</div>
																				</div>
                                                                                 <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Pendidikan</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="form-control form-control-lg form-control-solid" type="text">{{data.pendidikan}}</div>
																					</div>
																				</div>
                                                                                <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Jabatan</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="form-control form-control-lg form-control-solid" type="text"><span v-for="jab in jabatan" :key="jab.id">
                                                                            <a v-if="data.id_jabatan == jab.id">{{jab.jabatan}}</a>
                                                                        </span></div>
																					</div>
																				</div>
                                                                                <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">No KTP</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="form-control form-control-lg form-control-solid" type="text">{{data.no_ktp}}</div>
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">No Hp</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="input-group input-group-lg input-group-solid">
																							<div class="input-group-prepend">
																								<span class="input-group-text">
																									<i class="la la-phone"></i>
																								</span>
																							</div>
																							<div class="form-control form-control-lg form-control-solid" type="text">{{data.no_hp}}</div>
																						</div>
																					</div>
																				</div>
                                                                                <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Gender</label>
																					<div class="col-lg-9 col-xl-6">
																						<div class="form-control form-control-lg form-control-solid" type="text">{{data.gender}}</div>
																					</div>
																				</div>
                                                                                <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Status</label>
																					<div class="col-lg-9 col-xl-6">
                                                                                        <div class="form-control form-control-lg form-control-solid" type="text"><span class="badge badge-success" v-if="data.status == 'Aktif'" >{{data.status}}</span>
                                                                                        <span class="badge badge-danger" v-else-if="data.status == 'Tidak Aktif'" >{{data.status}}</span></div>
																						
																					</div>
																				</div>
                                                                                <div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Alamat</label>
																					<div class="col-lg-9 col-xl-6">
																						<textarea disabled class="form-control form-control-lg form-control-solid" type="text" style="background-color:#F3F6F9" v-model="data.alamat"></textarea>
																					</div>
																				</div>

																			</form>
																		</div>
																	</div>
																	<div class="modal-footer">
																		
																		<button type="button"  data-dismiss="modal" class="btn btn-primary font-weight-bold">Tutup</button>
																	</div>
																</div>
															</div>
														</div>
                            <div class="modal fade" id="editPegawai" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="editPegawai">Edit Data Pegawai</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" class="ki ki-close" @click="closeModal()"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form @submit.prevent="updatePegawai()">
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Jabatan</label>
																					<div class="col-lg-9 col-xl-6">
																						<select class="form-control form-control-lg form-control-solid" v-model="form.id_jabatan">
                                                                                        <option disabled selected>Ubah Jabatan</option>
                                                                                        <option v-for="data in jabatan" :key="data.id"
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
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Status</label>
																					<div class="col-lg-9 col-xl-6">
																						 <select class="form-control form-control-lg form-control-solid" v-model="form.status">
                                                                                            <option >Aktif</option>
                                                                                            <option >Tidak Aktif</option>
                                                                                        </select>
																					</div>
																				</div>
																			</form>
																		</div>
																	</div>
																	<div class="modal-footer">
																		
																		<button type="submit" @click="updatePegawai()"  class="btn btn-primary font-weight-bold">Update</button>
                                                                        <button type="button"  data-dismiss="modal" @click="closeModal()" class="btn btn-primary font-weight-bold">Batal</button>
																	</div>
																</div>
															</div>
														</div>


</template>


<script>

export default {
    name: "DataPegawai",
    data() {
        return {
            pegawai: [],
            detpegawai: [],
            jabatan:[],
            golongan:[],
            editpegawai:[],
            updatepegawai :[],
            delpegawai:[],
            infopt:[],
            form: new Form ({
                id : "",
                name : "",
                id_golongan : "",
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
       format(time){
		if (time != null){
			return time.replace(/(?:0)?(\d+):(?:0)?(\d+).*/,'$1 Jam');
		}
        
		},
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
                id_golongan: data.id_golongan,
                status: data.status,
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
                    id_golongan:this.form.id_golongan,
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
                     $("#editPegawai").modal("hide");
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
             confirmButtonColor: '#1BC5BD',
            cancelButtonColor: '',
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
        this.getpt();
        this.allgolongan();
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


