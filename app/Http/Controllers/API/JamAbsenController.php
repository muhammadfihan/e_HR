<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JamAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class JamAbsenController extends Controller
{
    public function aturjamabsen(Request $request){
        $jam = [
            'id_admin' => 'required|integer',
            'jam_masuk' => 'required|time',
            'jam_pulang' => 'required|time',
        ];
        $jam = JamAbsen::where([
            ['id_admin','=',Auth::user()->id],
        ])->first();
        if($jam == null){
            $jam = JamAbsen::create([
                'id_admin' => Auth::user()->id,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
            ]);
            $response = ['pegawai' => $jam];
            return response([
                'data' => $response,
                'message' => 'Berhasil mengisi jam absen',
                'status' => true,
                'isi' => 'berhasil',
                'success' => true,
            ]);
        };
        if($jam->id_admin != null){
            $update=[
                'jam_masuk' =>  $request->jam_masuk,
                'jam_pulang' =>  $request->jam_pulang,

            ];
            $jam->update($update);
            return response([
                'data' => $update,
                'message' => 'update jam absen',
                'status' => true,
                'isi' => 'berhasil',
                'success' => true,
            ]);
        };
      
 


    }
    public function updateabsen(Request $request)
    {

            $validate = Validator::make($request->all(), [
                'jam_masuk' => 'required|time',
                'jam_pulang' => 'required|time',
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
        $data = DB::table('jamabsen')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->get();
        return response()->json([
            'data' => $data,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }
}
