<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
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
}
