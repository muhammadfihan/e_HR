<template>

    <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Management Jabatan</h2>
                                        
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
				
								<!--begin::Row-->
								
                             
											<!--begin::Header-->
											<div class="card-header flex-wrap border-0 pt-6 pb-0">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label font-weight-bolder text-dark" >Managament Jabatan</span>
													<span class="text-muted mt-1 font-weight-bold font-size-sm" v-for="(data) in infopt" :key="data.id">Management Jabatan {{ data.nama_perusahaan }}</span>
												</h3>
                                                <div class="card-toolbar">
                                                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
														<!--begin::Trigger Modal-->
														<a href="#" class="btn btn-success font-weight-bolder font-size-sm" aria-haspopup="true" aria-expanded="false" data-toggle="modal" @click="showModal()">Tambah Jabatan</a>
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
														<div class="col-lg-12 col-xl-8">
															 <form>
															<div class="row align-items-center">
																<div class="col-md-4 my-2 my-md-0">
																	<div class="input-icon">
																		<input v-model="search" type="text" class="form-control form-control-solid" placeholder="Cari Jabatan"  />
																		<span>
																			<i class="flaticon2-search-1 text-muted"></i>
																		</span>
																	</div>
																</div>
																<div>
																	<div>
																	<a class="btn btn-light-primary px-6 font-weight-bold">Search</a>
																</div>
																</div>
															</div>
														  </form>
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
                                                            <th>Jabatan</th>
                                                            <th>Gaji</th>
                                                            <th style="text-align: center;">Action</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr v-for="(data,index) in jabatan.data" :key="data.id">
                                                                    <td>{{index+1}} </td>
                                                                    <td>{{ data.jabatan }}</td>
                                                                    <td>{{convertToRupiah (data.gaji) }}</td>
                                                                   
                                                                    <td style="text-align: center;">
                                                                          <a  class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 far fa-edit" data-toggle="modal" @click.prevent="showModalEdit(data)">
                                                                          </a>
                                                                          <a  class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 far fa-trash-alt" @click.prevent="hapusJabatan(data.id)">
                                                                          </a>
                                                                       
                                                                    </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                 <Pagination align="right" :data="jabatan" @pagination-change-page="allJabatan" />
												<!--end::Datatable-->
											</div>
											<!--end::Body-->
										</div>
                                         
                                        
                                </div>
                                
							</div>
                            
												<!--end::Datatable-->
											</div>
											<!--end::Body-->

                    <div class="modal fade" id="tambahJabatan" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
                                                                        <h5 class="modal-title" v-show="!statusmodal" id="tambahJabatan">Tambah Jabatan Pegawai</h5>
																		<h5 class="modal-title" v-show="statusmodal" id="tambahJabatan">Edit Jabatan Pegawai</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" class="ki ki-close" @click="closeModal()"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form @submit.prevent="statusmodal ? editJabatan() : addJabatan()">
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Jabatan</label>
																					<div class="col-lg-9 col-xl-6">
																						 <input v-model="form.jabatan" placeholder="Masukan Jabatan" type="text" class="form-control form-control-lg form-control-solid">
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Gaji</label>
																					<div class="col-lg-9 col-xl-6">
																						 <input v-model="form.gaji" placeholder="Masukan angka saja" type="text" class="form-control form-control-lg form-control-solid">
																					</div>
																				</div>
																			</form>
																		</div>
																	</div>
																	<div class="modal-footer">
																		
																		<button type="submit" v-show="!statusmodal"  @click="addJabatan()"  class="btn btn-primary font-weight-bold">Tambah</button>
                                                                        <button type="submit" v-show="statusmodal"   @click="editJabatan()"  class="btn btn-primary font-weight-bold">Update</button>
                                                                        <button type="button"  data-dismiss="modal" @click="closeModal()" class="btn btn-primary font-weight-bold">Batal</button>
																	</div>
																</div>
															</div>
														</div>


</template>


<script>
import LaravelVuePagination from 'laravel-vue-pagination';
export default {
     components: {
        'Pagination': LaravelVuePagination
    },
    name: "Jabatan",
    data() {
        return {
            jabatan:[],
            infopt:[],
            search: '',
            statusmodal: false,
            form : new Form({
                id : "",
                jabatan : "",
                gaji : "",
            }),
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    created() {
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
    methods:{
        searchjabatan(val) {
            if (val == "")
            {
                this.allJabatan()
            }else {
                axios
                    .get('/api/searchjabatan/'+ val , {
                        headers: {Authorization: "Bearer " + this.token},
                    })
                    .then((response) => {
                        this.jabatan = response.data;
                    });
            }
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
        showModal() {
            this.statusmodal = false;
            this.form.reset();
            $("#tambahJabatan").modal("show");
        },
        showModalEdit(data) {
            this.statusmodal = true;
            this.form.reset();
            $("#tambahJabatan").modal("show");
            this.form.fill(data);
        },
        closeModal() {
            this.form.reset();
            $("#tambahJabatan").modal("hide");
        },

        addJabatan() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.form.post('/api/tambahjabatan', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menambahkan Jabatan",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    this.form.reset();
                    $('#tambahJabatan').modal('hide')
                    this.allJabatan()
                }
                    
                    }
                )
                    })
        },
        editJabatan(){
        
              axios.post('/api/updatejabatan',
                {
                    id: this.form.id,
                    jabatan: this.form.jabatan,
                    gaji: this.form.gaji,
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
                    $("#tambahJabatan").modal("hide");
                    this.allJabatan()
                }
            

           })
        },

        hapusJabatan(id){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            Swal.fire({
            title: 'Hapus Jabatan ?',
            text: "Anda tidak akan bisa mengembalikannya lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1BC5BD',
            cancelButtonColor: '',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            }).then((result) => {
                 if (result.isConfirmed) {
                 axios.delete('/api/hapusjabatan/'+id,  {
                headers: { Authorization: "Bearer " + this.token },
                },
                )
                  Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menghapus Jabatan Pegawai",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                    };
           
                    this.allJabatan()

            },

            )

            })
        },

        allJabatan(page = 1){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/jabatanpaginate?page=' + page,{
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
    watch: {
                search: function ()
                {
                    this.searchjabatan(this.search)
                }
        },
    mounted() {
        this.getpt();
        this.allJabatan();
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


