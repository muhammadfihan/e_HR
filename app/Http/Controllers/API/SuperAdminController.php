<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function tampilsuperadmin(){
        $pegawai = DB::table('perusahaan')
        ->select('*')
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $pegawai
        ]);
    }
}
