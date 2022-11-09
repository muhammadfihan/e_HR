<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Pegawai;
use DateTime;
use DateTimeZone;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Element;
use App\Models\AkunPegawai;
use App\Models\Bonus;
use App\Models\DataPegawai;
use App\Models\HariKerja;
use App\Models\JamAbsen;
use App\Models\Tunjangan;
use Illuminate\Support\Carbon;
use App\Models\Potongan;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'error' => true,
                'success' => false,
                'message' => 'Login Failed!',
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user === null) {
                $response = [
                    'success'   => false,
                    'errors'    => true,
                    'input'     => false
                ];
                return response($response, 201);
             }if($user->status == 'Pending'){
                $response = [
                    'success'   => null,
                    'errors'    => true,
                ];
                return response($response, 201);
             }if($user->status == 'Nonaktif'){
                $response = [
                    'success'   => false,
                    'errors'    => true,
                    'nonaktif' => true
                ];
                return response($response, 201);
             }if($user->status == 'Diterima'){
                $detail = User::select('*')
                ->where('id', $user->id)
                ->first();
             }
            $data = [
                'email'     => $request->input('email'),
                'password'  => $request->input('password'),
            ];
            if (Auth::attempt($data)) {
                $token = $user->createToken('auth_token');
                return response()->json([
                    'success'   => true,
                    'user'      => $detail->makeHidden('password'),
                    'errors'    => null,
                    'token'     => $token->plainTextToken,
                    'expired_at' => $token->accessToken->expired_at
                ], 201);
            }
            
            else {
                return response()->json([
                    'akun' => false,
                    'success' => false,
                    'message' => 'Access Denied!',
                ]);

            }

        } 

    }
    public function loginpegawai(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed!',
            ]);
        } else {
            $user = AkunPegawai::where('email', $request->email)->first();
            if ($user === null) {
                $response = [
                    'success'   => false,
                    'errors'    => true,
                ];
                return response($response, 201);
             }
             if ($user->status === 'Tidak Aktif') {
                $response = [
                    'success'   => null,
                    'errors'    => true,
                ];
                return response($response, 201);
             }else{
                $detail = AkunPegawai::select('*')
                ->where('id', $user->id)
                ->first();
             }
           

            $data = [
                'email'     => $request->input('email'),
                'password'  => $request->input('password'),
            ];
            if (Auth::guard('pegawai')->attempt($data)) {
                $namapt = User::where('id', $detail->id_admin)->pluck('nama_perusahaan');
                $token = $user->createToken('auth_token');
                return response()->json([
                    'success'   => true,
                    'user'      => $detail->makeHidden('password'),
                    'namapt'    => $namapt,
                    'errors'    => null,
                    'token'     => $token->plainTextToken,
                    'expired_at' => $token->accessToken->expired_at
                ], 201);
            }
            
            else {
                return response()->json([
                    'success' => false,
                    'message' => 'Access Denied!',
                ]);

            }

        } 

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'jabatan' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:255',
            'npwp' => 'required|string|max:255',
            'det_alamat' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'jumlah_karyawan' => 'required|integer',
            'password' => 'required|string|min:8',

        ]);
        $success = false;
        if($validator->fails()){
            return response()
                ->json(['message' => 'Unauthorized', 'success'=>$success], 401);
        }
        if (User::where('email', '=', $request->input('email'))->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email telah digunakan'
            ]);  
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'nama_perusahaan' => $request->nama_perusahaan,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'jumlah_karyawan' => $request->jumlah_karyawan,
            'npwp' => $request->npwp,
            'kode_pos' => $request->kode_pos,
            'det_alamat' => $request->det_alamat,
            'moto' => $request->moto,
            'website_pt' => $request->website_pt,
            'bidang' => $request->bidang,
            'password' => Hash::make($request->password),

        $pt = Perusahaan::updateOrCreate([
            'admin_perusahaan' => $request->name,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'det_alamat' => $request->det_alamat,
            'npwp' => $request->npwp,
            'kode_pos' => $request->kode_pos,
            'bidang' => $request->bidang,
            'nama_perusahaan' => $request->nama_perusahaan,
            'jumlah_karyawan' => $request->jumlah_karyawan,
            'email_perusahaan' => $request->email,
         ])

        ]);
        $tunjangan = Tunjangan::create([
                    'email_admin' => $user->email,
                    'jenis_tunjangan' => 'Tidak Ada Tunjangan',
                    'nominal' => 0
        ]);
        $bonus = Bonus::create([
            'email_admin' => $user->email,
            'jenis_bonus' => 'Tidak Ada Bonus',
            'nominal' => 0
        ]);
        $potongan = Potongan::create([
            'email_admin' => $user->email,
            'jenis_potongan' => 'Tidak Ada Potongan',
            'nominal' => 0
        ]);
        $harikerja = HariKerja::create([
            'email_admin' => $user->email,
        ]);

        $success = true;
        $message = 'User register successfully';
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
                'tunjangan' => $tunjangan,
                'bonus' => $bonus,
                'potongan' => $potongan,
                'data' => $user,
                'dat_perusahaan' => $pt,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'success' => $success,
                'message' => $message,
            ]);
    }
    public function addAkunPegawai(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'id_jabatan' => 'required',
            'email' => 'required|string|email|max:255|unique:users',

        ]);
        $success = false;
        if (AkunPegawai::where('email', '=', $request->input('email'))->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email telah digunakan'
            ]);  
        }
        $pass = "1234567890";
        $random = strtoupper(substr(str_shuffle($pass), 0, 9));
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        
        $datetime1 = strtotime($request->input('tanggal_masuk'));
        $datetime2 = strtotime($tanggal);
       
        $jumlahkerja = $datetime2 - $datetime1;

        $akunpegawai = AkunPegawai::create([
            'id' => $request->id,
            'id_admin' => Auth::user()->id,
            'name' => $request->name,
            'id_jabatan' => $request->id_jabatan,
            'id_golongan' => $request->id_golongan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah_kerja' => $jumlahkerja/60/60/24,
            'email' => $request->email,
            'password' => 'Password'.$random,
        ]);
        $akunpegawai->save();
        $huruf = "1234567890";
        $timezone = 'Asia/Jakarta'; 
        $date = new DateTime('now', new DateTimeZone($timezone)); 
        $tanggal = $date->format('Y-m-d');
        
        $datetime1 = strtotime($request->input('tanggal_masuk'));
        $datetime2 = strtotime($tanggal);
        // $datetime2 = new DateTime($awal);

        // // dd($akhir);
        // return $akhir;
        $jumlahkerja = $datetime2 - $datetime1;
        // $cuti = $request->input('jatah_cuti');

        if($akunpegawai->jumlah_kerja >= 365){
            $nopegawai = strtoupper(substr(str_shuffle($huruf), 0, 9));
            $pegawai = DataPegawai::create([
                'no_pegawai' => 'PN'.$nopegawai,
                'name' => $request->name,
                'email' => $request->email,
                'id' => $akunpegawai->id,
                'tanggal_masuk' => $request->tanggal_masuk,
                'jumlah_kerja' => $jumlahkerja/60/60/24,
                'id_golongan' => $request->id_golongan,
                'id_jabatan' => $request->id_jabatan,
                'id_admin' => Auth::user()->id,
                // 'jatah_cuti' => 12
            ]);
            $pegawai->save();

            $getDataCuti = DB::table('master_cuti_perusahaan')
                ->select('*')
                ->where('id_admin', Auth::user()->id)
                ->where('tahun', Carbon::now()->format('Y'))
                ->get()
                ->toArray();

            DB::table('table_master_cuti_tahunan')->insert([
                'id_admin' => Auth::user()->id,
                'email' => $request->email,
                'no_pegawai' => 'PN'.$nopegawai,
                'nama_lengkap' => $request->name,
                'id_cuti' => $getDataCuti[0]->id,
                'jumlah_cuti' => $getDataCuti[0]->jumlah_cuti,
                'cuti_terpakai' => 0,
                'sisa_cuti' => $getDataCuti[0]->jumlah_cuti,
                'tahun' => $getDataCuti[0]->tahun
            ]);
            
            $success = true;
            $message = 'User register successfully';
            $token = $akunpegawai->createToken('auth_token')->plainTextToken;
            return response()
                ->json([
                    'data' => $pegawai,
                    'akunpegawai' => $akunpegawai,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'success' => $success,
                    'message' => $message,
                ]);
        }

        $nopegawai = strtoupper(substr(str_shuffle($huruf), 0, 9));
        $pegawai = DataPegawai::create([
            'no_pegawai' => 'PN'.$nopegawai,
            'name' => $request->name,
            'email' => $request->email,
            'id' => $akunpegawai->id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah_kerja' => $jumlahkerja/60/60/24,
            'id_golongan' => $request->id_golongan,
            'id_jabatan' => $request->id_jabatan,
            'id_admin' => Auth::user()->id,

        ]);
        $pegawai->save();
        
        $success = true;
        $message = 'User register successfully';
        $token = $akunpegawai->createToken('auth_token')->plainTextToken;
        return response()
            ->json([
                'data' => $pegawai,
                'akunpegawai' => $akunpegawai,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'success' => $success,
                'message' => $message,
            ]);
         
    }
    public function allUser()
    {
        $pegawai = AkunPegawai::select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->paginate(10);

        $data = $pegawai->makeHidden(['password']);
        $pegawai->data = $data;

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $pegawai,
        ]);
    }
    public function searchuser($key)
    {
            $result = DB::table('akunpegawai')
                ->select('*')
                ->where('akunpegawai.id_admin', Auth::user()->id)
                ->where('email', 'like', '%' . $key . '%')
                ->orWhere('name', 'like', '%' . $key . '%')
                ->orWhere('tanggal_masuk', 'like', '%' . $key . '%')
                ->orWhere('status', 'like', '%' . $key . '%')
                ->where('akunpegawai.id_admin', Auth::user()->id)
                ->paginate(10);

            return $result;

    }
    public function editUser($id)
    {
        $edit = DB::table('akunpegawai')
        ->where('id' ,$id)
        ->get();
        return response([
       'data' => $edit,
       'message' => 'get data berhasil',
       'status' => true,
        ]);
    }

    public function updateUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'id_jabatan' => 'required',
            'email' => 'required',
            'password' => 'required'
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('akunpegawai')->where('id', $request->id)->update([
                'name' => $request->name,
                'id_jabatan' => $request->id_jabatan,
                'id_golongan' => $request->id_golongan,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            DB::table('pegawais')->where('id', $request->id)->update([
                'name' => $request->name,
                'id_golongan' => $request->id_golongan,
                'id_jabatan' => $request->id_jabatan,
                'email' => $request->email,
            ]);
            DB::table('datagaji')->where('id', $request->id)->update([
                'name' => $request->name,
                'id_golongan' => $request->id_golongan,
                'id_jabatan' => $request->id_jabatan,
                'email' => $request->email,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Update Data Berhasil!',
            ]);
        }
    }
    public function hapusUser(Request $request, $id)
    {
        $data = AkunPegawai::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
    public function hapusAdmin(Request $request, $id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }

    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }
    public function getakun()
    {
        $pegawai = DB::table('akunpegawai')
        ->select('*')
        ->where('id', Auth::user()->id)
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $pegawai
        ]);
    }
    public function getstatuspegawai()
    {
        $pegawai = DB::table('akunpegawai')
        ->select('*')
        ->where('id', Auth::user()->id)
        ->first();

        if($pegawai->status == "Tidak Aktif"){
            return response()->json([
                'status' => 'error',
                'message' => 'Unautorizhed',
            ],401);
        }
        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $pegawai->status
        ]);
    }
    public function getstatusadmin()
    {
        $admin = DB::table('users')
        ->select('*')
        ->where('id', Auth::user()->id)
        ->first();

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $admin->status
        ]);
    }
    public function getakunAdmin()
    {
        $admin = DB::table('users')
        ->select('*')
        ->where('id', Auth::user()->id)
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $admin
        ]);
    }
    public function infopt()
    {
        $pt = User::select('*')
        ->where('id', Auth::user()->id)
        ->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $pt->makeHidden('password')
        ]);
    }
    public function infoptpeg()
    {
        $pt = DB::table('users')
        ->select('*')
        ->where('id', Auth::user()->id_admin)
        ->pluck('nama_perusahaan');

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $pt
        ]);
    }
    public function ceking(){
        $ceking = User::where('id', Auth::user()->id)->pluck('status');
        return response()->json([
            'data' => $ceking,
            'success' => true
        ]);
    }

    public function profilepegawai(){
        $profilecard = AkunPegawai::where('id', Auth::user()->id)->get();
        $biodata = DB::table('pegawais')->where('email', Auth::user()->email)->get();
        $jab = DB::table('pegawais')->where('email', Auth::user()->email)->pluck('id_jabatan');
        $jabatan = DB::table('jabatan')->where('id',$jab)->pluck('jabatan')->toArray();
        $gaji = DB::table('jabatan')->where('id',$jab)->pluck('gaji')->first();
        $jabat = implode(',', $jabatan);
        $cuti = DB::table('table_master_cuti_tahunan')->where('email', Auth::user()->email)->get();
        return response()->json([
            'success' => true,
            'message' => 'Get data berhasil',
            'profilecard' => $profilecard,
            'jabatan' => $jabat,
            'gaji' => $gaji,
            'cuti' => $cuti,
            'biodata' => $biodata
        ]);
    }
    public function profileadmin(){
        $main = User::where('id', Auth::user()->id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Get data berhasil',
            'main'  => $main,
        ]);
    }
    public function profilesuperadmin(){
        $main = User::where('id', Auth::user()->id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Get data berhasil',
            'main'  => $main,
        ]);
    }

   
}
