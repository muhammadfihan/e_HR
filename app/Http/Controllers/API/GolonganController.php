<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Golongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class GolonganController extends Controller
{
    public function allgolongan()
    {
        $golongan = DB::table('golongan')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->get();
        return response([
            'data' => $golongan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }

    public function golonganpegawai()
    {
        $golongan = DB::table('golongan')
            ->select('*')
            ->where('id_admin', Auth::user()->id_admin)
            ->get();
        return response([
            'data' => $golongan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }

    // add book
    public function tambahgolongan(Request $request)
    {
        $golongan = Golongan::create([
            'id_admin' => Auth::user()->id,
            'golongan' => $request->golongan,
            'pendidikan' => $request->pendidikan,
            'nominal' => $request->nominal,
        ]);
        $golongan->save();
        $success = true;
        return response()->json([
            'message' =>'Jabatan successfully added',
            'success' => $success

            ]);
    }

    // edit book

    // update book
    public function updategolongan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'golongan' => 'required',
            'pendidikan' => 'required',
            'nominal' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('golongan')->where('id', $request->id)->update([
                'golongan' => $request->golongan,
                'pendidikan' => $request->pendidikan,
                'nominal' => $request->nominal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Jabatan Berhasil!',
            ]);
        }
    }
    public function hapusgolongan($id)
    {
        $data = Golongan::findOrFail($id);
        $id = $data->id;
        $convert = strval($id);
        $update = DB::table('akunpegawai')->select('*')->where('id_admin', Auth::user()->id)->pluck('id_golongan')->toArray();
        $string = implode(',',$update);
        $cek = Str::contains($string, $convert);
            if($cek){
                return response()->json([
                    'message' => 'Data sedang digunakan',
                    'success' => false,
                ]);
            }else{
                $data->delete();
                return response()->json([
                    'message' => "Berhasil hapus",
                    'success' => true,
                ]);
        }
    }
}
