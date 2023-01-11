<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CutiTahunanController extends Controller
{
    //
    public function CutiTahunanAll(){
        $cuti = DB::table('table_master_cuti_tahunan')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->latest()
            ->paginate(8);

            return response()->json([
                'status' => true,
                'message' => 'Get data berhasil TESSS',
                'data' => $cuti
            ]);
    }
    public function searchjatahcuti($key){
        $result = DB::table('table_master_cuti_tahunan')
                ->select('*')
                ->where('table_master_cuti_tahunan.id_admin', Auth::user()->id)
                ->where('email', 'like', '%' . $key . '%')
                ->where('table_master_cuti_tahunan.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(8);

            return $result;
    }
    public function CutiTahunanP(){
        $cuti = DB::table('table_master_cuti_tahunan')
            ->select('*')
            ->where('email', Auth::user()->email)
            ->get();

            return response()->json([
                'status' => true,
                'message' => 'Get data berhasil',
                'data' => $cuti
            ]);
    }


    public function TambahCutiTahunanBaru()
    {
        
    }
}
