<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Element;

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
            if ($user->role == "Admin") {
                $detail = DB::table('users')
                    ->select('*')
                    ->where('role', "Admin")
                    ->first();
            } else
            {
                $detail = DB::table('users')
                    ->select('*')
                    ->where('id', $user->id)
                    ->first();
            }
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
//            }
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|',
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
            'role' => $request->role,
            'jabatan' => $request->jabatan,
            'nama_perusahaan' => $request->nama_perusahaan,
            'jumlah_karyawan' => $request->jumlah_karyawan,
            'password' => Hash::make($request->password),

        ]);
        $success = true;
        $message = 'User register successfully';
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()
            ->json([
                'data' => $user,
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
            'email' => 'required|string|email|max:255|unique:users',
            'jabatan' => 'required|string|max:255',
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
            'password' => Hash::make($request->password),

        ]);
        $success = true;
        $message = 'User register successfully';
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()
            ->json([
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'success' => $success,
                'message' => $message,
            ]);
    }
    public function allUser()
    {
        $pegawai = Pegawai::all();

        return response()->json([
            'status' => true,
            'message' => 'Ambil data berhasil',
            'data' => $pegawai
        ]);
    }
    public function editUser($id)
    {
        $pegawai = Pegawai::find($id);
        return response()->json($pegawai);
    }

    public function updateUser(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'role' => 'required',
            'jabatan' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('pegawais')->where('id', $id)->update([
                'name' => $request->name,
                'role' => $request->role,
                'jabatan' => $request->jabatan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Data Berhasil!',
            ]);
        }
    }
    public function hapusUser(Request $request, $id)
    {
        $data = Pegawai::findOrFail($id);
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
