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


</template>


<script>

export default {
    name: "GajiPegawai",
    data() {
        return {
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    


}


</script>


