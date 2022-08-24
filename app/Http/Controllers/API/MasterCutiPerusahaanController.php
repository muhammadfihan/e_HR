<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataPegawai;
use App\Models\CutiPerusahaan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MasterCutiPerusahaanController extends Controller
{
    //
    public function CutiPerusahan(){
        $cuti = DB::table('master_cuti_perusahaan')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->latest()
            ->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Get data berhasil TESS',
                'data' => $cuti
            ]);
    }
    public function CutiPerusahanPeg(){
        $datapegawai = DB::table('table_master_cuti_tahunan')
           ->where('email', Auth::user()->email)
           ->latest()
           ->get();
       return response([
           'data' => $datapegawai,
           'message' => 'get data berhasil',
           'status' => true
       ]);

    }

    public function TambahCutiPerusahaan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jumlah_cuti' => 'required',
         ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            $CEK = DB::table('master_cuti_perusahaan')
                ->select('*')
                ->where('id_admin', Auth::user()->id)
                ->where('tahun', Carbon::now()->format('Y'))
                ->get()
                ->toArray();

            if (count($CEK) == 0) {
                # code...
                $data = DB::table('master_cuti_perusahaan')->insert([
                    'id_admin' => Auth::user()->id,
                    'jumlah_cuti' => (int)$request->input('jumlah_cuti'),
                    'tahun' => Carbon::now()->format('Y')
                ]);

                return response()->json([
                    'data' => $data,
                    'message' =>'Master Cuti successfully added',
                    'success' => true
        
                    ]); 
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Error!! Duplicate Data',
                    // 'data' => $cuti
                ]);
            }
        }
    }
}
