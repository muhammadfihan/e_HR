<template>

    <body>
 <div class="container-md" >

        <div class="main">
            <div class="row" style=" margin-bottom:6px; margin-left:-2px; font-style: normal; font-size:30px; line-height:47px;color: #E95A09;">
               <div>
                <h3 style="color:#E95A09">Pengajuan</h3>
                </div>
                 <div class="menupengajuan" style="justify-content: space-between; margin-top: 20px;">
                    <button class="menunya active" data-id="cuti" style="padding:28px">
                        <p style="text-align:left">Pengajuan Cuti</p>
                        <p style="text-align:left"><i class="fa-solid fa-person-breastfeeding" style="font-size:70px"></i></p>
                        
                    </button>
                   <button class="menunya" data-id="lembur" style="padding:28px">
                        <p style="text-align:left">Pengajuan Lembur</p>
                        <p style="text-align:left"><i class="fa-solid fa-chalkboard-user" style="font-size:70px"></i></p>
                        
                    </button>
                    <button class="menunya" data-id="jabatan" style="padding:28px">
                        <p style="text-align:left">Kenaikan Jabatan</p>
                        <p style="text-align:left"><i class="fa-solid fa-person-arrow-up-from-line" style="font-size:70px"></i></p>
                        
                    </button>
                </div>
            </div>

            <div class="tab-content">
               <div class="tab-pane active" id="cuti"> 
                 <div class="row" style="margin-top:180px">
                    <div class="col-md-12 text-left">
                        <p style="color:#E95A09;font-size: 25px;">Riwayat Pengajuan Cuti</p>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal"  style="background-color:#124EB2;margin-bottom: 8px;">Ajukan Cuti</button>
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
              <div class="tab-pane" id="lembur"> 
                <div class="row" style="margin-top:180px">
                    <div class="col-md-12 text-left">
                        <p style="color:#E95A09;font-size: 25px;">Riwayat Pengajuan Lembur</p>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal"  style="background-color:#124EB2;margin-bottom: 8px;">Ajukan Lembur</button>
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
              <div class="tab-pane" id="jabatan"> 
               <div class="row" style="margin-top:180px">
                    <div class="col-md-12 text-left">
                        <p style="color:#E95A09;font-size: 25px;">Riwayat Kenaikan Jabatan</p>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal"  style="background-color:#124EB2;margin-bottom: 8px;">Ajukan Kenaikan</button>
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
    name: "Pengajuan",
    data() {
        return {
            token: localStorage.getItem("token"),
            role: localStorage.getItem('role'),
        }
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
    .menupengajuan {
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


