<template>
    <body>
        
    <div class="container-md" >

        <div class="main">
            <div class="row" style=" margin-bottom:6px; margin-left:-2px; font-style: normal; font-size:30px; line-height:47px;color: #E95A09;">
               <div>
                <h3 style="color:#E95A09">Payroll dan Penggajian</h3>
                </div>
                 <div class="menugaji" style="justify-content: space-between; margin-top: 20px;">
                    <button class="menunya active" data-id="gaji" style="padding:28px">
                        <p style="text-align:left">Data Gaji Karyawan</p>
                        <p style="text-align:left"><i class="fa-solid fa-users" style="font-size:70px"></i></p>
                    </button>
                   <button class="menunya" data-id="laporan" style="padding:28px">
                        <p style="text-align:left">Laporan Gaji</p>
                        <p style="text-align:left"><i class="fa-regular fa-file-lines" style="font-size:70px"></i></p>
                    </button>
                    <button class="menunya" data-id="tunjangan" style="padding:28px">
                        <p style="text-align:left">Tunjangan dan Bonus</p>
                        <p style="text-align:left"><i class="fa-solid fa-circle-dollar-to-slot" style="font-size:70px"></i></p>
                    </button>
                </div>
            </div>

            <div class="tab-content">
               <div class="tab-pane active" id="gaji"> 
                <div style="margin-top:180px">
                    <div class="row" style=" margin-bottom:-4px; margin-left:0px; font-style: normal; font-size:25px; line-height: 47px;color: #E95A09;">
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
              <div class="tab-pane" id="laporan"> 
                <div style="margin-top:180px">
                    <div class="row" style=" margin-bottom:-4px; margin-left:0px; font-style: normal; font-size:25px; line-height: 47px;color: #E95A09;">
                    <p>Laporan Karyawan</p>

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
              <div class="tab-pane" id="tunjangan"> 
                <div style="margin-top:180px">
                    <div class="row" style=" margin-bottom:-4px; margin-left:0px; font-style: normal; font-size:25px; line-height: 47px;color: #E95A09;">
                    <p>Tunjangan dan Bonus</p>

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
    method:{
        
        
        
    },

    mounted () {
            $(document).ready(function() {
                $(".menunya").on("click", function() {
                    var card = $(this).data("id");
                    $(".menunya, .tab-pane").removeClass("active");
                    $(this).addClass("active");
                    $("#" + card).addClass("active");
                    });
                });
            
    }


}


</script>

<style scope>
    .menugaji {
        width: 100vw;
        background-color: white;
        border: none;
        height: 57px;
        place-content: center;
        display: flex;
        justify-content: center;

    }
    
    .menunya {
        width: 350px;
        height: 200px;
        color: #E95A09;
        border: none;
        border-radius: 17px;
        background: #FFFFFF;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.20);
        transition: ease-out 0.3s;
    }
    
    .menunya:hover {
        background-color: #E95A09;
        color: white;
        outline: none;
    }
    .menunya.active {
        background-color: #E95A09;
        color: white;
        outline: none;
        transition: background-color 0.5s ease-out 0.3s;
    }
    .tab-content .tab-pane {
        display: none;
    }
    
    .tab-content .tab-pane.active {
        display: block;
    }
</style>


