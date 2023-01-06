<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DataPegawai;
use App\Models\Absensi;
use App\Models\ReqAbsen;
use Illuminate\Support\Facades\Validator;

class ReqAbsenController extends Controller
{
    public function allreq(){
        $reqabsen = DB::table('reqabsen')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->paginate(10);
    return response([
        'data' => $reqabsen,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function searchreqabsen($key)
    {
            $result = DB::table('reqabsen')
                ->select('*')
                ->where('name', 'like', '%' . $key . '%')
                ->orWhere('name', 'like', '%' . $key . '%')
                ->orWhere('nama_lengkap', 'like', '%' . $key . '%')
                ->orWhere('email', 'like', '%' . $key . '%')
                ->orWhere('alasan', 'like', '%' . $key . '%')
                ->orWhere('no_pegawai', 'like', '%' . $key . '%')
                ->orWhere('status_req', 'like', '%' . $key . '%')
                ->orWhere('tanggal_req', 'like', '%' . $key . '%')
                ->latest()
                ->paginate(10);

            return $result;

    }
    public function searchreqabsenpeg($key)
    {
            $result = DB::table('reqabsen')
                ->select('*')
                ->where('reqabsen.email', Auth::user()->email)
                ->orWhere('tanggal_req', 'like', '%' . $key . '%')
                ->orWhere('alasan', 'like', '%' . $key . '%')
                ->orWhere('status_req', 'like', '%' . $key . '%')
                ->where('reqabsen.email', Auth::user()->email)
                ->latest()
                ->paginate(10);

            return $result;

    }

    public function allreqpegawai(){
        $reqabsen = DB::table('reqabsen')
        ->select('*')
        ->where('email', Auth::user()->email)
        ->latest()
        ->paginate(10);
    return response([
        'data' => $reqabsen,
        'message' => 'get data berhasil',
        'status' => true
    ]);

    }
    public function ajukanreqabsen(Request $request){
        if($request->hasfile('bukti_pendukung')){
            $file_path = "files/";
            $filename = str_replace('','',$request->file('bukti_pendukung')->getClientOriginalName());
            $request->file('bukti_pendukung')->move($file_path, $filename);

            $user = DataPegawai::where('id', Auth::user()->id)->first();
            $reqabsen = ReqAbsen::create([
                'id_admin' => Auth::user()->id_admin,
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
                'nama_lengkap' => $user->nama_lengkap,
                'no_pegawai' => $user->no_pegawai,
                'tanggal_req' => $request->tanggal_req,
                'alasan' => $request->alasan,
                'bukti_pendukung' => $filename,
            ]);
            $reqabsen->save();
            $success = true;
            $timezone = 'Asia/Jakarta'; 
            $date = new DateTime('now', new DateTimeZone($timezone)); 
            $tanggal = $date->format('Y-m-d');
            $localtime = $date->format('H:i:s');
            Pemberitahuan::create([
                'id_admin' => Auth::user()->id_admin,
                'email' => Auth::user()->email,
                'judul' => 'Pengajuan Request Attendance',
                'jenis' => 'Request Absensi',
                'status' => 'Menunggu Dikonfirmasi',
                'tanggal' => $tanggal,
                'jam' => $localtime
            ]);
            return response()->json([
                'data' => $reqabsen,
                'message' =>'Izin successfully added',
                'success' => $success
    
                ]);
        }

    }
    
    public function approvereqabsen(Request $request){
        $validate = Validator::make($request->all(), [
            'status_req' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            $status2 =  DB::table('reqabsen')->where('id', $request->id)->first();

            if($status2->status_req == "Diproses"){
                $status =  DB::table('reqabsen')->where('id', $request->id)->update([
                    'status_req' => $request->status_req,
                ]);
                if($request->status_req == "Ditolak"){
                    $timezone = 'Asia/Jakarta'; 
                    $date = new DateTime('now', new DateTimeZone($timezone)); 
                    $tanggal = $date->format('Y-m-d');
                    $localtime = $date->format('H:i:s');
                    Pemberitahuan::create([
                        'id_admin' => Auth::user()->id,
                        'email' => $status2->email,
                        'judul' => 'Approvement Request Attendance',
                        'jenis' => 'Request Absensi',
                        'status' => 'Ditolak',
                        'tanggal' => $tanggal,
                        'jam' => $localtime
                    ]);
                    return response()->json([
                        'success' => true,
                        'message' => 'Ditolak pengajuan awal',
                    ]);
                }
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id,
                    'email' => $status2->email,
                    'judul' => 'Approvement Request Attendance',
                    'jenis' => 'Request Absensi',
                    'status' => 'Diterima',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                $diterima = DB::table('absensipegawai')->where('email', $status2->email)->where('tanggal', $status2->tanggal_req)->update([
                    'keterangan' => 'Request Absen'
                ]);

                return response()->json([
                    'data' => $status,
                    'update' => $diterima,
                    'success' => true,
                    'message' => 'Update Diterima pengajuan awal!',
                ]);
            }
            if($status2->status_req == "Diterima"){
                $status =  DB::table('reqabsen')->where('id', $request->id)->update([
                    'status_req' => $request->status_req,
                ]);
                if($request->status_req == "Ditolak"){
                    $timezone = 'Asia/Jakarta'; 
                    $date = new DateTime('now', new DateTimeZone($timezone)); 
                    $tanggal = $date->format('Y-m-d');
                    $localtime = $date->format('H:i:s');
                    Pemberitahuan::create([
                        'id_admin' => Auth::user()->id,
                        'email' => $status2->email,
                        'judul' => 'Approvement Request Attendance',
                        'jenis' => 'Request Absensi',
                        'status' => 'Ditolak',
                        'tanggal' => $tanggal,
                        'jam' => $localtime
                    ]);
                    $ditolak = DB::table('absensipegawai')->where('email', $status2->email)->where('tanggal', $status2->tanggal_req)->update([
                        'keterangan' => 'Tidak Hadir'
                    ]);
                    return response()->json([
                        'success' => true,
                        'data' => $ditolak,
                        'message' => 'Ditolak setelah diterima',
                    ]);
                }
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id,
                    'email' => $status2->email,
                    'judul' => 'Approvement Request Attendance',
                    'jenis' => 'Request Absensi',
                    'status' => 'Diterima',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Diterima setelah diterima',
                ]);
            }
            if($status2->status_req == "Ditolak"){
                $status =  DB::table('reqabsen')->where('id', $request->id)->update([
                    'status_req' => $request->status_req,
                ]);
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id,
                    'email' => $status2->email,
                    'judul' => 'Approvement Request Attendance',
                    'jenis' => 'Request Absensi',
                    'status' => 'Diterima',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                if($request->status_req == "Diterima"){
                    $diterima2 = DB::table('absensipegawai')->where('email', $status2->email)->where('tanggal', $status2->tanggal_req)->update([
                        'keterangan' => 'Request Absen'
                    ]);
                        return response()->json([
                            'data' => $status,
                            'data2' => $diterima2,
                            'success' => true,
                            'message' => 'Update Diterima Setelah Ditolak!',
                        ]);
                }
            }
            $timezone = 'Asia/Jakarta'; 
            $date = new DateTime('now', new DateTimeZone($timezone)); 
            $tanggal = $date->format('Y-m-d');
            $localtime = $date->format('H:i:s');
            Pemberitahuan::create([
                'id_admin' => Auth::user()->id,
                'email' => $status2->email,
                'judul' => 'Approvement Request Attendance',
                'jenis' => 'Request Absensi',
                'status' => 'Ditolak',
                'tanggal' => $tanggal,
                'jam' => $localtime
            ]);
            return response()->json([
                'data' => $status,
                'success' => true,
                'message' => 'Update Ditolak Setelah Ditolak!',
            ]);

        }
    }
    public function updatereqabsen(Request $request){
        
        $validate = Validator::make($request->all(), [
            'tanggal_req' => 'required',
            'alasan' => 'required',
            'bukti_pendukung' => 'required',
         ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            if($request->hasfile('bukti_pendukung')){
                $filename = str_replace('','',$request->file('bukti_pendukung')->getClientOriginalName());
                $request->file('bukti_pendukung')->move(public_path('files'), $filename);

                $update = DB::table('reqabsen')->where('id', $request->id)->update([
                    'tanggal_req' => $request->tanggal_req,
                    'alasan' => $request->alasan,
                    'bukti_pendukung' => $filename
                ]);
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id_admin,
                    'email' => Auth::user()->email,
                    'judul' => 'Update Pengajuan Request Attendance',
                    'jenis' => 'Request Absensi',
                    'status' => 'Berhasil',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                return response()->json([
                    'data' => $update,
                    'success' => true,
                    'message' => 'Update Req Attendance Berhasil!',
                ]);
            }
            
        }

    }
    public function hapusreqabsen($uid){
        $data = ReqAbsen::findOrFail($uid);
        $data->delete();
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        Pemberitahuan::create([
            'id_admin' => Auth::user()->id_admin,
            'email' => Auth::user()->email,
            'judul' => 'Hapus Request Attendance',
            'jenis' => 'Request Absensi',
            'status' => 'Berhasil',
            'tanggal' => $tanggal,
            'jam' => $localtime
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }

    public function listreq(){
        $list = ReqAbsen::where('email', Auth::user()->email)
                ->where('status_req', '=', 'Diterima')
                ->get();
        $list2 = ReqAbsen::where('email', Auth::user()->email)
                ->where('status_req', '=', 'Diterima')
                ->count();
        return response()->json([
            'data' => $list,
            'jmlh' => $list2,
            'success' => true,
            'message' => 'Get Data Berhasil'
        ]);
    }

    public function newreq(){
        $list = Absensi::where('email', Auth::user()->email)
                ->where('keterangan', 'Tidak Hadir')
                ->get();

        return response()->json([
            'data' => $list,
            'success' => true,
            'message' => 'Get Data Berhasil'
        ]);
    }
}
