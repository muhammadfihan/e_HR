<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AturShift;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    public function cekpegawai(){
        $cek = DB::table('shift')
            ->where('id_admin', Auth::user()->id)
            ->pluck('email_pegawai');

        $hasil = explode(",", $cek);
        $tes = DB::table('akunpegawai')
            ->where('id_admin', Auth::user()->id)
            ->whereNotIn('email', $cek)
            ->pluck('email');
        return response()->json([
                'success' => true,
                'data' => $cek,
                'tes' => $tes,
                'teslah' => $hasil,
                'message' => 'Cek Shift',
            ]);
    }
    public function aktifshift(Request $request){
        $cekshift = DB::table('shift')->where('id_admin', Auth::user()->id)->get();
        if($cekshift == null){
            return response()->json([
                'success' => false,
                'message' => 'Shift telah dibuat',
            ]);
        }else{
            $shift = DB::table('pegawais')
            ->where('id_admin', Auth::user()->id)
            ->where('status','Aktif')->where('nama_lengkap','!=', null)
            ->get()->toArray();
            $bukashift = [];
            for($i= 0; $i < count($shift); $i++){
                $bukashift[] = [
                    'id_admin' => Auth::user()->id,
                    'email_pegawai' => $shift[$i]->email,
                    'id_shift' => Null,
                    'hari' => Null,
                ];
             }
            $buat = DB::table('shift')->insert($bukashift);
            return response()->json([
                'success' => true,
                'message' => 'Buat Berhasil',
                'data' => $buat
            ]);
        }
    }
    public function nonaktifshift(Request $request){
        $nonaktif = DB::table('shift')->where('id_admin', Auth::user()->id)
            ->delete();
        return response()->json([
            'success' => true,
            'data' => $nonaktif,
        ]);
    }
    public function buatshift(Request $request){
        $validate = Validator::make($request->all(), [
            'jenis_shift' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
         ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Buat Shift Gagal!',
            ]);
        }else{
            $buat = AturShift::create([
                'id_admin' => Auth::user()->id,
                'jenis_shift' => $request->jenis_shift,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Buat Berhasil',
                'data' => $buat
            ]);
        }  
    }
    public function updateshift(Request $request){
        $update = DB::table('aturshift')->where('id', $request->id)
            ->update([
                'jenis_shift' => $request->jenis_shift,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang
            ]);
        return response()->json([
            'success' => true,
            'data' => $update
        ]);

    }
    public function hapusshift($id){

    }

    public function getshift(){

    }
    public function getshiftpeg(){

    }
}
