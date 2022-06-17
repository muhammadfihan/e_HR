<template>
    <body>

    <div class="container-md" >

        <div class="main">
            <div>
                <h3 style="color:#E95A09">Data Absensi Pegawai</h3>
           </div>
            <div style="margin-top:20px">
            <table class="table align-start border"  >
                <thead class="" >
                <tr>
                    <th>&nbsp;</th>
                    <th>No</th>
                    <th>Pegawai</th>
                    <th>Nama Pegawai</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Jam Kerja</th>
                    <th>Keterangan</th> 
                    <th>Lokasi</th>
                    <th style="text-align: center;">Action</th>
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
                        <td>
                            <div class="ms-3">
                                <p class="fw-bold mb-1">{{ data.name }}</p>
                                <p class="text-muted mb-0">{{ data.email }}</p>
                            </div>
                        </td>
                        <td><a>{{ data.nama_lengkap }}</a></td>
                        <td>{{ data.tanggal }}</td>
                        <td>{{ data.jam_masuk }}</td>
                        <td>{{ data.jam_pulang }}</td>
                        <td>{{ data.jam_kerja }}</td>
                       <td>
                            <span class="badge badge-success" v-if="data.keterangan == 'On Time'" >{{data.keterangan}}</span>
                            <span class="badge badge-danger" v-else-if="data.keterangan == 'Terlambat'" >{{data.keterangan}}</span>
                        </td>
                        <td>{{ data.lokasi }}</td>
                        <td style="text-align: center; color: blue;cursor:pointer" @click="detail()">Detail</td>
                </tr>
            </tbody>
            </table>
            </div>
        </div>
    </div>
    </body>

</template>


<script>

export default {
    name: "Kehadiran",
    data() {
        return {
            absensipegawai : [],
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },

     created() {
         this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tampilabsen',{
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
    


}


</script>


