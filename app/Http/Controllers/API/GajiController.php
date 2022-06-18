<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tunjangan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{
    public function tambahtunjangan(Request $request){
        $tunjangan = Tunjangan::create([
            'id_admin' => Auth::user()->id,
            'jenis_tunjangan' => $request->jenis_tunjangan,
            'nominal' => $request->nominal,
        ]);
        $tunjangan->save();
        $success = true;
        return response()->json([
            'message' =>'Jabatan successfully added',
            'success' => $success

            ]);
    }

    public function updatetunjangan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jenis_tunjangan' => 'required',
            'nominal' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('tunjangan')->where('id', $request->id)->update([
                'jenis_tunjangan' => $request->jenis_tunjangan,
                'nominal' => $request->nominal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Jabatan Berhasil!',
            ]);
        }
    }
    public function hapustunjangan(Request $request, $id)
    {
        $data = Tunjangan::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }

    public function alltunjangan(){
        $tunjangan = DB::table('tunjangan')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->get();
    return response([
        'data' => $tunjangan,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
}
