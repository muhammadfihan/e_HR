<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $ip = $request->ip();
            $absen = Absensi::create([
                'id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'id_admin' => Auth::user()->id_admin,
                'name' => Auth::user()->name,
                'nama_lengkap' => Auth::user()->name,
                'tanggal' => $tanggal,
                'jam_masuk' => $localtime,
                'lokasi' => $ip
            ]);
            if ($absen->jam_masuk <= "07:15:00"){
                $ket = [
                    'keterangan' => "On Time",
                ];
                $ontime = Absensi::where([
                    ['id','=', Auth::user()->id],
                    ['email','=', Auth::user()->email],
                    ['tanggal','=',$tanggal],
                ])->first();
                $ontime->update($ket);
                return response([
                    'data' => $ket,
                    'message' => 'on time',
                    'success' => true
                ]);
            }
            if ($absen->jam_masuk >= "07:15:00"){
                $ket = [
                    'keterangan' => "Terlambat",
                ];
                $telat = Absensi::where([
                    ['id','=', Auth::user()->id],
                    ['email','=', Auth::user()->email],
                    ['tanggal','=',$tanggal],
                ])->first();
                $telat->update($ket);
                return response([
                    'data' => $ket,
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
            return response([
                'data' => $data,
                'message' => 'get data berhasil',
                'status' => true
            ]);
    }

    public function absenpulang(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');

        $presensi = Absensi::where([
            ['id','=',Auth::user()->id],
            ['tanggal','=',$tanggal],
        ])->first();
        
        $dt=[
            'jam_pulang' => $localtime,
            'jam_kerja' => date('H:i:s', strtotime($localtime) - strtotime($presensi->jam_masuk))
        ];

        if ($presensi->jam_pulang == ""){
            $presensi->update($dt);
            return response([
                'data' => $dt,
                'message' => 'presensi pulang berhasil',
                'success' => true
            ]);
        }else{
            return response([
                'message' => 'Sudah presensi pulang',
                'success' => false
            ]);
        }
    }
}
