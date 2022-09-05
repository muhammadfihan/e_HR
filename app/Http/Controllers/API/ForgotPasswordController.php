<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Mail\ForgotPassword as ModelsForgotPassword;
use App\Models\AkunPegawai;
use App\Models\ForgotPassword;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function postEmail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Format Email Salah!',
            ]);
        } else {
                    $forgot = new ForgotPassword();
                    $forgot->email = $request->email;
                    $forgot->token = rand(100000, 999999);
                    $forgot->save();

                    $imel = $forgot->email;
                    $token = $forgot->token;
                    $cek =  DB::table('akunpegawai')
                    ->select('email')
                    ->where('email', $imel)
                    ->get()
                    ->toArray();
                    $data = [
                        'judul' => "Halaman Ubah Password",
                        'token' => $token,
                        'email' => $imel
                    ];
                    Mail::to($imel)->send(new ModelsForgotPassword($data));
                    return response()->json([
                        'success' => true,
                        'tes' => $cek,
                        'message' => 'Check Email Success!',
                    ]);
        }
   
     }
     public function submitlupa(Request $request)
     {
        //  $request->validate([
        //      'email' => 'required|email|exists:users',
        //      'password' => 'required|string|min:8|confirmed',
        //  ]);
 
        //  $updatePassword = DB::table('password_resets')
        //                      ->where([
        //                        'email' => $request->email, 
        //                        'token' => $request->token
        //                      ])
        //                      ->first();
 
        //  if(!$updatePassword){
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Tidak Diketahui Errornya',
        //     ]);
        //  }
 
         $user = AkunPegawai::where('email', $request->email)
                     ->update([
                        'password' => Hash::make($request->password)]);
         $reset = DB::table('password_resets')->where(['email'=> $request->email])->delete();
         return response()->json([
            'success' => true,
            'message' => 'Success!',
            'data' => $user,
            'reset' => $reset
        ]);
     }

}
