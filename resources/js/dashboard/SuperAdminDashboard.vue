<template>
    <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Data Akun User</h2>
                                        
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
							<div class="container">
								<!--begin::Teachers-->
								<div class="d-flex flex-row">
									<!--begin::Aside-->
									<!--end::Aside-->
									<!--begin::Content-->
									<div class="flex-row-fluid ml-lg-8">
										<!--begin::Card-->
										<div class="card card-custom">
											<!--begin::Header-->
											<div class="card-header flex-wrap border-0 pt-6 pb-0">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label font-weight-bolder text-dark" >Akun User</span>
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
												<div class="datatable-bordered">
                                                     <table class="table align-middle bordered" >
                                                        <thead class="" >
                                                       <tr>
                                                            <th>&nbsp;</th>
                                                            <th>No</th>
                                                            <th>Perusahaan</th>
                                                            <th>Email</th>
                                                            <th>Jumlah Karyawan</th>
                                                            <th>No NPWP</th>
                                                            <th>Alamat Perusahaan</th>
                                                            <th style="text-align: center;">Action</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr v-for="(data,index) in superadmin" :key="data.id">
                                                                    <td>
                                                                        <label class="checkbox-wrap checkbox-success">
                                                                            <input type="checkbox">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                    <td>{{index+1}} </td>
                                                                    <td>{{ data.nama_perusahaan }}</td>
                                                                    <td>{{ data.email_perusahaan }}</td>
                                                                    <td>{{ data.jumlah_karyawan }}</td>
                                                                    <td>{{ data.npwp }}</td>
                                                                    <td>{{ data.det_alamat }}</td>
                                                                    <td>
                                                                        <a  class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 far fa-trash-alt" @click.prevent="hapusAkun(data.id)">
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
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
</template>


<script>

export default {
    name: "SuperAdminDashboard",
    data() {
        return {
            superadmin :[],
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    created() {
         this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilsuperadmin',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.superadmin = response.data.data;
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


    },

    mounted() {
    },



}


</script>


