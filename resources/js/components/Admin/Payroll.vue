<template>
    <body>
        
    <div class="container-md" >

        <div class="main">
            <div class="row" style=" margin-bottom:6px; margin-left:-2px; font-style: normal; font-size:30px; line-height: 47px;color: #E95A09;">
                <p>Payroll</p>
                 <div class="menugaji" style="justify-content: space-between;">
                    <button class="menunya" style="padding:28px">
                        <p style="text-align:left">Data Gaji Karyawan</p>
                        <p style="text-align:left"><i class="fa-solid fa-users" style="font-size:70px"></i></p>
                    </button>
                   <button class="menunya" style="padding:28px">
                        <p style="text-align:left">Laporan Gaji</p>
                        <p style="text-align:left"><i class="fa-regular fa-file-lines" style="font-size:70px"></i></p>
                    </button>
                    <button class="menunya" style="padding:28px">
                        <p style="text-align:left">Tunjangan dan Bonus</p>
                        <p style="text-align:left"><i class="fa-solid fa-circle-dollar-to-slot" style="font-size:70px"></i></p>
                    </button>
                </div>
            </div>
            <div class="container" style="margin-top:180px">
            <div class="row" style=" margin-bottom:-4px; margin-left:-105px; font-style: normal; font-size:25px; line-height: 47px;color: #E95A09;">
                <p>Gaji Karyawan</p>

            </div>
            </div>
            <table class="table align-start border"  >
                <thead class="" >
                <tr>
                    <th>&nbsp;</th>
                    <th>No</th>
                    <th>Pegawai</th>
                    <th>Jabatan</th>
                    <th>No Pegawai</th>
                    <th>Status</th>
                    <th>Gaji Pokok</th>
                    <th style="text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr>
            </tbody>
            </table>
        </div>          

    </div>
    </body>

</template>


<script>

export default {
    name: "Payroll",
    data() {
        return {
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
  


}


</script>


