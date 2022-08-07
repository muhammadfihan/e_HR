<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\DataPegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DateTime;

class CutiController extends Controller
{
    public function tampilcuti(){
        $cuti = DB::table('cuti')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Get data berhasil',
            'data' => $cuti
        ]);
        }
    public function tampilcutip(){
        $cuti = DB::table('cuti')
            ->select('*')
            ->where('email', Auth::user()->email)
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Get data berhasil',
            'data' => $cuti
            ]);
            }
    public function tambahcuti(Request $request){
        // return $request->all();
     if($request->hasfile('bukti_cuti')){
        $filename = str_replace('','',$request->file('bukti_cuti')->getClientOriginalName());
        $request->file('bukti_cuti')->move(public_path('files'), $filename);

        $datetime1 = strtotime($request->input('tanggal_mulai'));
        $datetime2 = strtotime($request->input('tanggal_akhir'));
        $interval = $datetime2 - $datetime1;
        
        $jatah = DB::table('pegawais')->where('email', Auth::user()->email)->first();
        if($jatah->jatah_cuti <= 0){
            return response()->json([
                'message' =>'Jatah Cuti Tahunan Telah Habis',
                'success' => false
    
                ]);    
        };
        if($interval/60/60/24 > $jatah->jatah_cuti){
            return response()->json([
                'message' =>'Tidak Bisa Dikurangi',
                'success' => null
    
                ]);    
        }else{
            $user = DataPegawai::where('id', Auth::user()->id)->first();
            $cuti = Cuti::create([
                'id_admin' => Auth::user()->id_admin,
                'email' => Auth::user()->email,
                'nama_lengkap' => $user->nama_lengkap,
                'no_pegawai' => $user->no_pegawai,
                'jumlah_hari' => $interval/60/60/24,
                'tanggal_cuti' => Carbon::now(),
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'jenis_cuti' => $request->jenis_cuti,
                'keterangan' => $request->keterangan,
                'bukti_cuti' => $filename,
            ]);
            $jumlah_hari = $cuti->jumlah_hari;
           
            $total = $jatah->jatah_cuti - $jumlah_hari;
            $hasil = DB::table('pegawais')->where('email', Auth::user()->email)->update([
                'jatah_cuti' => $total,
            ]);
            return response()->json([
                'data' => $cuti,
                'jatah' => $hasil,
                'message' =>'Jabatan successfully added',
                'success' => true
    
                ]);  
        }
         
    }
    }
    public function confirmcuti(Request $request){
        $validate = Validator::make($request->all(), [
            'status_cuti' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            $status =  DB::table('cuti')->where('id', $request->id)->update([
                'status_cuti' => $request->status_cuti,
            ]);

            return response()->json([
                'data' => $status,
                'success' => true,
                'message' => 'Update Status Berhasil!',
            ]);
        }
    }
    public function updatecuti(Request $request){
        
        $validate = Validator::make($request->all(), [
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'jenis_cuti' => 'required',
            'keterangan' => 'required',
            'bukti_cuti' => 'required',
         ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            if($request->hasfile('bukti_cuti')){
                $filename = str_replace('','',$request->file('bukti_cuti')->getClientOriginalName());
                $request->file('bukti_cuti')->move(public_path('files'), $filename);
                
                $datetime1 = strtotime($request->input('tanggal_mulai'));
                $datetime2 = strtotime($request->input('tanggal_akhir'));
                $interval = $datetime2 - $datetime1;

                $update = DB::table('cuti')->where('id', $request->id)->update([
                    'jumlah_hari' => $interval/60/60/24,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_akhir' => $request->tanggal_akhir,
                    'jenis_cuti' => $request->jenis_cuti,
                    'keterangan' => $request->keterangan,
                    'bukti_cuti' => $filename
                ]);
    
                return response()->json([
                    'data' => $update,
                    'success' => true,
                    'message' => 'Update Cuti Berhasil!',
                ]);
            }
            
        }

    }
    public function hapuscuti(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);
        $cuti->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
    public function detailcuti($id)
    {
       $cuti = DB::table('cuti')
       ->where('id' ,$id)
       ->get();
       return response([
           'data' => $cuti,
           'message' => 'get data berhasil',
           'status' => true,
       ]);
    }
}
