<template>
    <body>

    <div class="container-md" >

        <div class="main">
              <div>
                <h3 style="color:#E95A09">Approvement Lembur</h3>
           </div>
            <div style="margin-top:20px">
            <table class="table align-start border"  >
                <thead class="" >
                <tr>
                   <th>&nbsp;</th>
                    <th>No</th>
                    <th>Pegawai</th>
                    <th>Jabatan</th>
                    <th>No Pegawai</th>
                    <th>Keterangan</th>
                    <th>Status</th>
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
    </div>
    </body>

</template>


<script>

export default {
    name: "Lembur",
    data() {
        return {
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    


}


</script>


