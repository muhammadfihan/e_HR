<template>
     <body>

    <div class="container-md" >

        <div class="main">
            <div>
                <h3 style="color:#E95A09">Selamat Datang, {{ name }}</h3>
               
           </div>
           <div class="card text-center" style="margin-top:40px">
            <div class="card-header">
                <h5>Silahkan Melakukan Presensi Harian</h5> 
            </div>
            <div class="card-body">
                <div>
                <div class="datetime" >
                    <div class="date" style="font-size:30px;color:#124EB2">
                        <span id="dayname">Day</span>,&nbsp;
                        <span id="daynum">00</span>&nbsp;
                        <span id="month">Month</span>&nbsp;
                        <span id="year">Year</span>
                    </div>
                    <div class="time" style="font-size:60px;font-weight: 600; color: #124EB2;">
                        <span id="hour">00</span>:
                        <span id="minutes">00</span>:
                        <span id="seconds">00</span>
                       
                    </div>
                    </div>
                </div>    
                <div style="margin-top:15px">
                    <a class="btn" @click="absenmasuk()" style="margin-right:12px; background-color: #E95A09;color:white; outline: none;">Presensi Masuk</a>
                    <a class="btn" @click="absenpulang()" style="background-color: #E95A09;color:white; outline: none;">Presensi Pulang</a>
                </div>
                
            </div>
            <div class="card-footer text-muted">
                Budayakan Tepat Waktu dan Semangat Bekerja 🤭
            </div>
            </div>
           
        </div>
        
    </div>
    </body>
</template>

<script>
import router from '../router';

export default {
    name: "PegawaiDashboard",
    data() {
            return {
                absensimasuk:[],
                currentUrl: "",
                 form : new Form({
                    id : "",
                    name : "",
                    email : "",
                    nama_lengkap : "",
                    jam_masuk : "",
                    jam_pulang : "",
                    jam_kerja : "",
                    keterangan : "",
                    lokasi : "",
                }),
                loggedIn: localStorage.getItem("loggedIn"),
                token: localStorage.getItem("token"),
                name: localStorage.getItem("name"),
                role: localStorage.getItem("role")
            };
        },
    
    methods: {
        initClock(){
            setInterval(function(){
            var now = new Date();
            var dname = now.getDay(),
            mo = now.getMonth(),
            dnum = now.getDate(),
            yr = now.getFullYear(),
            hou = now.getHours(),
            min = now.getMinutes(),
            sec = now.getSeconds()
            
            
            if(hou == 24){
                hou = 0;
            }
            if(hou > 24){
                hou = hou - 24;
            }

            Number.prototype.pad = function(digits){
                for(var n = this.toString(); n.length < digits; n = 0 + n);
                return n;
            }

            var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            var week = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
            var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds"];
            var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2)];
            for(var i = 0; i < ids.length; i++)
            document.getElementById(ids[i]).innerHTML = values[i];
            }, 1000)
        },
        absenmasuk() {
            this.form.post('/api/absenmasuk', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Melakukan Presensi",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                }
                if (response.data.success == false){
                    Swal.fire({
                        icon: "error",
                        title: "Sudah Presensi Masuk",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                }
            })
        },
        absenpulang() {
            this.form.post('/api/absenpulang', {
                headers : { Authorization: "Bearer " + this.token },
            }).then((response) => {
                if (response.data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil Presensi Pulang",
                        text: "Silahkan Pulang",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                }
                if (response.data.success == false){
                    Swal.fire({
                        icon: "error",
                        title: "Sudah Presensi Pulang",
                        showConfirmButton: false,
                        timer: 1600,
                    })
                }
            })
        },

        
    },

    mounted(){
    
    },
    created(){
        this.initClock();
    },
    beforeDestroy() {
        clearInterval(this.initClock)
    },

}
</script>

<style scoped>

</style>
