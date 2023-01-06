<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\DataPegawai;
use App\Models\Izin;
use App\Models\Pemberitahuan;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IzinController extends Controller
{
    public function allizin(){
        $izin = DB::table('izin')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->paginate(10);
    return response([
        'data' => $izin,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function searchizin($key)
    {
            $result = DB::table('izin')
                ->select('*')
                ->where('izin.id_admin', Auth::user()->id)
                ->where('name', 'like', '%' . $key . '%')
                ->orWhere('name', 'like', '%' . $key . '%')
                ->orWhere('nama_lengkap', 'like', '%' . $key . '%')
                ->orWhere('email', 'like', '%' . $key . '%')
                ->orWhere('no_pegawai', 'like', '%' . $key . '%')
                ->orWhere('jenis_izin', 'like', '%' . $key . '%')
                ->orWhere('status_izin', 'like', '%' . $key . '%')
                ->orWhere('tanggal', 'like', '%' . $key . '%')
                ->where('izin.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(10);

            return $result;

    }
    public function searchizinpeg($key)
    {
            $result = DB::table('izin')
                ->select('*')
                ->where('izin.email', Auth::user()->email)
                ->where('tanggal', 'like', '%' . $key . '%')
                ->orWhere('jenis_izin', 'like', '%' . $key . '%')
                ->orWhere('status_izin', 'like', '%' . $key . '%')
                ->where('izin.email', Auth::user()->email)
                ->latest()
                ->paginate(10);

            return $result;

    }

    public function allizinpegawai(){
        $izin = DB::table('izin')->select('*')
        ->where('email', Auth::user()->email)
        ->latest()
        ->paginate(10);
    return response([
        'data' => $izin,
        'message' => 'get data berhasil',
        'status' => true
    ]);

    }

    public function ajukanizin(Request $request){
        if($request->hasfile('bukti')){
            $file_path = "files/";
            $filename = str_replace('','',$request->file('bukti')->getClientOriginalName());
            $request->file('bukti')->move($file_path, $filename);
            $user = DataPegawai::where('id', Auth::user()->id)->first();
            $cekhari = DB::table('harikerja')->where('id_admin', Auth::user()->id_admin)->first();
            $cekizin = $request->input('tanggal');
            $cek = Carbon::parse($cekizin)->locale('id')->dayName;
            if(str_contains($cekhari->hari_kerja,$cek)){
                $ajukanizin = Izin::create([
                    'id_admin' => Auth::user()->id_admin,
                    'id_pegawai' => Auth::user()->id,
                    'email' => Auth::user()->email,
                    'name' => Auth::user()->name,
                    'nama_lengkap' => $user->nama_lengkap,
                    'no_pegawai' => $user->no_pegawai,
                    'tanggal' => $request->tanggal,
                    'jenis_izin' => $request->jenis_izin,
                    'bukti' => $filename,
                ]);
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id_admin,
                    'email' => Auth::user()->email,
                    'judul' => 'Pengajuan Izin ',
                    'jenis' => 'Pengajuan',
                    'status' => 'Belum Dikonfirmasi',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                $ajukanizin->save();
                $success = true;
                return response()->json([
                    'data' => $ajukanizin,
                    'message' =>'Izin successfully added',
                    'success' => $success
        
                    ]);   
            }else{
                return response()->json([
                    'success' => false,
                    'message' =>'Tanggal Tersebut bukan hari kerja',
                    ]);   
            }
        }

       
    }

    public function approveizin(Request $request){
        $validate = Validator::make($request->all(), [
            'status_izin' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            $user =  DB::table('izin')->where('id', $request->id)->first();
            $status =  DB::table('izin')->where('id', $request->id)->update([
                'status_izin' => $request->status_izin,
            ]);
            $timezone = 'Asia/Jakarta'; 
            $date = new DateTime('now', new DateTimeZone($timezone)); 
            $tanggal = $date->format('Y-m-d');
            $localtime = $date->format('H:i:s');
            Pemberitahuan::create([
                'id_admin' => Auth::user()->id,
                'email' => $user->email,
                'judul' => 'Approvement Izin ',
                'jenis' => 'Approvement',
                'status' => $request->input('status_izin'),
                'tanggal' => $tanggal,
                'jam' => $localtime
            ]);
            $pengecekan = DB::table('absensipegawai')->where('email', $user->email)->where('tanggal', $user->tanggal)->first();
            if($pengecekan == null){
                $buatizin = Absensi::create([
                    'id' => $user->id_pegawai,
                    'name' => $user->name,
                    'id_admin' => $user->id_admin,
                    'email' => $user->email,
                    'nama_lengkap' => $user->nama_lengkap,
                    'tanggal' => $user->tanggal,
                    'keterangan' => "Izin",
                    'created_at' => $tanggal
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Buat Absen Izin',
                    'data' => $buatizin
                ]);
            }else{
                if($request->status_izin == 'Ditolak'){
                    $cekizin = DB::table('absensipegawai')->where('email', $user->email)->where('tanggal', $user->tanggal)->first();
                    $jamkerja = DB::table('harikerja')->where('id_admin',Auth::user()->id)->first();
                    if($cekizin->jam_masuk != null){
                        if($cekizin->jam_masuk > $jamkerja->jam_masuk){
                            $update = DB::table('absensipegawai')->where('email', $user->email)->where('tanggal', $user->tanggal)
                            ->update([
                                'keterangan' => 'Terlambat'
                            ]);
                            return response()->json([
                                'success' => true,
                                'message' => 'Terlambat!',
                            ]);
                        }if($cekizin->jam_masuk < $jamkerja->jam_masuk){
                            $update = DB::table('absensipegawai')->where('email', $user->email)->where('tanggal', $user->tanggal)
                            ->update([
                                'keterangan' => 'On Time'
                            ]);
                            return response()->json([
                                'success' => true,
                                'message' => 'On Time!',
                            ]);
                        }
                    }
                    $update1 = DB::table('absensipegawai')->where('email', $user->email)->where('tanggal', $user->tanggal)
                    ->update([
                        'keterangan' => 'Tidak Hadir'
                    ]);
                    return response()->json([
                        'data' => $update1,
                        'success' => true,
                        'message' => 'Ditolak!',
                    ]);
                } if($request->status_izin == 'Diterima'){
                    $update = DB::table('absensipegawai')->where('email', $user->email)->where('tanggal', $user->tanggal)
                        ->update([
                            'keterangan' => 'Izin'
                        ]);
                        return response()->json([
                            'data' => $update,
                            'success' => true,
                            'message' => 'Diterima!',
                        ]);
                }
                return response()->json([
                    'data' => $status,
                    'success' => true,
                    'message' => 'Update Status Berhasil!',
                ]);
            }

        }
    }

    public function updateizin(Request $request){
        
        $validate = Validator::make($request->all(), [
            'tanggal' => 'required',
            'jenis_izin' => 'required',
            'bukti' => 'required',
         ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            if($request->hasfile('bukti')){
                $filename = str_replace('','',$request->file('bukti')->getClientOriginalName());
                $request->file('bukti')->move(public_path('files'), $filename);
                $cekhari = DB::table('harikerja')->where('id_admin', Auth::user()->id_admin)->first();
                $cekizin = $request->input('tanggal');
                $cek = Carbon::parse($cekizin)->locale('id')->dayName;
                if (str_contains($cekhari->hari_kerja, $cek)) {
                    $update = DB::table('izin')->where('id', $request->id)->update([
                        'tanggal' => $request->tanggal,
                        'jenis_izin' => $request->jenis_izin,
                        'bukti' => $filename
                    ]);
                    $timezone = 'Asia/Jakarta'; 
                    $date = new DateTime('now', new DateTimeZone($timezone)); 
                    $tanggal = $date->format('Y-m-d');
                    $localtime = $date->format('H:i:s');
                    Pemberitahuan::create([
                        'id_admin' => Auth::user()->id,
                        'email' => Auth::user()->email,
                        'judul' => 'Update Pengajuan Izin ',
                        'jenis' => 'Pengajuan',
                        'status' => 'Update Berhasil',
                        'tanggal' => $tanggal,
                        'jam' => $localtime
                    ]);
                    return response()->json([
                        'data' => $update,
                        'success' => true,
                        'message' => 'Update Izin Berhasil!',
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Bukan Hari Kerja ',
                    ]);
                }   
            }
            
        }

    }

    public function hapusizin($id){
        $data = Izin::findOrFail($id);
        $data->delete();
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        Pemberitahuan::create([
            'id_admin' => Auth::user()->id,
            'email' => Auth::user()->email,
            'judul' => 'Approvement Izin ',
            'jenis' => 'Approvement',
            'status' => 'Berhasil',
            'tanggal' => $tanggal,
            'jam' => $localtime
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
}
