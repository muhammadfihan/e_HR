<template>
    <body>

    <div class="container-md" >

        <div class="main">
            <div>
                <h3 style="color:#E95A09">Penggajian</h3>
           </div>
        </div>
    </div>
    </body>

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


