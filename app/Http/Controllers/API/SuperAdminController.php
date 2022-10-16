<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\SendApprovement;
use App\Models\AkunPegawai;
use App\Models\DataPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    public function dashsuperadmin(){
        $data1 = DB::table('users')
        ->select('*')
        ->where('role','=','Admin')
        ->where('status','=', 'Diterima')
        ->count();
        $data2 = DB::table('users')
        ->select('*')
        ->where('role','=','Admin')
        ->where('status','=', 'Pending')
        ->count();
        $data3 = DB::table('users')
        ->select('*')
        ->where('role','=','Admin')
        ->where('status','=', 'Diterima')
        ->pluck('jumlah_karyawan')
        ->toArray();
        $jumlah = array_sum($data3);
        return response()->json([
            'success' => true,
            'diterima' => $data1,
            'pending' => $data2,
            'pegawai' => $jumlah,
            'message' => 'Get Data'
        ]);
    }
    public function tampilsuperadmin(){
        $pegawai = User::select('*')
        ->where('role', '=', 'Admin')
        ->latest()
        ->paginate(8);

        $data = $pegawai->makeHidden(['password']);
        $pegawai->data = $data;

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $pegawai
        ]);
    }
    public function approvesuperadmin(){
        $pegawai = User::select('*')
        ->where('role', '=', 'Admin')
        // ->where('status','!=','Nonaktif')
        ->latest()
        ->paginate(8);

        $data = $pegawai->makeHidden(['password']);
        $pegawai->data = $data;

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $pegawai
        ]);
    }
    public function superadmin(){
        $pegawai = User::
        where('id', Auth::user()->id)
        ->get();
        $data = $pegawai->makeHidden(['password']);

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $data
        ]);
    }
    public function approveakun(Request $request){
        $validate = Validator::make($request->all(), [
            'status' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            $email = User::where('id', $request->id)->first();
            $status =  User::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            $data = [
                'judul' => "Hasil Approvement Akun Perusahaan Anda",
                'hasil' => $request->status,
                'email' => $email->email
            ];
            Mail::to($email->email)->send(new SendApprovement($data));
            return response()->json([
                'data' => $request->status,
                'success' => true,
                'message' => 'Update Status!',
            ]);
        }
    }
    public function aktifakun(Request $request){
        $validate = Validator::make($request->all(), [
            'status' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            $email = User::where('id', $request->id)->first();
            User::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            $data = [
                'judul' => "Informasi Terkait Akun Perusahaan Anda",
                'hasil' => $request->status,
                'email' => $email->email
            ];
            Mail::to($email->email)->send(new SendApprovement($data));
            return response()->json([
                'data' => $request->status,
                'success' => true,
                'message' => 'Update Status!',
            ]);
        }
    }
    public function updateakun(Request $request){
        $validate = Validator::make($request->all(), [
            'status' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            $email = User::where('id', $request->id)->first();
            User::where('id', $request->id)->update([
                'status' => $request->status,
            ]);
            $data = [
                'judul' => "Informasi Terkait Akun Perusahaan Anda",
                'hasil' => $request->status,
                'email' => $email->email
            ];
            Mail::to($email->email)->send(new SendApprovement($data));
            return response()->json([
                'data' => $request->status,
                'success' => true,
                'message' => 'Update Status!',
            ]);
        }
    }
    public function hapusakun(Request $request, $id){
            $hapus = User::findOrFail($id);
            $detail = User::where('id',$id)->get();
            $hapus->delete();
            $data = [
                'judul' => "Informasi Terkait Akun Perusahaan Anda",
                'hasil' => "Hapus",
                'email' => $detail->email
            ];
            Mail::to($detail)->send(new SendApprovement($data));
            return response()->json([
                'data' => $detail->email,
                'success' => true,
                'message' => 'Update Status!',
            ]);
    }
    public function pegperusahaan($id){
        $datapegawai = User::where('id' ,$id)
        ->first();
        $idadmin = $datapegawai->id;
        $detpegawai = AkunPegawai::where('id_admin',$idadmin)->get();
        $count = $detpegawai->count();
        return response([
            'namapt' => $datapegawai->nama_perusahaan,
            'data' => $detpegawai,
            'message' => 'get data berhasil',
            'status' => true,
            'akunpeg' => $count
        ]);
    }
    
}
