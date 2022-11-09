<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lembur;
use App\Models\DataPegawai;
use App\Models\Pemberitahuan;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LemburController extends Controller
{
    public function tampillembur()
    {
        $lembur = DB::table('lembur')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->latest()
            ->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Get data berhasil',
            'data' => $lembur
        ]);
    }  
    public function searchlembur($key)
    {
            $result = DB::table('lembur')
                ->select('*')
                ->where('lembur.id_admin', Auth::user()->id)
                ->where('email', 'like', '%' . $key . '%')
                ->orWhere('tanggal_lembur', 'like', '%' . $key . '%')
                ->orWhere('nama_lengkap', 'like', '%' . $key . '%')
                ->orWhere('no_pegawai', 'like', '%' . $key . '%')
                ->orWhere('status_lembur', 'like', '%' . $key . '%')
                ->where('lembur.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(10);

            return $result;

    }
    public function searchlemburpeg($key)
    {
            $result = DB::table('lembur')
                ->select('*')
                ->where('lembur.email', Auth::user()->email)
                ->orWhere('tanggal_lembur', 'like', '%' . $key . '%')
                ->orWhere('status_lembur', 'like', '%' . $key . '%')
                ->where('lembur.email', Auth::user()->email)
                ->latest()
                ->paginate(10);

            return $result;

    }
    public function tampillemburpegawai()
    {
        $lembur = DB::table('lembur')
            ->select('*')
            ->where('email', Auth::user()->email)
            ->latest()
            ->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Get data berhasil',
            'data' => $lembur
        ]);
    }  
    public function tambahlembur(Request $request){
        if($request->hasfile('buktilembur')){
            $filename = str_replace('','',$request->file('buktilembur')->getClientOriginalName());
            $request->file('buktilembur')->move(public_path('files'), $filename);
            $user = DataPegawai::where('id', Auth::user()->id)->first();
            $lembur = Lembur::create([
                'id' => Auth::user()->id,
                'id_admin' => Auth::user()->id_admin,
                'email' => Auth::user()->email,
                'tanggal_lembur' => $request->tanggal_lembur,
                'nama_lengkap' => $user->nama_lengkap,
                'no_pegawai' => $user->no_pegawai,
                'jammulai' => $request->jammulai,
                'jamselesai' => $request->jamselesai,
                'aktifitas' => $request->aktifitas,
                'buktilembur' => $filename,
            ]);
            $timezone = 'Asia/Jakarta'; 
            $date = new DateTime('now', new DateTimeZone($timezone)); 
            $tanggal = $date->format('Y-m-d');
            $localtime = $date->format('H:i:s');
            Pemberitahuan::create([
                'id_admin' => Auth::user()->id_admin,
                'email' => Auth::user()->email,
                'judul' => 'Pengajuan Lembur',
                'jenis' => 'Lembur',
                'status' => 'Menunggu Disetujui',
                'tanggal' => $tanggal,
                'jam' => $localtime
            ]);
            $lembur->save();
            $success = true;
            return response()->json([
                'data' => $lembur,
                'message' =>'Izin successfully added',
                'success' => $success
    
                ]);
        }
       }
    public function updatelembur(Request $request){
        
        $validate = Validator::make($request->all(), [
            'tanggal_lembur' => 'required',
            'jammulai' => 'required',
            'jamselesai' => 'required',
            'aktifitas' => 'required',
            'buktilembur' => 'required',
         ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            if($request->hasfile('buktilembur')){
                $filename = str_replace('','',$request->file('buktilembur')->getClientOriginalName());
                $request->file('buktilembur')->move(public_path('files'), $filename);

                $update = DB::table('lembur')->where('id', $request->id)->update([
                    'tanggal_lembur' => $request->tanggal_lembur,
                    'jammulai' => $request->jammulai,
                    'jamselesai' => $request->jamselesai,
                    'aktifitas' => $request->aktifitas,
                    'buktilembur' => $filename
                ]);
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id_admin,
                    'email' => Auth::user()->email,
                    'judul' => 'Pengajuan Lembur',
                    'jenis' => 'Lembur',
                    'status' => 'Menunggu Disetujui',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                return response()->json([
                    'data' => $update,
                    'success' => true,
                    'message' => 'Update Lembur Berhasil!',
                ]);
            }
            
        }

    }
    public function confirmlembur(Request $request){
        $validate = Validator::make($request->all(), [
            'status_lembur' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            $status =  DB::table('lembur')->where('id', $request->id)->update([
                'status_lembur' => $request->status_lembur,
            ]);
            $email = DB::table('lembur')->where('id', $request->id)->first();
            $timezone = 'Asia/Jakarta'; 
            $date = new DateTime('now', new DateTimeZone($timezone)); 
            $tanggal = $date->format('Y-m-d');
            $localtime = $date->format('H:i:s');
            Pemberitahuan::create([
                'id_admin' => Auth::user()->id,
                'email' => $email->email,
                'judul' => 'Approvement Lembur',
                'jenis' => 'Lembur',
                'status' => $request->input('status_lembur'),
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
    public function hapuslembur(Request $request, $id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->delete();
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        Pemberitahuan::create([
            'id_admin' => Auth::user()->id_admin,
            'email' => Auth::user()->email,
            'judul' => 'Hapus Pengajuan Lembur',
            'jenis' => 'Lembur',
            'status' => 'Berhasil',
            'tanggal' => $tanggal,
            'jam' => $localtime
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
    public function detaillembur($id)
    {
       $lembur = DB::table('lembur')
       ->where('id' ,$id)
       ->get();
       return response([
           'data' => $lembur,
           'message' => 'get data berhasil',
           'status' => true,
       ]);
    }
       
}
