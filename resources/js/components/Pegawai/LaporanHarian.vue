<template>
    <body>

    <div class="container-md" >

        <div class="main">
            <div>
                <h3 style="color:#E95A09">Laporan Harian</h3>
           </div>
        </div>
    </div>
    </body>

</template>


<script>

export default {
    name: "LaporanHarian",
    data() {
        return {
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
    },
    


}


</script>


