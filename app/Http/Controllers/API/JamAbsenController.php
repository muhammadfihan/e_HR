<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HariKerja;
use App\Models\JamAbsen;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class JamAbsenController extends Controller
{
    public function aturjamabsen(Request $request){
        $jam = HariKerja::where([
            ['id_admin','=',Auth::user()->id],
        ])->first();
        if($jam == null){
            if($request->input('buka_presensi') > $request->input('jam_masuk')){
                return response()->json([
                    'status' => 2,
                    'message' => 'Buka presensi Gagal'
                ]);
            }
            if($request->input('tutup_presensi') < $request->input('jam_pulang')){
                return response()->json([
                    'status' => 3,
                    'message' => 'Batas Presensi Gagal'
                ]);
            }else{
                $hariArray = implode(",",$request->hari_kerja);
                $jam = HariKerja::create([
                    'id_admin' => Auth::user()->id,
                    'jam_masuk' => $request->jam_masuk,
                    'jam_pulang' => $request->jam_pulang,
                    'buka_presensi' => $request->buka_presensi,
                    'tutup_presensi' => $request->tutup_presensi,
                    'hari_kerja' => $hariArray
                ]);
                $response = ['pegawai' => $jam];
                return response([
                    'data' => $response,
                    'message' => 'Berhasil mengisi jam absen',
                    'status' => true,
                    'isi' => 'berhasil',
                    'success' => true,
                ]);
            }
        };
        if($jam->id_admin != null){
            if($request->input('buka_presensi') > $request->input('jam_masuk')){
                return response()->json([
                    'status' => 2,
                    'message' => 'Buka presensi Gagal'
                ]);
            }
            if($request->input('tutup_presensi') < $request->input('jam_pulang')){
                return response()->json([
                    'status' => 3,
                    'message' => 'Batas Presensi Gagal'
                ]);
            }else{
                $hariArray = implode(",",$request->hari_kerja);
                $update=[
                    'jam_masuk' =>  $request->jam_masuk,
                    'jam_pulang' =>  $request->jam_pulang,
                    'buka_presensi' => $request->buka_presensi,
                    'tutup_presensi' => $request->tutup_presensi,
                    'hari_kerja' => $hariArray
                ];
                $jam->update($update);
                return response([
                    'data' => $update,
                    'message' => 'update jam absen',
                    'status' => true,
                    'isi' => 'berhasil',
                    'success' => true,
                ]);
            }
        };
      
 


    }
    public function updateabsen(Request $request)
    {

            $validate = Validator::make($request->all(), [
                'jam_masuk' => 'required|time',
                'jam_pulang' => 'required|time',
                'batas_pulang' => 'required|time',
             ]);
    
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Update Data Gagal!',
                ]);
            } else {
                $data = DB::table('jamabsen')->where('id', Auth::user()->id)->update([
                    'jam_masuk' => $request->jam_masuk,
                    'jam_pulang' => $request->jam_pulang,
                ]);
                return response()->json([
                    'data' => $data,
                    'success' => true,
                    'message' => 'Update Data Berhasil!',
                ]);
            }
        
    }

    public function tampil (Request $request){
        $hariIni = Carbon::now()->locale('id');
        $hari = $hariIni->dayName;
        $data = DB::table('harikerja')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->first();
        if($data == null){
            return response()->json([
                'message' => 'Salah',
                'status' => false
            ]);
        }else{
            $cek = str_contains($data->hari_kerja, $hari);
            if($cek){
                return response()->json([
                    'data' => $data,
                    'message' => 'Benar',
                    'status' => true
                ]);
            }else{
                return response()->json([
                    'data' => $data,
                    'message' => 'Salah',
                    'status' => false
                ]);
            }
        }
    }

    public function tampiljampeg (Request $request){
        $hariIni = Carbon::now()->locale('id');
        $hari = $hariIni->dayName;
        $data = DB::table('harikerja')
        ->select('*')
        ->where('id_admin', Auth::user()->id_admin)
        ->first();
        $cek = str_contains($data->hari_kerja, $hari);
        if($cek){
            return response()->json([
                'data' => $data,
                'message' => 'Benar',
                'status' => true
            ]);
        }else{
            return response()->json([
                'data' => $data,
                'message' => 'Salah',
                'status' => false
            ]);
        }
    }
    public function tampilhari (Request $request){
        $data = DB::table('hari')
        ->select('*')
        ->get();
        return response()->json([
            'data' => $data,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }

}
