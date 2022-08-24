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
            ->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Get data berhasil TESSS',
                'data' => $cuti
            ]);
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
