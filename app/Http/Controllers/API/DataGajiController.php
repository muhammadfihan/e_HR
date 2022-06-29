<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DataGajiController extends Controller
{
    public function allgaji(){
        $tunjangan = DB::table('datagaji')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->get();
    return response([
        'data' => $tunjangan,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function buatgaji(Request $request)
    {   
        $buatgaji =  DB::table('datagaji')->where('id', $request->id)->update([
            // 'tanggal' => Carbon::now(),
            'id_tunjangan' => $request->id_tunjangan,
            'id_bonus' => $request->id_bonus,
            'id_potongan' => $request->id_potongan,
        ]);
            return response()->json([
                'data' => $buatgaji,
                'success' => true,
                'message' => 'Update Data Berhasil!',
            ]);

    }
    

  
}
