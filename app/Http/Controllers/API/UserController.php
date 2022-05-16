<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Pegawai;
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
                'success' => false,
                'message' => 'Login Failed!',
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            $detail = DB::table('users')
                    ->select('*')
                    ->where('id', $user->id)
                    ->first();

            $data = [
                'email'     => $request->input('email'),
                'password'  => $request->input('password'),
            ];
            if (Auth::attempt($data)) {
                $token = $user->createToken('auth_token')->plainTextToken;
                $response = [
                    'success'   => true,
                    'user'      => $detail,
                    'errors'    => null,
                    'token'     => $token,
                ];
                return response($response, 201);
            } else {
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
            'jumlah_karyawan' => 'required|integer',
            'password' => 'required|string|min:8',

        ]);
        $success = false;
        if($validator->fails()){
            return response()
                ->json(['message' => 'Unauthorized', 'success'=>$success], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'nama_perusahaan' => $request->nama_perusahaan,
            'jumlah_karyawan' => $request->jumlah_karyawan,
            'password' => Hash::make($request->password),

        $pt = Perusahaan::updateOrCreate([
            'admin_perusahaan' => $request->name,
            'nama_perusahaan' => $request->nama_perusahaan,
            'jumlah_karyawan' => $request->jumlah_karyawan,
            'email_perusahaan' => $request->email,
         ])

        ]);
        $success = true;
        $message = 'User register successfully';
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()
            ->json([
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
            'role' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',

        ]);
        $success = false;
        if($validator->fails()){
            return response()
                ->json(['message' => 'Unauthorized', 'success'=>$success], 401);
        }

        $user = AkunPegawai::create([
            'id_admin' => Auth::user()->id,
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $akunpegawai = User::updateOrCreate([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);    
    

        $success = true;
        $message = 'User register successfully';
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()
            ->json([
                'data' => $user,
                'akunpegawai' => $akunpegawai,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'success' => $success,
                'message' => $message,
            ]);
    }
    public function allUser()
    {
        $pegawai = DB::table('akunpegawai')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $pegawai
        ]);
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
                'email' => $request->email,
                'password' => $request->password
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
    public function coba(){
        echo "hello word";
    }
}
