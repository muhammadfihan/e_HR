<template>
   

    <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Riwayat Kehadiran</h2>
                                        
										<div class="d-flex align-items-center font-weight-bold my-2">
										</div>
									</div>
								</div>
							</div>
						</div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
					
						<!--end::Subheader-->
		<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container mb-13">   
										<!--begin::Card-->
										<div class="card card-custom">
											<!--begin::Header-->
											<div class="card-header flex-wrap border-0 pt-6 pb-0">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label font-weight-bolder text-dark" >Riwayat Presensi</span>
													<span class="text-muted mt-1 font-weight-bold font-size-sm" v-for="(data) in infopt" :key="data.id">Riwayat Presensi anda di {{ data.nama_perusahaan }}</span>
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
                                                            <th>&nbsp;</th>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Jam Masuk</th>
                                                            <th>Jam Pulang</th>
                                                            <th>Jam Kerja</th>
                                                            <th>Keterangan</th> 
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr v-for="(data,index) in absensipegawai" :key="data.id">
                                                                    <td>
                                                                        <label class="checkbox-wrap checkbox-success">
                                                                            <input type="checkbox">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                    <td>{{index+1}} </td>
                                                                     <td>{{ data.tanggal }}</td>
                                                                    <td>
                                                                         <span class="badge badge-primary" >{{data.jam_masuk}}</span>
                                                                    </td>
                                                                    <td>
                                                                         <span class="badge badge-success" v-if="data.jam_pulang == null" >Bekerja</span>
                                                                        <span class="badge badge-primary" v-else-if="data.jam_pulang != null" >{{data.jam_pulang}}</span>
                                                                    </td>
                                                                    <td>{{ data.jam_kerja }}(Jam)</td>
                                                                     <td>
                                                                        <span class="badge badge-success" v-if="data.keterangan == 'On Time'" >{{data.keterangan}}</span>
                                                                        <span class="badge badge-danger" v-else-if="data.keterangan == 'Terlambat'" >{{data.keterangan}}</span>
																			 <span class="badge badge-primary" v-else-if="data.keterangan == 'Request Attendance'" >{{data.keterangan}}</span>
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
<div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="approve">D</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" class="ki ki-close"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div >
																			<form class="form pt-9" v-for="(data) in detabsen" :key="data.id">
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Foto Selfie Masuk</label>
																					<div class="col-lg-9 col-xl-6">
																						<!-- <div class="form-control form-control-lg form-control-solid" type="text"></div> -->
                                                                                        <img :src="`upload/${data.selfie_masuk}`" lass="form-control form-control-lg form-control-solid" style="height:100px; width:100px;">
																					</div>
																				</div>
																				<div class="form-group row">
																					<label class="col-xl-3 col-lg-3 text-right col-form-label">Foto Selfie Pulang</label>
																					<div class="col-lg-9 col-xl-6">
																						<!-- <div class="form-control form-control-lg form-control-solid" type="text"></div> -->
                                                                                        <img :src="`upload/${data.selfie_pulang}`" lass="form-control form-control-lg form-control-solid" style="height:100px; width:100px;">
																					</div>
																				</div>
																				
																			</form>
																		</div>
																	</div>
																	<div class="modal-footer">
																		
																		<button type="button"  data-dismiss="modal" class="btn btn-primary font-weight-bold" @click="close()">Tutup</button>
																	</div>
																</div>
															</div>
														</div>
</template>


<script>

export default {
    name: "Kehadiran",
    data() {
        return {
            infopt:[],
            detabsen:[],
            absensipegawai : [],
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },

     created() {
         this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilpegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.absensipegawai = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods:{
          close(){
             $('#detailmodal').modal('hide')
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
    },
    mounted(){
        this.getpt();
    }
    


}


</script>


