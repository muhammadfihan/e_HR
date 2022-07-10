<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DataGajiController extends Controller
{
    public function allgaji(){
        $tunjangan = DB::table('datagaji')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->get();
        // $tun = explode(',', $tunjangan[0]->id_tunjangan);
        // foreach($tun as $index => $row){ 
        //     $data[$index] = DB::table('tunjangan')->where('id', $row)->first();
        //     $nominalALL[$index] = $data[$index]->nominal;
        //     $jenis[$index] = $data[$index]->jenis_tunjangan;
        // }
        // dd($nominalALL);
       
    return response([
        'data' => $tunjangan,
        // 'tunjangan' => $jenis,
        // 'nominal' => $nominalALL,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function buatgaji(Request $request)
    {   
        $buatgaji =  DB::table('datagaji')->where('id', $request->id)->update([
            'tanggal' => Carbon::now(),
            'id_tunjangan' => implode(',', $request->id_tunjangan),
            'id_bonus' => implode(',', $request->id_bonus),
            'id_potongan' =>  implode(',', $request->id_potongan),
        ]);

        $detail = DB::table('datagaji')->where('id', $request->id)->first();
            return response()->json([
                'data' => $buatgaji,
                'detail' => $detail,
                'success' => true,
                'message' => 'Buat Gaji Berhasil!',
            ]);

    }
    

  
}
