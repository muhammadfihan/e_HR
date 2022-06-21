<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    public function absenmasuk(Request $request){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');

        $presensi = Absensi::where([
            ['id','=', Auth::user()->id],
            ['email','=', Auth::user()->email],
            ['tanggal','=',$tanggal],
        ])->first();
        if ($presensi){
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

            $masuk = DB::table('jamabsen')
            ->select('*')
            ->where('id_admin', Auth::user()->id_admin)
            ->pluck('jam_masuk')
            ->first();

            $ip = $request->ip();
            $absen = Absensi::create([
                'id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'id_admin' => Auth::user()->id_admin,
                'name' => Auth::user()->name,
                'nama_lengkap' => Auth::user()->name,
                'selfie_masuk' => $filename,
                'tanggal' => $tanggal,
                'jam_masuk' => $localtime,
                'lokasi' => $ip
            ]);
            if ($absen->jam_masuk <= $masuk){
                $ket = [
                    'keterangan' => "On Time",
                ];
                $ontime = Absensi::where([
                    ['id','=', Auth::user()->id],
                    ['email','=', Auth::user()->email],
                    ['tanggal','=',$tanggal],
                ])->first();
                $ontime->update($ket);
                return response()->json([
                    'absensi' => $absen,
                    'data' => $ket,
                    'jam' => $masuk,
                    'message' => 'on time',
                    'success' => true
                ]);
            }
            if ($absen->jam_masuk >= $masuk){
                $ket = [
                    'keterangan' => "Terlambat",
                ];
                $telat = Absensi::where([
                    ['id','=', Auth::user()->id],
                    ['email','=', Auth::user()->email],
                    ['tanggal','=',$tanggal],
                ])->first();
                $telat->update($ket);
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
        }
    }
    public function tampilabsen(){
            $data = DB::table('absensipegawai')
                ->select('*')
                ->where('id_admin', Auth::user()->id)
                ->latest()
                ->get();
            return response()->json([
                'data' => $data,
                'message' => 'get data berhasil',
                'status' => true
            ]);
    }
    public function absendashboard(){
        $data = DB::table('absensipegawai')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->whereDate('created_at', Carbon::today())
            ->get();
      
        return response()->json([
            'data' => $data,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }
    public function counthadir(){
        $data = DB::table('absensipegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->whereDate('created_at', Carbon::today())
        ->count();
  
    return response()->json([
        'data' => $data,
        'message' => 'get jumlah berhasil',
        'status' => true
    ]);
    }
    public function counttidakhadir(){
        $data = DB::table('absensipegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->whereDate('created_at', Carbon::today())
        ->count();
        
        $count = DB::table('users')
        ->select('*')
        ->where('id', Auth::user()->id)
        ->pluck('jumlah_karyawan');

        $tidak_hadir = $data - $count;

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

        $presensi = Absensi::where([
            ['id','=',Auth::user()->id],
            ['tanggal','=',$tanggal],
        ])->first();
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
        $dt=[
            'jam_pulang' => $localtime,
            'jam_kerja' => date('H:i:s', strtotime($localtime) - strtotime($presensi->jam_masuk)),
            'selfie_pulang' => $filename,
        ];

        if ($presensi->jam_pulang == ""){
            $presensi->update($dt);
            return response()->json([
                'data' => $dt,
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

    public function detailabsen($id)
    {
       $detabsen = DB::table('absensipegawai')
       ->where('id' ,$id)
       ->get();
       return response([
           'data' => $detabsen,
           'message' => 'get data berhasil',
           'status' => true,
       ]);

    }
}
