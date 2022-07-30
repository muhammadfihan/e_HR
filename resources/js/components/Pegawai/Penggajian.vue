<template>
   <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<div class="d-flex align-items-center flex-wrap mr-1">
									<div class="d-flex flex-column">
										<h2 class="text-white font-weight-bold my-2 mr-5">Penggajian</h2>
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
													<span class="card-label font-weight-bolder text-dark" >Pengambilan Gaji</span>
													<span class="text-muted mt-1 font-weight-bold font-size-sm" v-for="(data) in infopt" :key="data.id">Data Pengambilan Gaji di {{ data.nama_perusahaan }}</span>
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
                                                            <th>Periode/Tanggal</th>
                                                            <th>Jabatan</th>
                                                            <th>Total Gaji</th>
															<th style="text-align: center;">Detail Gaji</th>
                                                            <th style="text-align: center;">Action</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr v-for="(data,index) in gajipeg" :key="data.id">
                                                                    <td>{{index+1}} </td>
                                                                    <td>{{ data.tanggal }}</td>
                                                                    <td>
																		  <span v-for="jab in data.jabat" :key="jab.id">
                                                                            <a>{{jab}}</a>
                                                                        </span>
																	</td>
																	 <td>
																		  <span v-for="has in data.akhir" :key="has.id">
                                                                            <a>{{convertToRupiah(has)}}</a>
                                                                        </span>
																	</td>
                                                                     <td style="text-align: center;">
                                                                         <span @click.prevent="detGaji(data.id)" class="badge badge-primary" style="cursor:pointer" >Detail</span>
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                         <span v-if="data.status == 'Belum Diambil'" @click.prevent="modalconfirm(data)" class="badge badge-warning" style="cursor:pointer; color:white" >Ambil</span>
																		  <span v-else-if="data.status == 'Sudah Diambil'" @click.prevent="showinvoice(data.id)" class="badge badge-success" style="cursor:pointer" >Cetak</span>
                                                                    </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
												<!--end::Datatable-->
											</div>
											<!--end::Body-->
										</div>
                                        
                                </div>
                                
							</div>
                            
												<!--end::Datatable-->
											</div>
											<!--end::Body-->

							<div id="printThis">
								<div class="modal fade" id="invoicegaji" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
																<div class="modal-content">
																	<div class="modal-header">
                                                                        <h5 class="modal-title" id="invoicegaji">Invoice</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" class="ki ki-close" @click="closeinvoice()"></i>
																		</button>
																	</div>
																	<div class="modal-body" >
																	<div class="card-body p-0">
										<!-- begin: Invoice-->
										<!-- begin: Invoice header-->
										<div class="row justify-content-center py-8 px-8">
											<div class="col-md-9">
												<div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
													<h1 class="display-4 font-weight-boldest mb-10">SLIP GAJI</h1>
													<div class="d-flex flex-column align-items-md-end px-0" v-for="(data) in infopt" :key="data.id">
														<!--begin::Logo-->
														<h3 style="font-weight:bolder" href="#" class="mb-5" >
															{{data.nama_perusahaan}}
														</h3>
														<!--end::Logo-->
														<span class="text-right">
															<span>{{data.det_alamat}}</span>
														</span>
													</div>
												</div>
												<div class="border-bottom w-100"></div>
												<div class="d-flex justify-content-between pt-6" v-for="(data) in pegawais" :key="data.id">
													<div class="d-flex flex-column flex-root">
														<span class="font-weight-bolder mb-2">PEGAWAI</span>
														<span class="opacity-70">{{data.nama_lengkap}}</span>
													</div>
													<div class="d-flex flex-column flex-root"  v-for="(data) in invgaji" :key="data.id">
														<span class="font-weight-bolder mb-2">PERIODE GAJI</span>
														<span class="opacity-70">{{data.tanggal}}</span>
													</div>
													<div class="d-flex flex-column flex-root">
														<span class="font-weight-bolder mb-2 text-right">ALAMAT PEGAWAI</span>
														<span class="opacity-70 text-right">{{data.alamat}}</span>
													</div>
												</div>
											</div>
										</div>
										<!-- end: Invoice header-->
										<!-- begin: Invoice body-->
										<div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
											<div class="col-md-9">
												<div class="table-responsive">
													<table class="table table-bordered"  v-for="(data) in invgaji" :key="data.id">
                                                        <thead class="" >
                                                        
                                                        <tr>
                                                            <th>Jenis</th>
                                                            <th class="text-right">Nominal</th>
                                                        </tr>
                                                        </thead>
                                                        <tr>
                                                            <td>Gaji Pokok</td>
                                                             <td class="text-right" v-for="jabgaji in data.totjab" :key="jabgaji.id">{{convertToRupiah(jabgaji)}}</td>
                                                        </tr>
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
                                                       
                                                        <thead class="" >
                                                        <tr>
                                                            <th>Sub Total</th>
                                                             <th class="text-right" v-for="sub in data.subsub" :key="sub.id">{{convertToRupiah(sub)}}</th>
                                                        </tr>
                                                        </thead>
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
                                                            
                                                        
                                                         <thead class="" >
                                                        <tr>
                                                            <th>Total Potongan</th>
                                                            <th class="text-right">
                                                                     <span v-for="totapot in data.totpot" :key="totapot.id">
                                                                            <a>(-) {{convertToRupiah(totapot)}}</a>
                                                                        </span>
                                                            </th> 
                                                        </tr>
                                                        </thead>
                                                         <thead class="" >
                                                        <tr>
                                                            <th>Penerima Bersih</th>
                                                            <th class="text-right" v-for="totagaj in data.totalgaji" :key="totagaj.id">
                                                                <a>{{convertToRupiah(totagaj)}}</a>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                        </tbody>
                                                    
                                                        <!-- <thead class="">
                                                        <tr>
                                                            <th>Tunjangan</th>
                                                            <th>Nominal</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr>
                                                                <td>
                                                                     <span v-for="tundet in data.dettun" :key="tundet.id">
                                                                            <li style="list-style:none;">{{tundet}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="nomtun in data.nomdettun" :key="nomtun.id">
                                                                            <li style="list-style:none">{{convertToRupiah(nomtun)}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="totun in data.totun" :key="totun.id">
                                                                            <a>{{convertToRupiah(totun)}}</a>
                                                                        </span>
                                                                </td> 
                                                            </tr>
                                                        </tbody>
                                                        <thead class="">
                                                        <tr>
                                                            <th>Bonus</th>
                                                            <th>Nominal</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                             <tr>
                                                                <td>
                                                                     <span v-for="bondet in data.detbon" :key="bondet.id">
                                                                            <li style="list-style:none;">{{bondet}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="nomibon in data.nombon" :key="nomibon.id">
                                                                            <li style="list-style:none">{{convertToRupiah(nomibon)}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="totabon in data.totbon" :key="totabon.id">
                                                                            <a>{{convertToRupiah(totabon)}}</a>
                                                                        </span>
                                                                </td> 
                                                            </tr>
                                                        </tbody>
                                                       
                                                        <thead class="">
                                                         <tr>
                                                            <th></th>
                                                            <th>Gaji Pokok</th>
                                                             <th v-for="jabgaji in data.totjab" :key="jabgaji.id">{{convertToRupiah(jabgaji)}}</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th>Total Gaji</th>
                                                            <th v-for="totagaj in data.totalgaji" :key="totagaj.id">
                                                                <a>{{convertToRupiah(totagaj)}}</a>
                                                            </th>
                                                        </tr>
                                                        <tr>

                                                        </tr>
                                                       
                                                        </thead>
                                                          <thead class="">
                                                        <tr>
                                                            <th>Potongan</th>
                                                            <th>Nominal</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                             <tr>
                                                                <td>
                                                                     <span v-for="potdet in data.detpot" :key="potdet.id">
                                                                            <li style="list-style:none;">{{potdet}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="nomipot in data.nompot" :key="nomipot.id">
                                                                            <li style="list-style:none">{{convertToRupiah(nomipot)}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="totapot in data.totpot" :key="totapot.id">
                                                                            <a>{{convertToRupiah(totapot)}}</a>
                                                                        </span>
                                                                </td> 
                                                            </tr>
                                                        </tbody> -->
                                                    </table>
												</div>
											</div>
										</div>
										<!-- end: Invoice body-->
										<!-- begin: Invoice footer-->
										<div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
											<div class="col-md-9">
												<div class="table-responsive">
													<table class="table" v-for="(data) in invgaji" :key="data.id">
														<thead>
															<tr>
																<th class="font-weight-bold text-muted text-uppercase"></th>
																<th class="font-weight-bold text-muted text-uppercase"></th>
																<th class="font-weight-bold text-muted text-uppercase"></th>
																<th class="font-weight-bold text-muted text-uppercase text-right">TOTAL GAJI</th>
															</tr>
														</thead>
														<tbody>
															<tr class="font-weight-bolder" >
																<td></td>
																<td></td>
																<td></td>
																<td class="text-danger font-size-h3 font-weight-boldest text-right" v-for="totagaj in data.totalgaji" :key="totagaj.id">{{convertToRupiah(totagaj)}}</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!-- end: Invoice footer-->
										<!-- begin: Invoice action-->
										<div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
											<div class="col-md-9">
												<div class="d-flex justify-content-between">
													<button type="button" id="btnPrint" class="btn btn-light-primary font-weight-bold">Cetak Slip Gaji</button>
												</div>
											</div>
										</div>
										<!-- end: Invoice action-->
										<!-- end: Invoice-->
									</div>
																	</div>
																	<div class="modal-footer">
                                                                        <button type="button"  data-dismiss="modal" @click="closeinvoice()" class="btn btn-primary font-weight-bold">Tutup</button>
																	</div>
																</div>
															</div>
														</div>       				
							</div>
			
<div class="modal fade" id="detailgajipegawai" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
																<div class="modal-content">
																	<div class="modal-header">
                                                                        <h5 class="modal-title" id="detailgajipegawai">Detail Gaji Pegawai</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" class="ki ki-close" @click="closeDetGaji()"></i>
																		</button>
																	</div>
																	<div class="modal-body">
                                                                        <h5 class="modal-title" id="detailgajipegawai" v-for="(data) in detailgajipeg" :key="data.id">Detail Penggajian <a style="font-weight:bolder">{{data.email}}</a></h5>
                                                                        <br>
																		<div class="table-responsive">
													<table class="table table-bordered"  v-for="(data) in detailgajipeg" :key="data.id">
                                                        <thead class="" >
                                                        
                                                        <tr>
                                                            <th>Jenis</th>
                                                            <th class="text-right">Nominal</th>
                                                        </tr>
                                                        </thead>
                                                        <tr>
                                                            <td>Gaji Pokok</td>
                                                             <td class="text-right" v-for="jabgaji in data.totjab" :key="jabgaji.id">{{convertToRupiah(jabgaji)}}</td>
                                                        </tr>
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
                                                       
                                                        <thead class="" >
                                                        <tr>
                                                            <th>Sub Total</th>
                                                             <th class="text-right" v-for="sub in data.subsub" :key="sub.id">{{convertToRupiah(sub)}}</th>
                                                        </tr>
                                                        </thead>
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
                                                            
                                                        
                                                         <thead class="" >
                                                        <tr>
                                                            <th>Total Potongan</th>
                                                            <th class="text-right">
                                                                     <span v-for="totapot in data.totpot" :key="totapot.id">
                                                                            <a>(-) {{convertToRupiah(totapot)}}</a>
                                                                        </span>
                                                            </th> 
                                                        </tr>
                                                        </thead>
                                                         <thead class="" >
                                                        <tr>
                                                            <th>Penerima Bersih</th>
                                                            <th class="text-right" v-for="totagaj in data.totalgaji" :key="totagaj.id">
                                                                <a>{{convertToRupiah(totagaj)}}</a>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                        </tbody>
                                                    
                                                        <!-- <thead class="">
                                                        <tr>
                                                            <th>Tunjangan</th>
                                                            <th>Nominal</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                            <tr>
                                                                <td>
                                                                     <span v-for="tundet in data.dettun" :key="tundet.id">
                                                                            <li style="list-style:none;">{{tundet}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="nomtun in data.nomdettun" :key="nomtun.id">
                                                                            <li style="list-style:none">{{convertToRupiah(nomtun)}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="totun in data.totun" :key="totun.id">
                                                                            <a>{{convertToRupiah(totun)}}</a>
                                                                        </span>
                                                                </td> 
                                                            </tr>
                                                        </tbody>
                                                        <thead class="">
                                                        <tr>
                                                            <th>Bonus</th>
                                                            <th>Nominal</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                             <tr>
                                                                <td>
                                                                     <span v-for="bondet in data.detbon" :key="bondet.id">
                                                                            <li style="list-style:none;">{{bondet}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="nomibon in data.nombon" :key="nomibon.id">
                                                                            <li style="list-style:none">{{convertToRupiah(nomibon)}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="totabon in data.totbon" :key="totabon.id">
                                                                            <a>{{convertToRupiah(totabon)}}</a>
                                                                        </span>
                                                                </td> 
                                                            </tr>
                                                        </tbody>
                                                       
                                                        <thead class="">
                                                         <tr>
                                                            <th></th>
                                                            <th>Gaji Pokok</th>
                                                             <th v-for="jabgaji in data.totjab" :key="jabgaji.id">{{convertToRupiah(jabgaji)}}</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th>Total Gaji</th>
                                                            <th v-for="totagaj in data.totalgaji" :key="totagaj.id">
                                                                <a>{{convertToRupiah(totagaj)}}</a>
                                                            </th>
                                                        </tr>
                                                        <tr>

                                                        </tr>
                                                       
                                                        </thead>
                                                          <thead class="">
                                                        <tr>
                                                            <th>Potongan</th>
                                                            <th>Nominal</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        </thead>
                                                         <tbody>
                                                             <tr>
                                                                <td>
                                                                     <span v-for="potdet in data.detpot" :key="potdet.id">
                                                                            <li style="list-style:none;">{{potdet}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="nomipot in data.nompot" :key="nomipot.id">
                                                                            <li style="list-style:none">{{convertToRupiah(nomipot)}}</li>
                                                                        </span>
                                                                </td> 
                                                                <td>
                                                                     <span v-for="totapot in data.totpot" :key="totapot.id">
                                                                            <a>{{convertToRupiah(totapot)}}</a>
                                                                        </span>
                                                                </td> 
                                                            </tr>
                                                        </tbody> -->
                                                    </table>

                                                </div>
																	</div>
																	<div class="modal-footer">
                                                                        <button type="button"  data-dismiss="modal" @click="closeDetGaji()" class="btn btn-primary font-weight-bold">Tutup</button>
																	</div>
																</div>
															</div>
														</div>   
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
															<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
																<div class="modal-content text-center">
																	<div class="modal-header">
																		<h5 class="modal-title" id="editPegawai">Ambil Gaji</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<i aria-hidden="true" class="ki ki-close" @click="closeconfirm()"></i>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div style="padding:22px" >
																			<h3>Apakah Anda Ingin Ambil Gaji Sekarang ?</h3> 
																			<span style="color:red">Pastikan Detail Gaji Sudah Sesuai !</span>
																		</div>
																	</div>
																	<div class="modal-footer">
																		
																		<button type="submit" @click="ambil()"  class="btn btn-primary font-weight-bold">Ambil Sekarang</button>
                                                                        <button type="button"  data-dismiss="modal" @click="closeconfirm()" class="btn btn-danger font-weight-bold">Nanti</button>
																	</div>
																</div>
															</div>
														</div>    							


</template>


<script>

export default {
    name: "Penggajian",
    data() {
        return {
			form: new Form ({
				id: "",
                status : ""
            }),
            subsub: [],
			jabat: [],
			invgaji: [],
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
			gajipeg: [],
			detailgajipeg: [],
			infopt: [],
			jabatan: [],
			akunpegawai: [],
			pegawais: [],
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
	methods: {
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
		 getprofile(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/getprofile',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.pegawais = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
		closeconfirm() {
            this.form.reset();
            $("#confirm").modal("hide");
        },
        modalconfirm(data) {
            // this.form.reset()
            $("#confirm").modal("show")
            this.form.fill({
                id: data.id,
                status: data.status,
            })
        },
        getakun(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/getakun',{
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
        getJabatan(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/jabatanpegawai',{
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
		ambil(){
			  axios.post('/api/ambilgaji',
                {
                    id: this.form.id,
                    status: "Sudah Diambil"
                },
                {
                    headers: { Authorization: "Bearer " + this.token }
                }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Gaji Berhasil Diambil !",
                        showConfirmButton: false,
                        timer: 2000,
                    }),
					$("#confirm").modal("hide");
                    this.getgaji();
                }
            })
            	
        },
		getpt(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/infoptpeg',{
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
		getgaji(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/gajipegawai',{
                headers: {Authorization: "Bearer " + this.token},
            })
                .then(response => {
                    this.gajipeg = response.data.data;
					this.nilai = response.data.tunjangan;
                    this.bon = response.data.bonus;
                    this.potong = response.data.potongan;
                    this.akhir = response.data.hasil;
					this.jabat = response.data.jabatan;

                    for (let i = 0; i < this.nilai.length; i++) {
                        Object.assign(this.gajipeg[i], { nilai: this.nilai[i] })
                    }
                    for (let i = 0; i < this.bon.length; i++) {
                        Object.assign(this.gajipeg[i], { bon: this.bon[i] })
                    }
                    for (let i = 0; i < this.potong.length; i++) {
                        Object.assign(this.gajipeg[i], { potong: this.potong[i] })
                    }
                    for (let i = 0; i < this.akhir.length; i++) {
                        Object.assign(this.gajipeg[i], { akhir: this.akhir[i] })
                    }
					for (let i = 0; i < this.jabat.length; i++) {
                        Object.assign(this.gajipeg[i], { jabat: this.jabat[i] })
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
        },
		closeDetGaji(){
            $("#detailgajipegawai").modal("hide");
		},
		showinvoice(id){
            $("#invoicegaji").modal("show");
			axios.get('/api/detgajipeg/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.invgaji = response.data.data
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

                this.subsub = response.data.subtotal;
                //TUNJANGAN
                for (let i = 0; i < this.dettun.length; i++) {
                        Object.assign(this.invgaji[i], { dettun: this.dettun[i] })
                    }
                for (let i = 0; i < this.nomdettun.length; i++) {
                        Object.assign(this.invgaji[i], { nomdettun: this.nomdettun[i] })
                    }
                for (let i = 0; i < this.totun.length; i++) {
                        Object.assign(this.invgaji[i], { totun: this.totun[i] })
                    }    
                //BONUS
                for (let i = 0; i < this.detbon.length; i++) {
                        Object.assign(this.invgaji[i], { detbon: this.detbon[i] })
                    }
                for (let i = 0; i < this.nombon.length; i++) {
                        Object.assign(this.invgaji[i], { nombon: this.nombon[i] })
                    }
                for (let i = 0; i < this.totbon.length; i++) {
                        Object.assign(this.invgaji[i], { totbon: this.totbon[i] })
                    }    
                //POTONGAN
                for (let i = 0; i < this.detpot.length; i++) {
                        Object.assign(this.invgaji[i], { detpot: this.detpot[i] })
                    }
                for (let i = 0; i < this.nompot.length; i++) {
                        Object.assign(this.invgaji[i], { nompot: this.nompot[i] })
                    }
                for (let i = 0; i < this.totpot.length; i++) {
                        Object.assign(this.invgaji[i], { totpot: this.totpot[i] })
                    }
                //TOTAL GAJI
                for (let i = 0; i < this.totalgaji.length; i++) {
                        Object.assign(this.invgaji[i], { totalgaji: this.totalgaji[i] })
                    }
                for (let i = 0; i < this.totjab.length; i++) {
                        Object.assign(this.invgaji[i], { totjab: this.totjab[i] })
                    }
                for (let i = 0; i < this.subsub.length; i++) {
                        Object.assign(this.invgaji[i], { subsub: this.subsub[i] })
                    }    
    

            })
		},
		closeinvoice(){
            $("#invoicegaji").modal("hide");
		},
		detGaji(id){
            $('#detailgajipegawai').modal('show')
            axios.get('/api/detgajipeg/'+id,{
                headers: { Authorization: "Bearer " + this.token }
            }).then((response) => {
                this.detailgajipeg = response.data.data
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

                this.subsub = response.data.subtotal;
                //TUNJANGAN
                for (let i = 0; i < this.dettun.length; i++) {
                        Object.assign(this.detailgajipeg[i], { dettun: this.dettun[i] })
                    }
                for (let i = 0; i < this.nomdettun.length; i++) {
                        Object.assign(this.detailgajipeg[i], { nomdettun: this.nomdettun[i] })
                    }
                for (let i = 0; i < this.totun.length; i++) {
                        Object.assign(this.detailgajipeg[i], { totun: this.totun[i] })
                    }    
                //BONUS
                for (let i = 0; i < this.detbon.length; i++) {
                        Object.assign(this.detailgajipeg[i], { detbon: this.detbon[i] })
                    }
                for (let i = 0; i < this.nombon.length; i++) {
                        Object.assign(this.detailgajipeg[i], { nombon: this.nombon[i] })
                    }
                for (let i = 0; i < this.totbon.length; i++) {
                        Object.assign(this.detailgajipeg[i], { totbon: this.totbon[i] })
                    }    
                //POTONGAN
                for (let i = 0; i < this.detpot.length; i++) {
                        Object.assign(this.detailgajipeg[i], { detpot: this.detpot[i] })
                    }
                for (let i = 0; i < this.nompot.length; i++) {
                        Object.assign(this.detailgajipeg[i], { nompot: this.nompot[i] })
                    }
                for (let i = 0; i < this.totpot.length; i++) {
                        Object.assign(this.detailgajipeg[i], { totpot: this.totpot[i] })
                    }
                //TOTAL GAJI
                for (let i = 0; i < this.totalgaji.length; i++) {
                        Object.assign(this.detailgajipeg[i], { totalgaji: this.totalgaji[i] })
                    }
                for (let i = 0; i < this.totjab.length; i++) {
                        Object.assign(this.detailgajipeg[i], { totjab: this.totjab[i] })
                    }
                for (let i = 0; i < this.subsub.length; i++) {
                        Object.assign(this.detailgajipeg[i], { subsub: this.subsub[i] })
                    }        
    

            })
        },
	},
	mounted() {
		this.getpt();
		this.getgaji();
		this.getJabatan();
		this.getakun();
		this.getprofile();
		document.getElementById("btnPrint").onclick = function () {
			printElement(document.getElementById("printThis"));
		}

		function printElement(elem) {
			var domClone = elem.cloneNode(true);
			
			var $printSection = document.getElementById("printSection");
			
			if (!$printSection) {
				var $printSection = document.createElement("div");
				$printSection.id = "printSection";
				document.body.appendChild($printSection);
			}
			
			$printSection.innerHTML = "";
			$printSection.appendChild(domClone);
			window.print();
		}
	},
    


}


</script>
<style>
@media screen {
  #printSection {
      display: none;
  }
}

@media print {
  body * {
    visibility:hidden;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    left:0;
    top:0;
  }
}
</style>
