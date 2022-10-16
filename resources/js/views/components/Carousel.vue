<template>
  <div class="card card-carousel overflow-hidden h-100 p-0">
    <div class="carousel slide h-100">
      <div class="carousel-inner border-radius-lg h-100 bg-gradient-primary" >
        <div class="card-header border-0 text-end bg-transparent " >
                <a class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  
                </a>
                  <button type="submit" class="btn btn-white text-primary font-weight-bolder">Atur Presensi</button>
        </div>
        <div class="card-body d-flex flex-column p-0" style="margin-top:-35px">
							<div class="card-body" style="text-align:center;">
                  <div class="date text-white" style="font-size:28px;">
                      <span id="dayname">Day</span>,&nbsp;
                      <span id="daynum">00</span>&nbsp;
                      <span id="month">Month</span>&nbsp;
                      <span id="year">Year</span>
                  </div>
                  <div class="time text-white" style="font-size:40px;font-weight: 600; color: #124EB2;">
                      <span id="hour">00</span>:
                      <span id="minutes">00</span>:
                      <span id="seconds">00</span>
                  </div>
               </div>
               <div class="" style="margin-top:20px">
													<!--begin::Row-->
													<div class="row m-0 text-center">
														<div class="col">
															<div class="font-size-lg text-white font-weight-bold" >Jam Masuk</div>
															<div class="font-size-h4 text-white font-weight-bolder">07.00</div>
														</div>
														<div class="col">
															<div class="font-size-lg text-white font-weight-bold">Jam Pulang</div>
															<div class="font-size-h4 text-white font-weight-bolder mb-4">16.00</div>
														</div>
													</div>
												</div>
              </div>
        <div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "carousel",
  beforeMount() {
     this.timer =  setInterval(function(){
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
            }, 1000);
            },
    beforeUnmount() {
            clearInterval(this.timer);
            },
};
</script>
