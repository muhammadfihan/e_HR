<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\DataPegawai;
use App\Models\Pemberitahuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DateTime;
use DateTimeZone;

class CutiController extends Controller
{
    public function tampilcuti(){
        $cuti = DB::table('cuti')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->latest()
            ->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Get data berhasil',
            'data' => $cuti
        ]);
    }
    public function searchcuti($key)
    {
            $result = DB::table('cuti')
                ->select('*')
                ->where('cuti.id_admin', Auth::user()->id)
                ->where('email', 'like', '%' . $key . '%')
                ->orWhere('name', 'like', '%' . $key . '%')
                ->where('cuti.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(8);

            return $result;

    }
    public function searchcutipeg($key)
    {
            $result = DB::table('cuti')
                ->select('*')
                ->where('cuti.email', Auth::user()->email)
                ->where('jenis_cuti', 'like', '%' . $key . '%')
                ->where('cuti.email', Auth::user()->email)
                ->latest()
                ->paginate(10);

            return $result;

    }
    public function tampilcutip(){
        $cuti = DB::table('cuti')
            ->select('*')
            ->where('email', Auth::user()->email)
            ->latest()
            ->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Get data berhasil',
            'data' => $cuti
            ]);
    }
    public function tambahcuti(Request $request){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        // return $request->all();
     if($request->hasfile('bukti_cuti')){
        $filename = str_replace('','',$request->file('bukti_cuti')->getClientOriginalName());
        $request->file('bukti_cuti')->move(public_path('files'), $filename);

        $datetime1 = strtotime($request->input('tanggal_mulai'));
        $datetime2 = strtotime($request->input('tanggal_akhir'));
        $interval = $datetime2 - $datetime1;
        
        $jatah = DB::table('table_master_cuti_tahunan')->where('email', Auth::user()->email)->first();
        if($jatah->jumlah_cuti <= 0){
            return response()->json([
                'message' =>'Jatah Cuti Tahunan Telah Habis',
                'success' => false
    
                ]);    
        }
        $ct = DB::table('cuti')
        ->where('email', Auth::user()->email)
        ->where('status_cuti', 'Diproses')
        ->first();
        if($ct != null){
                return response()->json([
                    'success' => 15,
                    'message' => 'Menunggu pengajuan selanjutnya'
                ]);
        }
        $arraytanggal = explode(',', $tanggal);
        $sedangcuti = DB::table('cuti')->where('id_pegawai', Auth::user()->id)->where('status_cuti', 'Diterima')->whereJsonContains('list_tanggal',$arraytanggal)->get()->toArray();
        if($sedangcuti != null){
            return response()->json([
                'success' => 12,
                'message' => 'Cuti Sedang Berlangsung'
            ]);
        }

        if($interval/60/60/24 > $jatah->jumlah_cuti){
            return response()->json([
                'message' =>'Tidak Bisa Dikurangi',
                'success' => null
    
                ]);    
        }else{
            $user = DataPegawai::where('id', Auth::user()->id)->first();
            $listcuti = [];
            for ( $i = strtotime($request->input('tanggal_mulai')); $i <= strtotime($request->input('tanggal_akhir')); $i = $i + 86400 ) {
                $listcuti[] = date( 'Y-m-d', $i );
            }
            $cuti = Cuti::create([
                'id_admin' => Auth::user()->id_admin,
                'id_pegawai' => Auth::user()->id,
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'nama_lengkap' => $user->nama_lengkap,
                'no_pegawai' => $user->no_pegawai,
                'jumlah_hari' => $interval/60/60/24,
                'tanggal_cuti' => Carbon::now(),
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'list_tanggal' => json_encode($listcuti),
                'jenis_cuti' => $request->jenis_cuti,
                'keterangan' => $request->keterangan,
                'bukti_cuti' => $filename,
            ]);
            // $jumlah_hari = $cuti->jumlah_hari;
           
            // $total = $jatah->jatah_cuti - $jumlah_hari;
            // $hasil = DB::table('pegawais')->where('email', Auth::user()->email)->update([
            //     'jatah_cuti' => $total,
            // ]);
            $timezone = 'Asia/Jakarta'; 
            $date = new DateTime('now', new DateTimeZone($timezone)); 
            $tanggal = $date->format('Y-m-d');
            $localtime = $date->format('H:i:s');
            Pemberitahuan::create([
                'id_admin' => Auth::user()->id_admin,
                'email' => Auth::user()->email,
                'judul' => 'Pengajuan Cuti',
                'jenis' => 'Pengajuan Cuti',
                'status' => 'Menunggu Konfirmasi',
                'tanggal' => $tanggal,
                'jam' => $localtime
            ]);
            return response()->json([
                'data' => $cuti,
                'tes'   => $listcuti,
                'message' => 'Cuti successfully added',
                'success' => true,
                // 'cek' => explode(',', $hasilcuti),
                'tanggal' => $tanggal
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
            // $status =  DB::table('cuti')->where('id', $request->id)->update([
            //     'status_cuti' => $request->status_cuti,
            // ]);
            $status2 =  DB::table('cuti')->where('id', $request->id)->first();
            if($status2->status_cuti == "Diproses" ){
                $status =  DB::table('cuti')->where('id', $request->id)->update([
                    'status_cuti' => $request->status_cuti,
                ]);
                if($request->status_cuti == "Diterima"){
                    $tes = $status2->email;
                    $hari = $status2->jumlah_hari;
                    $update = DB::table('table_master_cuti_tahunan')->where('email','=', $tes)->first();
                    $jatah = $update->jumlah_cuti;
                    $hasil = $jatah - $hari;
                    $cutiterpakai = $update->cuti_terpakai + $hari;
                    $sisacuti = $jatah- $cutiterpakai;
                    $update2 = DB::table('table_master_cuti_tahunan')->where('email','=', $tes)->update([
                    'sisa_cuti' => $sisacuti,
                    'cuti_terpakai' => $cutiterpakai
                ]);
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id,
                    'email' => $status2->email,
                    'judul' => 'Approvement Cuti ',
                    'jenis' => 'Approvement',
                    'status' => 'Diterima',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                return response()->json([
                    'hasil' => $hasil,
                    'hasil2' => $update2,
                    'data' => $status,
                    'datacuti' => $status2,
                    'success' => true,
                    'message' => 'Diterima masih pengajuan awal!',
                ]);
                }else{
                    $timezone = 'Asia/Jakarta'; 
                    $date = new DateTime('now', new DateTimeZone($timezone)); 
                    $tanggal = $date->format('Y-m-d');
                    $localtime = $date->format('H:i:s');
                    Pemberitahuan::create([
                        'id_admin' => Auth::user()->id,
                        'email' => $status2->email,
                        'judul' => 'Approvement Cuti ',
                        'jenis' => 'Approvement',
                        'status' => 'Ditolak',
                        'tanggal' => $tanggal,
                        'jam' => $localtime
                    ]);
                    return response()->json([
                        'data' => $status,
                        'success' => true,
                        'message' => 'Ditolak pengajuan awal!',
                    ]);
                }
            }
            if($status2->status_cuti == "Ditolak" ){
                $status =  DB::table('cuti')->where('id', $request->id)->update([
                    'status_cuti' => $request->status_cuti,
                ]);
                if($request->status_cuti == "Diterima"){
                    $tes = $status2->email;
                    $hari = $status2->jumlah_hari;
                    $update = DB::table('table_master_cuti_tahunan')->where('email','=', $tes)->first();
                    $jatah = $update->jumlah_cuti;
                    $hasil = $jatah - $hari;
                    $cutiterpakai = $update->cuti_terpakai + $hari;
                    $sisacuti = $jatah- $cutiterpakai;
                    $update2 = DB::table('table_master_cuti_tahunan')->where('email','=', $tes)->update([
                        'sisa_cuti' => $sisacuti,
                        'cuti_terpakai' => $cutiterpakai
                    ]);
                    $timezone = 'Asia/Jakarta'; 
                    $date = new DateTime('now', new DateTimeZone($timezone)); 
                    $tanggal = $date->format('Y-m-d');
                    $localtime = $date->format('H:i:s');

                    $updatecuti = DB::table('absensipegawai')->where('id_admin', Auth::user()->id)
                    ->where('email', $status2->email)
                    ->where('tanggal', $tanggal)
                    ->update([
                        'keterangan' => 'Cuti'
                    ]);
                    Pemberitahuan::create([
                        'id_admin' => Auth::user()->id,
                        'email' => $status2->email,
                        'judul' => 'Approvement Cuti ',
                        'jenis' => 'Approvement',
                        'status' => 'Diterima',
                        'tanggal' => $tanggal,
                        'jam' => $localtime
                    ]);
                    return response()->json([
                        'hasil' => $hasil,
                        'hasil2' => $update2,
                        'data' => $status,
                        'updtecuti' => $updatecuti,
                        'success' => true,
                        'message' => 'Diterima Setelah Di Acc',
                    ]);
                }
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');

                $updtcuti = DB::table('absensipegawai')->where('id_admin', Auth::user()->id)
                    ->where('email', $status2->email)
                    ->where('tanggal', $tanggal)
                    ->where('keterangan', "Cuti")
                    ->update([
                        'keterangan' => 'Tidak Hadir'
                ]);

                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id,
                    'email' => $status2->email,
                    'judul' => 'Approvement Cuti ',
                    'jenis' => 'Approvement',
                    'status' => 'Ditolak',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                return response()->json([
                    'data' => $status,
                    'success' => true,
                    'updatecuti' => $updtcuti,
                    'message' => 'Ditolak setelah di acc',
                ]);
            }
            if($status2->status_cuti == "Diterima" ){
                $status =  DB::table('cuti')->where('id', $request->id)->update([
                    'status_cuti' => $request->status_cuti,
                ]);
                if($request->status_cuti == "Ditolak"){
                    $tes = $status2->email;
                    $hari = $status2->jumlah_hari;
                    $update = DB::table('table_master_cuti_tahunan')->where('email','=', $tes)->first();
                    $jatah = $update->jumlah_cuti;
                    $cutiterpakai = $update->cuti_terpakai - $hari;
                    $sisacuti = $update->sisa_cuti + $hari;
                    $update2 = DB::table('table_master_cuti_tahunan')->where('email','=', $tes)->update([
                        'sisa_cuti' => $sisacuti,
                        'cuti_terpakai' => $cutiterpakai
                    ]);
                    $timezone = 'Asia/Jakarta'; 
                    $date = new DateTime('now', new DateTimeZone($timezone)); 
                    $tanggal = $date->format('Y-m-d');
                    $localtime = $date->format('H:i:s');

                    $updtcuti2 = DB::table('absensipegawai')->where('id_admin', Auth::user()->id)
                    ->where('email', $status2->email)
                    ->where('tanggal', $tanggal)
                    ->where('keterangan', "Cuti")
                    ->update([
                        'keterangan' => 'Tidak Hadir'
                    ]);

                    Pemberitahuan::create([
                        'id_admin' => Auth::user()->id,
                        'email' => $status2->email,
                        'judul' => 'Approvement Cuti ',
                        'jenis' => 'Approvement',
                        'status' => 'Ditolak',
                        'tanggal' => $tanggal,
                        'jam' => $localtime
                    ]);
                    return response()->json([
                        'hasil2' => $update2,
                        'data' => $status,
                        'updatecuti' => $updtcuti2,
                        'success' => true,
                        'message' => 'Ditolak Setelah Diterima',
                    ]);
                }
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id,
                    'email' => $status2->email,
                    'judul' => 'Approvement Cuti ',
                    'jenis' => 'Approvement',
                    'status' => 'Diterima',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
                ]);
                return response()->json([
                    'data' => $status,
                    'success' => true,
                    'message' => 'Diterima setelah diterima',
                ]);
               
            }
           
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

                for ( $i = strtotime($request->input('tanggal_mulai')); $i <= strtotime($request->input('tanggal_akhir')); $i = $i + 86400 ) {
                    $listcuti[] = date( 'Y-m-d', $i );
                }
                $update = DB::table('cuti')->where('id', $request->id)->update([
                    'jumlah_hari' => $interval/60/60/24,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_akhir' => $request->tanggal_akhir,
                    'jenis_cuti' => $request->jenis_cuti,
                    'list_tanggal' => json_encode($listcuti),
                    'keterangan' => $request->keterangan,
                    'bukti_cuti' => $filename
                ]);
                $timezone = 'Asia/Jakarta'; 
                $date = new DateTime('now', new DateTimeZone($timezone)); 
                $tanggal = $date->format('Y-m-d');
                $localtime = $date->format('H:i:s');
                Pemberitahuan::create([
                    'id_admin' => Auth::user()->id_admin,
                    'email' => Auth::user()->email,
                    'judul' => 'Update Pengajuan Cuti ',
                    'jenis' => 'Pengajuan Cuti',
                    'status' => 'Berhasil',
                    'tanggal' => $tanggal,
                    'jam' => $localtime
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
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $localtime = $date->format('H:i:s');
        Pemberitahuan::create([
            'id_admin' => Auth::user()->id_admin,
            'email' => Auth::user()->email,
            'judul' => 'Hapus Pengajuan Cuti ',
            'jenis' => 'Pengajuan Cuti',
            'status' => 'Berhasil',
            'tanggal' => $tanggal,
            'jam' => $localtime
        ]);
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
