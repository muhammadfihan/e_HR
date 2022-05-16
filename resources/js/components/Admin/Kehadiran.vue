<template>
    <body>

    <div class="container-md" >

        <div class="main">
            <div class="row" style=" margin-bottom:6px; margin-left:-2px; font-style: normal; font-size:30px; line-height: 47px;color: #E95A09;">
                <p>Data Absensi</p>
            </div>
            <table class="table align-start border"  >
                <thead class="" >
                <tr>
                    <th>&nbsp;</th>
                    <th>No</th>
                    <th>Pegawai</th>
                    <th>No Pegawai</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Keterangan</th> 
                    <th style="text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr >
                </tr>
            </tbody>
            </table>
        </div>
    </div>
    </body>

</template>


<script>

export default {
    name: "Kehadiran",
    data() {
        return {
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    


}


</script>


