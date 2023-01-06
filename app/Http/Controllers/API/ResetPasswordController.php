<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AkunPegawai;
use Illuminate\Http\Request;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {

        // find the code
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);
        if ($passwordReset !== null) {
            if ($passwordReset->created_at > now()->addHour()) {
                $passwordReset->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'Code Expired',
                ]);
            }
            $admin = User::where('email', $passwordReset->email)->get()->toArray();
            $pegawai = AkunPegawai::where('email', $passwordReset->email)->get()->toArray();
            if($admin != null){
                $updtadmin = AkunPegawai::where('email', $passwordReset->email)
                ->update([
                   'password' => Hash::make($request->password)]);
                $adminreset = ResetCodePassword::select('*')->where('email', $passwordReset->email)->delete();
                
                return response()->json([
                    'success' => true,
                    'message' =>'Password Berhasil Direset',
                    'code' => $passwordReset,
                    'email' => $updtadmin,
                    'data' => $adminreset
                ]);
            }if($pegawai != null){
                $updtpegawai = AkunPegawai::where('email', $passwordReset->email)
                ->update([
                   'password' => Hash::make($request->password)]);
                $pegawaireset = ResetCodePassword::select('*')->where('email', $passwordReset->email)->delete();
                
                return response()->json([
                    'success' => true,
                    'message' =>'Password Berhasil Direset',
                    'code' => $passwordReset,
                    'email' => $updtpegawai,
                    'data' => $pegawaireset
                ]);
            }
        }else{
            return response()->json([
                'success' => null,
                'message' => 'Code Tidak Valid'
            ]);
        }
    }
    public function resetadmin(Request $request)
    {

        // find the code
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);
        if ($passwordReset !== null) {
            if ($passwordReset->created_at > now()->addHour()) {
                $passwordReset->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'Code Expired',
                ]);
            }
            $user = User::where('email', $passwordReset->email)
            ->update([
               'password' => Hash::make($request->password)]);
            $hapus = ResetCodePassword::select('*')->where('email', $passwordReset->email)->delete();
            
            return response()->json([
                'success' => true,
                'message' =>'Password Berhasil Direset',
                'code' => $passwordReset,
                'email' => $hapus,
                'data' => $user
            ]);
        }else{
            return response()->json([
                'success' => null,
                'message' => 'Code Tidak Valid'
            ]);
        }
    }
}
