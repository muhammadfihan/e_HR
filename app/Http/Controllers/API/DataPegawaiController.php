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
            'id_perusahaan' => 'required|integer',
            'id_jabatan' => 'required|integer',
            'id_admin' => 'required|integer',
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
            'id_perusahaan' => $request->id_perusahaan,
            'id_jabatan' => $request->id_jabatan,
            'id_admin' => $request->id_admin,
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
           ->where('id_admin', Auth::user()->id)
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
    public function editpegawai($id)
    {
        $edit = DB::table('pegawais')
            ->where('id' ,$id)
            ->get();
       return response([
           'data' => $edit,
           'message' => 'get data berhasil',
           'status' => true,
       ]);
    }

    public function updatepegawai(Request $request)
    {
        
            DB::table('pegawais')->where('id', $request->id)->update([
                'name' => $request->name,
                'id_jabatan' => $request->id_jabatan,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Data Berhasil!',
            ]);
        
    }
    public function hapuspegawai(Request $request, $id)
    {
        $data = DataPegawai::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
}
