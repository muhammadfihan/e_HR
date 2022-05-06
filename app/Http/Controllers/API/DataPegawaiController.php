<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataPegawai;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class DataPegawaiController extends Controller
{
    public function isibiodata(Request $request){
        $pegawai = [
            'name' => 'required|string',
            'email' => 'required|string',
            'jabatan' => 'required|string',
            'no_hp' => 'required|bigInteger',
            'no_ktp' => 'required|bigInteger',
            'gender' => 'required|string',
            'alamat' => 'required|string',
        ];

        $huruf = "1234567890";
        $nopegawai = strtoupper(substr(str_shuffle($huruf), 0, 9));
        $pegawai = DataPegawai::create([
            'no_pegawai' => 'PN'.$nopegawai,
            'name' => $request->name,
            'email' => Auth::user()->email,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'no_ktp' => $request->no_ktp,
            'gender' => $request->gender,
            'alamat' => $request->alamat


        ]);
        $response = ['pegawai' => $pegawai];
        return response()->json($response, 200);


    }
    public function datapegawai()
    {
       $datapegawai = DB::table('pegawais')
       ->select('*')
       ->get();
       return response([
           'data' => $datapegawai,
           'message' => 'get data berhasil',
           'status' => true
       ]);

    }
    public function detailpegawai($id)
    {
       $datapegawai = DB::table('pegawais')
       ->where('id' ,$id)
       ->get();
       return response([
           'data' => $datapegawai,
           'message' => 'get data berhasil',
           'status' => true,
       ]);

    }
    public function editPegawai($id)
    {
        $pegawai = DataPegawai::find($id);
        return response()->json($pegawai);
    }

    public function updatePegawai(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'role' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('pegawais')->where('id', $id)->update([
                'name' => $request->name,
                'role' => $request->role,
                'jabatan' => $request->jabatan,
                'status' => $request->status
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Update Data Berhasil!',
            ]);
        }
    }
    public function hapusPegawai(Request $request, $id)
    {
        $data = DataPegawai::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
}
