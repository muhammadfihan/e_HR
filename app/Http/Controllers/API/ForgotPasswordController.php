<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\SendCodeAdmin;
use Illuminate\Http\Request;
use App\Models\ResetCodePassword;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCodeResetPassword;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    public function lupa(Request $request)
    {
        $forgot = new ResetCodePassword();
        $forgot->email = $request->email;
        $forgot->code = rand(100000, 999999);
        $forgot->save();

        $imel = $forgot->email;
        $token = $forgot->code;
        $dat = DB::table('akunpegawai')
            ->select('name')
            ->where('email', $imel)
            ->get()
            ->toArray();
        if($dat == null){
            return response()->json([
                'success' => false,
                'message' => 'Email Tidak Terdaftar'
            ]);
        }
        $objectToArray = (array)$dat;
        $name1 = $objectToArray[0];
        $name2 = (array)$name1;
        $nama = $name2['name'];
        $data = [
            'judul' => "Halaman Ubah Password",
            'nama' => $nama,
            'token' => $token,
            'email' => $imel
        ];
        Mail::to($imel)->send(new SendCodeResetPassword($data));
        return response()->json([
            'success' => true,
            'message' => 'Check Email Success!',
        ]);
    }
    public function lupaadmin(Request $request)
    {
        $forgot = new ResetCodePassword();
        $forgot->email = $request->email;
        $forgot->code = rand(100000, 999999);
        $forgot->save();

        $imel = $forgot->email;
        $token = $forgot->code;
        $dat = DB::table('users')
            ->select('name')
            ->where('email', $imel)
            ->get()
            ->toArray();
        if($dat == null){
            return response()->json([
                'success' => false,
                'message' => 'Email Tidak Terdaftar'
            ]);
        }
        $objectToArray = (array)$dat;
        $name1 = $objectToArray[0];
        $name2 = (array)$name1;
        $nama = $name2['name'];
        $data = [
            'judul' => "Halaman Ubah Password Admin",
            'nama' => $nama,
            'token' => $token,
            'email' => $imel
        ];
        Mail::to($imel)->send(new SendCodeAdmin($data));
        return response()->json([
            'success' => true,
            'message' => 'Check Email Success!',
        ]);
    }
}
