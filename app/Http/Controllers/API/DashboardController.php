<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AkunPegawai;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardpeg(){
        $totaljob = DB::table('job')
            ->where('email_pegawai', Auth::user()->email)
            ->count();
        $completejob = DB::table('job')
            ->where('email_pegawai', Auth::user()->email)
            ->where('status', 'Complete')
            ->count();
        $totalgaji = DB::table('riwayatgaji')
        ->where('email', Auth::user()->email)
        ->where('status', 'Cair')
        ->pluck('gaji_bersih')
        ->toArray();
        $total = array_sum($totalgaji);
        return response()->json([
            'totaljob' => $totaljob,
            'complete' => $completejob,
            'totalgaji' => $total
        ]);

    }
    public function useractive(){
        $akun = AkunPegawai::select('*')
            ->where('id_admin', Auth::user()->id)
            ->get();

        return response()->json([
                'success' => true,
                'data' => $akun->makeHidden('password'),
                'message' => 'Get Data'
            ]);
    }
    public function dashlaporan(){
        $now = Carbon::now()->format('Y-m-d');
        $data = DB::table('laporan')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('tanggal_laporan', $now)
        ->count();

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Get Data'
        ]);
    }
    public function dashakunpegawai(){
        $data = DB::table('akunpegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('status','=', 'Aktif')
        ->count();
        $data2 = DB::table('akunpegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('status','=', 'Tidak Aktif')
        ->count();
        $data3 = DB::table('akunpegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->count();
        $data4 = DB::table('users')
        ->select('*')
        ->where('id', Auth::user()->id)
        ->first();
        return response()->json([
            'success' => true,
            'aktif' => $data,
            'tidak' => $data2,
            'semua' => $data3,
            'pegawai' => $data4->jumlah_karyawan,
            'message' => 'Get Data'
        ]);
    }
    public function dashapprovement(){
        $data1 = DB::table('izin')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('status_izin','=', 'Diproses')
        ->count();

        $data2 = DB::table('lembur')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('status_lembur','=', 'Diproses')
        ->count();

        $data3 = DB::table('reqabsen')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('status_req','=', 'Diproses')
        ->count();

        $data4 = DB::table('cuti')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('status_cuti','=', 'Diproses')
        ->count();

        $data = $data1 + $data2 + $data3 + $data4;

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Get Data'
        ]);
    }
    public function dashgaji(){
        $data = DB::table('penggajian')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('status','=', 'Belum Diambil')
        ->count();

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Get Data'
        ]);
    }
    public function pemberitahuan(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $data = DB::table('pemberitahuan')->where('email',Auth::user()->email)
                ->where('tanggal', $tanggal)
                ->latest()
                ->get();
                return response()->json([
                    'data' => $data,
                    'success' => true
                ]);
    }
    public function grafikadmin(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $ontime = DB::table('absensipegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('tanggal', $tanggal)
        ->where('keterangan','=', 'On Time')
        ->count();
        $terlambat = DB::table('absensipegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('tanggal', $tanggal)
        ->where('keterangan','=', 'Terlambat')
        ->count();
        $izin = DB::table('izin')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('tanggal', $tanggal)
        ->where('status_izin', '=', 'Diterima')
        ->count();
        $hadir = DB::table('absensipegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('tanggal', $tanggal)
        ->where('selfie_masuk','!=', null)
        ->where('keterangan', '!=', 'Tidak Hadir')
        ->count();
        $data5 = DB::table('akunpegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->where('status','Aktif')
        ->count();
        $tidakhadir = $data5 - $hadir;
        $final = [$hadir, $tidakhadir, $ontime, $terlambat, $izin];

        return response()->json($final);
    }

    public function grafikpegawai(){
        $hadir = DB::table('absensipegawai')->where('id', Auth::user()->id)
        ->where('jam_masuk','!=',null)
        ->where('jam_pulang','!=', null)
        ->count();
        $tidakhadir = DB::table('absensipegawai')->where('id', Auth::user()->id)
        ->where('keterangan','Tidak Hadir')
        ->count();
        $izin = DB::table('absensipegawai')->where('id', Auth::user()->id)
        ->where('keterangan', 'Izin')
        ->count();
        $req = DB::table('absensipegawai')->where('id', Auth::user()->id)
        ->where('keterangan','Request Absen')
        ->count();
        $simpan = [$hadir, $tidakhadir, $izin, $req];
        return response()->json($simpan);

    }
    public function cekabsen(){
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        $cek = Absensi::where('email', Auth::user()->email)->where('tanggal', $tanggal)->first();
        return response()->json([
            'data' => $cek
        ]);
    }   
}
