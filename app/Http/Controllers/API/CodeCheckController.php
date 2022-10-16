<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AkunPegawai;
use Illuminate\Http\Request;
use App\Models\ResetCodePassword;

class CodeCheckController extends Controller
{
    public function cek(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:reset_code_passwords',
        ]);

        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['message' => trans('passwords.code_is_expire')], 422);
        }

        return response([
            'code' => $passwordReset->code,
            'message' => 'passwords.code_is_valid'
        ], 200);
    }
}

