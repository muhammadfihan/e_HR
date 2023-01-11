<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\DataPegawai;
use App\Models\Pemberitahuan;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LaporanController extends Controller
{
    public function tampillaporan()
    {
        $laporan = DB::table('laporan')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->latest()
            ->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Get data berhasil',
            'data' => $laporan
        ]);
    }
    public function searchlaporan($key)
    {
            $result = DB::table('laporan')
                ->select('*')
                ->where('laporan.id_admin', Auth::user()->id)
                ->orWhere('email', 'like', '%' . $key . '%')
                ->orWhere('nama_lengkap', 'like', '%' . $key . '%')
                ->where('laporan.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(10);
            return $result;
    }
    public function tampillaporanpegawai()
    {
        $laporan = DB::table('laporan')
            ->select('*')
            ->where('email', Auth::user()->email)
            ->latest()
            ->paginate(8);
        return response()->json([
            'status' => true,
            'message' => 'Get data berhasil',
            'data' => $laporan
        ]);
    }
    public function searchlaporanpeg($key)
    {
            $result = DB::table('laporan')
                ->select('*')
                ->where('laporan.email', Auth::user()->email)
                ->where('tanggal_laporan', 'like', '%' . $key . '%')
                ->orWhere('status_laporan', 'like', '%' . $key . '%')
                ->where('laporan.email', Auth::user()->email)
                ->latest()
                ->paginate(8);
            return $result;
    }

    public function tambahlaporan(Request $request){
     if($request->hasfile('lampiran')){
        $filename = str_replace('','',$request->file('lampiran')->getClientOriginalName());
        $request->file('lampiran')->move(public_path('files'), $filename);
        
        $user = DataPegawai::where('id', Auth::user()->id)->first();
        $laporan = Laporan::create([
            'id' => Auth::user()->id,
            'id_admin' => Auth::user()->id_admin,
            'email' => Auth::user()->email,
            'nama_lengkap' => $user->nama_lengkap,
            'no_pegawai' => $user->no_pegawai,
            'tanggal_laporan' => $request->tanggal_laporan,
            'id_jabatan' => $user->id_jabatan,
            'deskripsi' => $request->deskripsi,
            'lampiran' => $filename,
        ]);
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        Pemberitahuan::create([
            'id_admin' => Auth::user()->id_admin,
            'email' => Auth::user()->email,
            'judul' => 'Pengajuan laporan ',
            'jenis' => 'Laporan',
            'status' => 'Menunggu Konfirmasi',
            'tanggal' => $tanggal,
            'jam' => $localtime
        ]);
        $laporan->save();
        $success = true;
        return response()->json([
            'data' => $laporan,
            'message' =>'Jabatan successfully added',
            'success' => $success

            ]);    
    }
    }
    public function confirmlaporan(Request $request){
        $validate = Validator::make($request->all(), [
            'status_laporan' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            $status =  DB::table('laporan')->where('id', $request->id)->update([
                'status_laporan' => $request->status_laporan,
            ]);
            $email = DB::table('laporan')->where('id', $request->id)->first();
            $timezone = 'Asia/Jakarta'; 
            $date = new DateTime('now', new DateTimeZone($timezone)); 
            $tanggal = $date->format('Y-m-d');
            $localtime = $date->format('H:i:s');
            Pemberitahuan::create([
                'id_admin' => Auth::user()->id,
                'email' => $email->email,
                'judul' => 'Approvement Laporan',
                'jenis' => 'Laporan',
                'status' => $request->input('status_laporan'),
                'tanggal' => $tanggal,
                'jam' => $localtime
            ]);
            return response()->json([
                'data' => $status,
                'success' => true,
                'message' => 'Update Status Berhasil!',
            ]);
        }
    }
    public function updatelaporan(Request $request){
        
        $validate = Validator::make($request->all(), [
            'tanggal_laporan' => 'required',
            'deskripsi' => 'required',
            'lampiran' => 'required',
         ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            if($request->hasfile('lampiran')){
                $filename = str_replace('','',$request->file('lampiran')->getClientOriginalName());
                $request->file('lampiran')->move(public_path('files'), $filename);

                $update = DB::table('laporan')->where('id', $request->id)->update([
                    'tanggal_laporan' => $request->tanggal_laporan,
                    'deskripsi' => $request->deskripsi,
                    'lampiran' => $filename
                ]);
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id_admin,
                    'email' => Auth::user()->email,
                    'judul' => 'Update Pengajuan Laporan',
                    'jenis' => 'Laporan',
                    'status' => 'Berhasil',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                return response()->json([
                    'data' => $update,
                    'success' => true,
                    'message' => 'Update Laporan Berhasil!',
                ]);
            }
            
        }

    }
    public function hapuslaporan(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        Pemberitahuan::create([
            'id_admin' => Auth::user()->id_admin,
            'email' => Auth::user()->email,
            'judul' => 'Menghapus Laporan',
            'jenis' => 'Laporan',
            'status' => 'Berhasil',
            'tanggal' => $tanggal,
            'jam' => $localtime
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
    public function detaillaporan($id)
    {
       $laporan = DB::table('laporan')
       ->where('id' ,$id)
       ->get();
       return response([
           'data' => $laporan,
           'message' => 'get data berhasil',
           'status' => true,
       ]);
    }
}
