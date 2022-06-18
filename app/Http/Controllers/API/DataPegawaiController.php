<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataPegawai;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DataPegawaiController extends Controller
{
    public function isibiodata(Request $request){
        $pegawai = [
            'name' => 'required|string',
            'nama_lengkap' => 'required|string',
            'email' => 'required|string',
            'jabatan' => 'required|integer',
            'id_admin' => 'required|integer',
            'id' => 'required|integer',
            'pendidikan' => 'required|string',
            'no_hp' => 'required|bigInteger',
            'no_ktp' => 'required|bigInteger',
            'gender' => 'required|string',
            'alamat' => 'required|string',
        ];

        $huruf = "1234567890";
        $nopegawai = strtoupper(substr(str_shuffle($huruf), 0, 9));
        $pegawai = DataPegawai::updateOrCreate([
            'no_pegawai' => 'PN'.$nopegawai,
            'name' => Auth::user()->name,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => Auth::user()->email,
            'id' => Auth::user()->id,
            'jabatan' => Auth::user()->jabatan,
            'id_admin' => Auth::user()->id_admin,
            'no_hp' => $request->no_hp,
            'no_ktp' => $request->no_ktp,
            'gender' => $request->gender,
            'pendidikan' => $request->pendidikan,
            'alamat' => $request->alamat


        ]);
        $response = ['pegawai' => $pegawai];
        return response([
            'data' => $response,
            'message' => 'Berhasil mengisi biodata',
            'status' => true,
            'isi' => 'berhasil',
            'success' => true,
        ]);
 


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
        
            // DB::table('pegawais')->where('id', $request->id)->update([
            //     'name' => $request->name,
            //     'id_jabatan' => $request->id_jabatan,
            //     'status' => $request->status
            // ]);

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Update Data Berhasil!',
            // ]);
            $validate = Validator::make($request->all(), [
                'jabatan' => 'required',
                'status' => 'required'
             ]);
    
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Update Data Gagal!',
                ]);
            } else {
                DB::table('pegawais')->where('id', $request->id)->update([
                    'jabatan' => $request->jabatan,
                    'status' => $request->status
                ]);
                DB::table('akunpegawai')->where('id', $request->id)->update([
                    'jabatan' => $request->jabatan,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Update Data Berhasil!',
                ]);
            }
        
    }
    public function updatedata(Request $request)
    {

            $validate = Validator::make($request->all(), [
                'nama_lengkap' => 'required',
                'pendidikan' => 'required',
                'no_hp' => 'required',
                'no_ktp' => 'required',
                'gender' => 'required',
                'alamat' => 'required',
             ]);
    
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Update Data Gagal!',
                ]);
            } else {
                $data = DB::table('pegawais')->where('id', Auth::user()->id)->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'pendidikan' => $request->pendidikan,
                    'no_hp' => $request->no_hp,
                    'no_ktp' => $request->no_ktp,
                    'gender' => $request->gender,
                    'alamat' => $request->alamat,
                ]);
                return response()->json([
                    'data' => $data,
                    'success' => true,
                    'message' => 'Update Data Berhasil!',
                ]);
            }
        
    }

    public function getprofile(Request $request){
        $profile = DataPegawai::where('id' ,Auth::user()->id)->get();
            return response([
                'data' => $profile,
                'message' => 'get data berhasil',
                'status' => true,
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
