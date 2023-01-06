<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use App\Models\Absensi;
use App\Models\CutiTahunan;
use App\Models\HariKerja;
use App\Models\JamAbsen;
use App\Models\LokasiPegawai;
use App\Models\Pemberitahuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Psy\Util\Json;
use Seld\PharUtils\Timestamps;

class AbsensiController extends Controller
{
    public function cekbuka(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        $cektanggal = DB::table('absensipegawai')->where('id_admin', Auth::user()->id)
        ->where('tanggal',$tanggal)->where('keterangan','!=','Izin')->get()->toArray();
        if($cektanggal == []){
            return response()->json([
                'success' => false,
            ]);
        }else{
            $cekhari = DB::table('harikerja')->where('id_admin', Auth::user()->id)->first();
            if($cekhari->buka_presensi < $localtime && $localtime < $cekhari->tutup_presensi){
                return response()->json([
                    'success' => 12,
                    'data' => $cektanggal
                ]);
            }else{
                return response()->json([
                    'success' => null,
                    'data' => $cektanggal
                ]);
            }
        }
        
    }
    public function bukapresensi(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        $cekhari = DB::table('harikerja')->where('id_admin', Auth::user()->id)->first();
        $hariIni = Carbon::now()->locale('id');
        $hari = $hariIni->dayName;    
        if(str_contains($cekhari->hari_kerja, $hari)){
            if($localtime > $cekhari->buka_presensi){
                $cektanggal = DB::table('absensipegawai')->where('id_admin', Auth::user()->id)
                ->where('tanggal',$tanggal)->where('keterangan','!=', 'Izin')->get()->toArray();
                if($cektanggal != []){
                    return response()->json([
                        'cek' => $cektanggal,
                        'success' => false,
                        'message' => 'Data telah ada'
                    ]);
                }
               else{
                $arraytanggal = explode(',', $tanggal);
                $cuti = DB::table('cuti')->where('id_admin', Auth::user()->id)->where('status_cuti', 'Diterima')->whereJsonContains('list_tanggal',$arraytanggal)->get()->toArray();
                    $bukacuti = [];
                    for($i= 0; $i < count($cuti); $i++){
                        $bukacuti[] = [
                            'id' => $cuti[$i]->id_pegawai,
                            'name' => $cuti[$i]->name,
                            'id_admin' => $cuti[$i]->id_admin,
                            'email' => $cuti[$i]->email,
                            'nama_lengkap' => $cuti[$i]->nama_lengkap,
                            'tanggal' => $tanggal,
                            'keterangan' => "Cuti",
                            'created_at' => $tanggal
                        ];
                    }
                $finalcuti = DB::table('absensipegawai')
                    ->insert($bukacuti);
                $cekcuti = DB::table('cuti')
                    ->where('id_admin', Auth::user()->id)
                    ->where('status_cuti', 'Diterima')
                    ->whereJsonContains('list_tanggal',$arraytanggal)
                    ->pluck('email');
                $izin = DB::table('absensipegawai')
                    ->where('id_admin', Auth::user()->id)
                    ->where('tanggal', $tanggal)
                    ->where('keterangan','Izin')
                    ->pluck('email');
                $presensi = DB::table('pegawais')
                    ->where('id_admin', Auth::user()->id)
                    ->where('status','Aktif')->where('nama_lengkap','!=', null)
                    ->whereNotIn('email',$izin)
                    ->whereNotIn('email',$cekcuti)
                    ->get()->toArray();
                $bukapresensi = [];
                for($i= 0; $i < count($presensi); $i++){
                    $bukapresensi[] = [
                        'id' => $presensi[$i]->id,
                        'name' => $presensi[$i]->name,
                        'id_admin' => $presensi[$i]->id_admin,
                        'email' => $presensi[$i]->email,
                        'nama_lengkap' => $presensi[$i]->nama_lengkap,
                        'tanggal' => $tanggal,
                        'keterangan' => "Tidak Hadir",
                        'created_at' => $tanggal
                    ];
                }
                $buat = DB::table('absensipegawai')->insert($bukapresensi);
                $cek = DB::table('izin')->where('id_admin', Auth::user()->id)->where('tanggal', $tanggal)->where('status_izin', 'Diterima')->pluck('email');
                $update = DB::table('absensipegawai')->where('id_admin', Auth::user()->id)->where('tanggal', $tanggal)->whereIn('email', $cek)->update([
                    'keterangan' => 'Izin'
                ]);
                $updt = DB::table('pegawais')->where('id_admin', Auth::user()->id)->where('nama_lengkap', '!=', null)->pluck('email');
                $jatahcuti = DB::table('akunpegawai')->where('id_admin', Auth::user()->id)->whereIn('email', $updt)->increment('jumlah_kerja');

                $master = DB::table('table_master_cuti_tahunan')->where('id_admin', Auth::user()->id)
                ->pluck('email');
                $cekjatah = DB::table('akunpegawai')->where('id_admin', Auth::user()->id)->where('jumlah_kerja','>=',365)
                ->whereNotIn('email',$master)->get()->toArray();
                $getDataCuti = DB::table('master_cuti_perusahaan')
                ->select('*')
                ->where('id_admin', Auth::user()->id)
                ->where('tahun', Carbon::now()->format('Y'))
                ->get()
                ->toArray();
                $inputcuti = [];
                for($i= 0; $i < count($cekjatah); $i++){
                    $inputcuti[] = [
                        'id_admin' => $cekjatah[$i]->id_admin,
                        'email' => $cekjatah[$i]->email,
                        'id_cuti' => $getDataCuti[0]->id,
                        'jumlah_cuti' => $getDataCuti[0]->jumlah_cuti,
                        'cuti_terpakai' => 0,
                        'sisa_cuti' => $getDataCuti[0]->jumlah_cuti,
                        'tahun' => $getDataCuti[0]->tahun
                    ];
                }
                $hasil = DB::table('table_master_cuti_tahunan')->insert($inputcuti);
                if($bukapresensi == null){
                    return response()->json([
                        'success' => 15,
                        'message' => 'Izin Semua',
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'jatah' => $jatahcuti,
                    'jatahcuti' => $hasil,
                    'data' => $buat,
                    'jatahcek' => $cekjatah,
                    'buatcuti' => $finalcuti,
                    'tes' => $update,
                    'isi' => $bukapresensi
                ]);
               }
            }else{
                return response()->json([
                    'success' => 12,
                    'message' => 'Jam Masuk Belum Buka',
                ]);
            }
        }else{
            return response()->json([
                'success' => null,
                'message' => 'Bukan hari kerja',
            ]);
        }

    }
    public function getabsen (){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $data = Absensi::where('email', Auth::user()->email)->where('tanggal', $tanggal)->get();
        return response()->json([
            'data' => $data,
            'message' => 'Get Data Berhasil',
            'success' => true
        ]);
    }
    public function absenmasuk(Request $request){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        $arraytanggal = explode(',', $tanggal);
        $presensi = DB::table('absensipegawai')
            ->select('*')
            ->whereDate('tanggal', $tanggal)
            ->where('id', Auth::user()->id)
            ->first();
        $izin = DB::table('izin')
            ->select('*')
            ->whereDate('tanggal', $tanggal)
            ->where('email', Auth::user()->email)
            ->where('status_izin', '=', 'Diterima')
            ->first();
        $cuti = DB::table('cuti')
            ->where('email', Auth::user()->email)
            ->where('status_cuti', 'Diterima')
            ->whereJsonContains('list_tanggal',$arraytanggal)
            ->first();
        $cekjam = DB::table('harikerja')
            ->where('id_admin', Auth::user()->id_admin)
            ->pluck('tutup_presensi')
            ->first(); 
        $buka = DB::table('harikerja')
            ->where('id_admin', Auth::user()->id_admin)
            ->pluck('buka_presensi')
            ->first();
        $ceklokasi = DB::table('lokasipegawai')
            ->where('id_pegawai', Auth::user()->id)
            ->pluck('expired_at')
            ->first();
        if($cuti != null){
            return response()->json([
                'status' => 25,
                'message' => 'Anda Sedang Cuti !',
            ]);
        }           
        if($localtime < $buka){
             return response()->json([
                'status' => 2,
                'message' => 'Presensi Belum Dimulai !',
            ]);
        }  
        if($localtime > $cekjam){
            return response()->json([
                'status' => 13,
                'message' => 'Bukan Jam kerja !',
            ]);
        }
        if($izin){
            return response()->json([
                'sudahizin' => $izin,
                'status' => 20,
                'message' => 'Anda Sedang izin !',
            ]);
        }if(now('Asia/Jakarta')->toDateTimeString() > $ceklokasi){
            return response()->json([
                'status' => 15,
                'message' => 'Lokasi Expired',
            ]);
        }        
        if (($presensi->jam_masuk != null) && ($izin == null)){
            return response()->json([
                'sudahabsen' => $presensi,
                'success' => false,
                'message' => 'Sudah Presensi!',
            ]);
        }else{
            $filename="";
            $file_path = "upload/";
            $webcam_image = $request->selfie_masuk;
            $image_parts = explode(";base64,", $webcam_image); // split the base64 image
            $image_type_aux = explode("image/", $image_parts[0]); 
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]); // decode the second part of the image
            $filename = uniqid() . '.png';
            $file = $file_path . $filename; 
            file_put_contents($file, $image_base64);

            $masuk = DB::table('harikerja')
            ->select('*')
            ->where('id_admin', Auth::user()->id_admin)
            ->pluck('jam_masuk')
            ->first();
            $lat = $request->input('latmasuk');
            $img = $request->input('selfie_masuk');
            if($lat == "null"){
                return response()->json([
                    'status' => 12,
                    'message' => "Lokasi tidak diizinkan"
                ]);
            }if($img == null){
                return response()->json([
                    'status' => 11,
                    'message' => "Kamera Tidak Diizinkan"
                ]);
            }else{
                $absen = DB::table('absensipegawai')->where('id', Auth::user()->id)->where('tanggal', $tanggal)->update([
                    'selfie_masuk' => $filename,
                    'tanggal' => $tanggal,
                    'jam_masuk' => $localtime,
                    'latmasuk' => $request->latmasuk,
                    'lonmasuk' => $request->lonmasuk,
                ]);
                if($absen){
                    $get = DB::table('absensipegawai')->where('id', Auth::user()->id)->where('tanggal', $tanggal)->first();
                    if ($get->jam_masuk <= $masuk){
                        $timezone = 'Asia/Jakarta'; 
                        $date = new DateTime('now', new DateTimeZone($timezone)); 
                        $tanggal = $date->format('Y-m-d');
                        $localtime = $date->format('H:i:s');
                        $ket = Absensi::where('id', Auth::user()->id)->where('tanggal',$tanggal)->update([
                            'keterangan' => 'On Time'
                        ]);
                        Pemberitahuan::create([
                            'id_admin' => Auth::user()->id_admin,
                            'email' => Auth::user()->email,
                            'judul' => 'Presensi Masuk',
                            'jenis' => 'Presensi Masuk',
                            'status' => 'On Time',
                            'tanggal' => $tanggal,
                            'jam' => $localtime
                        ]);
                        return response()->json([
                            'absensi' => $absen,
                            'data' => $ket,
                            'jam' => $masuk,
                            'message' => 'on time',
                            'success' => true
                        ]);
                    }
                    if ($get->jam_masuk >= $masuk){
                        $timezone = 'Asia/Jakarta'; 
                        $date = new DateTime('now', new DateTimeZone($timezone)); 
                        $tanggal = $date->format('Y-m-d');
                        $localtime = $date->format('H:i:s');
                        $ket = Absensi::where('id', Auth::user()->id)->where('tanggal',$tanggal)->update([
                            'keterangan' => 'Terlambat'
                        ]);
                        Pemberitahuan::create([
                            'id_admin' => Auth::user()->id_admin,
                            'email' => Auth::user()->email,
                            'judul' => 'Presensi Masuk',
                            'jenis' => 'Presensi Masuk',
                            'status' => 'Terlambat',
                            'tanggal' => $tanggal,
                            'jam' => $localtime
                        ]);
                        return response()->json([
                            'absensi' => $absen,
                            'data' => $ket,
                            'jam' => $masuk,
                            'message' => 'terlambat',
                            'success' => true
                        ]);
                    }
        
                    return response()->json([
                        'success' => true,
                        'message' => 'Berhasil Presensi',
                        'absenmasuk' => $absen
                    ]);
    
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'gagal presensi'
                    ]);
                }
            }
        }
    }
    public function tampilabsen(){
            $data = Absensi::
                where('id_admin', Auth::user()->id)
                ->latest()
                ->paginate(8);
            return response()->json([
                'data' => $data,
                'message' => 'get data berhasil',
                'status' => true
            ]);
    }
    public function searchabsen($key)
    {
            $result = DB::table('absensipegawai')
                ->select('*')
                ->where('absensipegawai.id_admin', Auth::user()->id)
                ->where('email', 'like', '%' . $key . '%')
                ->orWhere('name', 'like', '%' . $key . '%')
                ->orWhere('nama_lengkap', 'like', '%' . $key . '%')
                ->orWhere('keterangan', 'like', '%' . $key . '%')
                ->orWhere('tanggal', 'like', '%' . $key . '%')
                ->orWhere('jam_masuk', 'like', '%' . $key . '%')
                ->orWhere('jam_pulang', 'like', '%' . $key . '%')
                ->where('absensipegawai.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(8);

            return $result;

    }
    public function searchabsenpeg($key)
    {
            $result = DB::table('absensipegawai')
                ->select('*')
                ->where('absensipegawai.id_admin', Auth::user()->id)
                ->where('keterangan', 'like', '%' . $key . '%')
                ->orWhere('jam_masuk', 'like', '%' . $key . '%')
                ->orWhere('jam_pulang', 'like', '%' . $key . '%')
                ->orWhere('tanggal', 'like', '%' . $key . '%')
                ->where('absensipegawai.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(8);

            return $result;

    }
    public function tampilpegawai(){
        $data = DB::table('absensipegawai')
            ->select('*')
            ->where('id', Auth::user()->id)
            ->latest()
            ->paginate(8);
        return response()->json([
            'data' => $data,
            'message' => 'get data berhasil',
            'status' => true
        ]);
}
    public function absendashboard(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $data = DB::table('absensipegawai')
                ->select('*')
                ->where('id_admin', Auth::user()->id)
                ->whereDate('tanggal', $tanggal)
                ->latest()
                ->get();
            return response()->json([
                'data' => $data,
                'message' => 'get data berhasil',
                'status' => true
            ]);
    }
    public function counthadir(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $data = DB::table('absensipegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->whereDate('tanggal', $tanggal)
        ->count();
  
    return response()->json([
        'data' => $data,
        'message' => 'get jumlah berhasil',
        'status' => true
    ]);
    }

    public function counttidakhadir(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $data = DB::table('absensipegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('tanggal', $tanggal)
        ->count();
        
        $count = DB::table('users')
        ->select('*')
        ->where('id', Auth::user()->id)
        ->pluck('jumlah_karyawan');

        $tidak_hadir = $count - $data;

    return response()->json([
        'data' => $tidak_hadir,
        'message' => 'get jumlah berhasil',
        'status' => true
    ]);
    }

    public function absenpulang(Request $request){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');

        $filename="";
        $file_path = "upload/";
        $webcam_image = $request->selfie_pulang;
        //$webcam_image = $request->input('image');
        //dd($webcam_image);
        $image_parts = explode(";base64,", $webcam_image); // split the base64 image
        $image_type_aux = explode("image/", $image_parts[0]); 
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]); // decode the second part of the image
        $filename = uniqid() . '.png';
        $file = $file_path . $filename; 
        file_put_contents($file, $image_base64);

        $presensi = Absensi::where('id', Auth::user()->id)
        // ->where('uid', $request->uid)
        ->whereDate('tanggal', $tanggal)
        ->first();

        $tes = HariKerja::where('id_admin', Auth::user()->id_admin)
        ->first();

        // $hasilblm = strtotime($tes->jam_pulang);
        // $hasiltgl = strtotime($tanggal);
        $tutup = DB::table('harikerja')
        ->where('id_admin', Auth::user()->id_admin)
        ->pluck('tutup_presensi')
        ->first();
        $ceklokasi = DB::table('lokasipegawai')
        ->where('id_pegawai', Auth::user()->id)
        ->pluck('expired_at')
        ->first();   
        if($localtime > $tutup){
            return response()->json([
                'status' => 3,
                'message' => 'Presensi Pulang Telah Di tutup'
            ]);
        }
        if ($presensi == null){
            return response()->json([
                'sudahabsen' => $presensi,
                'status' => false,
                'message' => 'Harap Presensi Terlebih Dahulu',
            ]);
        }
        elseif ($localtime < $tes->jam_pulang){
            return response()->json([
                'status' => false,
                'message' => 'Tunggu Pulang',
            ]);
        }
        $lat = $request->input('latpulang');
        $img = $request->input('selfie_pulang');
        if($lat == "null"){
            return response()->json([
                'status' => 12,
                'message' => "Lokasi tidak diizinkan"
            ]);
        }if($img == null){
            return response()->json([
                'status' => 11,
                'message' => "Kamera Tidak Diizinkan"
            ]);
        }if(now('Asia/Jakarta')->toDateTimeString() > $ceklokasi){
            return response()->json([
                'status' => 15,
                'message' => "Lokasi Expired"
            ]);
        }else{
            $dt=[
                'jam_pulang' => $localtime,
                'jam_kerja' => date('H:i:s', strtotime($localtime) - strtotime($presensi->jam_masuk)),
                'selfie_pulang' => $filename,
                'latpulang' => $request->latpulang,
                'lonpulang' => $request->lonpulang
            ];   
    
            if ($presensi->jam_pulang == ""){
                $hasil = DB::table('absensipegawai')
                ->where('id', Auth::user()->id)
                ->whereDate('tanggal', $tanggal)
                ->update($dt);
    
                $totaljamkerja = DB::table('pegawais')
                    ->select('*')
                    ->where('id', Auth::user()->id)
                    ->first();
                $jamkerja = DB::table('absensipegawai')
                    ->select('*')
                    ->where('id', Auth::user()->id)
                    ->whereDate('tanggal', $tanggal)
                    ->first();
                $jumlahkerja = DB::table('pegawais')
                    ->select('*')
                    ->where('id', Auth::user()->id)
                    ->first();    
                $total = date('H:i:s' , strtotime($totaljamkerja->jam_kerja) + strtotime($jamkerja->jam_kerja));
                $jmlh = $jumlahkerja->jumlah_kerja + 1 ;
                $hasil = DB::table('datagaji')
                ->where('id' , Auth::user()->id)
                ->update([
                    'jam_kerja' => $total
                ]);
                $hasil2 = DB::table('pegawais')
                ->where('id' , Auth::user()->id)
                ->update([
                    'jam_kerja' => $total
                ]);
                $hasilkerja = DB::table('pegawais')
                ->where('id' , Auth::user()->id)
                ->update([
                    'jumlah_kerja' => $jmlh
                ]);
                // if($hasilkerja = 365){
                //     $jatahcuti = DB::table('pegawais')
                //     ->where('id' , Auth::user()->id)
                //     ->update([
                //         'jatah_cuti' => 12
                //     ]);   
                // }
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id_admin,
                    'email' => Auth::user()->email,
                    'judul' => 'Presensi Pulang',
                    'jenis' => 'Presensi Pulang',
                    'status' => 'Berhasil',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                return response()->json([
                    'data' => $dt,
                    // 'jatah_cuti' => $jatahcuti,
                    'jumlah_kerja' => $hasilkerja,
                    'updategaji' => $hasil2,
                    'data_lagi' => $hasil,
                    'tanggal' => $tanggal,
                    'total_jamkerja' => $total,
                    'message' => 'presensi pulang berhasil',
                    'success' => true
                ]);
            }else{
                return response()->json([
                    'message' => 'Sudah presensi pulang',
                    'success' => false
                ]);
            }
        }
    }

    public function detailabsen($uid)
    {
       $detabsen = DB::table('absensipegawai')
       ->where('uid' ,$uid)
       ->get();
       return response([
           'data' => $detabsen,
           'message' => 'get data berhasil',
           'status' => true,
       ]);

    }
    public function detailabsenpeg($uid)
    {
       $detabsen = DB::table('absensipegawai')
       ->where('email', Auth::user()->email)
       ->where('uid' ,$uid)
       ->get();
       return response([
           'data' => $detabsen,
           'message' => 'get data berhasil',
           'status' => true,
       ]);

    }
    public function tes(Request $request)
    {
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');

        $presensi = DB::table('absensipegawai')
        ->where('id', Auth::user()->id)
        ->where('uid', $request->uid)
        ->where('jam_pulang','=', null)
        ->where('tanggal', $tanggal)
        ->first();

        return response()->json([
            'data' => $presensi,
            'message' => 'presensi pulang berhasil',
            'success' => true
        ]);

    }

    public function lokasi(Request $request){
        $ceklokasi = DB::table('lokasipegawai')->where('id_pegawai', Auth::user()->id)->first();
        if($ceklokasi == null){
            $lokasi = LokasiPegawai::create([
                'id_admin' => Auth::user()->id_admin,
                'id_pegawai' => Auth::user()->id,
                'email' => Auth::user()->email,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'expired_at' => now('Asia/Jakarta')->addHour()
            ]);
            return response()->json([
                'success' => true,
                'latitude' => $lokasi->latitude,
                'longitude' => $lokasi->longitude
            ]);
        }else{
            $update = DB::table('lokasipegawai')->where('id_pegawai', Auth::user()->id)->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'expired_at' => now('Asia/Jakarta')->addHour()
            ]);
            return response()->json([
                'success' => true,
                'data' => $update
            ]);
        }
    }
    public function getlokasi(){
        $getlokasi = DB::table('lokasipegawai')->where('id_pegawai', Auth::user()->id)->get();
        $lok = DB::table('lokasipegawai')->where('id_pegawai', Auth::user()->id)->first();
        if($getlokasi && $lok == null){
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada Data'
            ]);
        }else{
            $ceklok = DB::table('lokasipegawai')->where('id_pegawai', Auth::user()->id)->pluck('expired_at')->first();
            if(now('Asia/Jakarta') > $ceklok){
                return response()->json([
                    'success' => null,
                    'message' => 'Lokasi Expired'
                ]);
            }if($lok->latitude == null){
                return response()->json([
                    'success' => 12,
                    'message' => 'Telah Logout'
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'data' => $getlokasi,
                    'latitude' => $lok->latitude,
                    'longitude' => $lok->longitude
                ]);
            }
        }
    }

    public function removelokasi(Request $request){
        $ceklokasi = DB::table('lokasipegawai')->where('id_pegawai', Auth::user()->id)->first();
        if($ceklokasi == null){
            return response()->json([
                'success' => true,
                'messsage' => 'data kosong'
            ]);
        }if($ceklokasi !== null){
            if ($ceklokasi->latitude == null) {
                return response()->json([
                    'success' => true,
                    'message' => 'data telah dihapus'
                ]);
            }if($ceklokasi->latitude != null){
                $removelokasi = DB::table('lokasipegawai')->where('id_pegawai', Auth::user()->id)->update([
                    'latitude' => null,
                    'longitude' => null
                ]);
                return response()->json([
                    'success' => true,
                    'date' => $removelokasi,
                    'message' => 'Berhasil dihapus'
                ]);
            }
        }
    }

    public function hapusabsen(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $cek =  Absensi::where('id_admin', Auth::user()->id)->where('tanggal', $tanggal)->get()->toArray();
        if($cek == null){
            return response()->json([
                'success' => false,
                'message' => 'Hapus data tidak ada'
            ]);
        }else{
            Absensi::where('id_admin', Auth::user()->id)->where('tanggal', $tanggal)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hapus data berhasil'
            ]);
        }
    }
}
