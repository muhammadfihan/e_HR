<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tunjangan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Bonus;
use App\Models\Gaji;
use App\Models\Potongan;
use Illuminate\Support\Str;

class GajiController extends Controller
{
    public function tambahtunjangan(Request $request){
        $tunjangan = Tunjangan::create([
            'email_admin' => Auth::user()->email,
            'jenis_tunjangan' => $request->jenis_tunjangan,
            'nominal' => $request->nominal,
        ]);
        $tunjangan->save();
        $success = true;
        return response()->json([
            'message' =>'Jabatan successfully added',
            'success' => $success

            ]);
    }
    public function allgaji(){
        $tunjangan = DB::table('datagaji')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->get();
    return response([
        'data' => $tunjangan,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
   
    public function updatetunjangan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jenis_tunjangan' => 'required',
            'nominal' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('tunjangan')->where('id', $request->id)->update([
                'jenis_tunjangan' => $request->jenis_tunjangan,
                'nominal' => $request->nominal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Jabatan Berhasil!',
            ]);
        }
    }
    public function hapustunjangan(Request $request, $id)
    {
        $data = Tunjangan::findOrFail($id);
        $id = $data->id;
        $convert = strval($id);
        $update = DB::table('penggajian')->select('*')->where('id_admin', Auth::user()->id)->pluck('id_tunjangan')->toArray();
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

    public function alltunjangan(){
        $tunjangan = DB::table('tunjangan')
        ->select('*')
        ->where('email_admin', Auth::user()->email)
        ->latest()
        ->get();
    return response([
        'data' => $tunjangan,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function alltunjangan2(){
        $tunjangan = DB::table('tunjangan')
        ->select('*')
        ->where('email_admin', Auth::user()->email)
        ->where('jenis_tunjangan','!=','Tidak Ada Tunjangan')
        ->latest()
        ->get();
    return response([
        'data' => $tunjangan,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function searchtunjangan($key)
    {
                $result = DB::table('tunjangan')
                ->select('*')
                ->where('jenis_tunjangan','!=','Tidak Ada Tunjangan')
                ->where('tunjangan.email_admin', Auth::user()->email)
                ->where('jenis_tunjangan', 'like', '%' . $key . '%')
                ->where('tunjangan.email_admin', Auth::user()->email)
                ->latest()
                ->get();
            return $result;

    }

    //bonus
    public function tambahbonus(Request $request){
        $tunjangan = Bonus::create([
            'email_admin' => Auth::user()->email,
            'jenis_bonus' => $request->jenis_bonus,
            'nominal' => $request->nominal,
        ]);
        $tunjangan->save();
        $success = true;
        return response()->json([
            'message' =>'Tunjangan successfully added',
            'success' => $success

            ]);
    }

    public function updatebonus(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jenis_bonus' => 'required',
            'nominal' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('bonus')->where('id', $request->id)->update([
                'jenis_bonus' => $request->jenis_bonus,
                'nominal' => $request->nominal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Bonus Berhasil!',
            ]);
        }
    }
    public function hapusbonus(Request $request, $id)
    {
        $data = Bonus::findOrFail($id);
        $id = $data->id;
        $convert = strval($id);
        $update = DB::table('penggajian')->select('*')->where('id_admin', Auth::user()->id)->pluck('id_bonus')->toArray();
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

    public function allbonus(){
        $bonus = DB::table('bonus')
        ->select('*')
        ->where('email_admin', Auth::user()->email)
        ->latest()
        ->get();
    return response([
        'data' => $bonus,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function allbonus2(){
        $bonus = DB::table('bonus')
        ->select('*')
        ->where('email_admin', Auth::user()->email)
        ->where('jenis_bonus','!=','Tidak Ada Bonus')
        ->latest()
        ->get();
    return response([
        'data' => $bonus,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function searchbonus($key)
    {
            $result = DB::table('bonus')
                ->select('*')
                ->where('jenis_bonus','!=','Tidak Ada Bonus')
                ->where('bonus.email_admin', Auth::user()->email)
                ->where('jenis_bonus', 'like', '%' . $key . '%')
                ->where('bonus.email_admin', Auth::user()->email)
                ->latest()
                ->get();
            return $result;

    }
    
    public function tambahpotongan(Request $request){
        $potongan = Potongan::create([
            'email_admin' => Auth::user()->email,
            'jenis_potongan' => $request->jenis_potongan,
            'nominal' => $request->nominal,
        ]);
        $potongan->save();
        $success = true;
        return response()->json([
            'message' =>'Potongan successfully added',
            'success' => $success

            ]);
    }

    public function updatepotongan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jenis_potongan' => 'required',
            'nominal' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('potongan')->where('id', $request->id)->update([
                'jenis_potongan' => $request->jenis_potongan,
                'nominal' => $request->nominal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Potongan Berhasil!',
            ]);
        }
    }
    public function hapuspotongan(Request $request, $id)
    {
        $data = Potongan::findOrFail($id);
        $id = $data->id;
        $convert = strval($id);
        $update = DB::table('penggajian')->select('*')->where('id_admin', Auth::user()->id)->pluck('id_potongan')->toArray();
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

    public function allpotongan(){
        $bonus = DB::table('potongan')
        ->select('*')
        ->where('email_admin', Auth::user()->email)
        ->latest()
        ->get();
    return response([
        'data' => $bonus,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function allpotongan2(){
        $bonus = DB::table('potongan')
        ->select('*')
        ->where('email_admin', Auth::user()->email)
        ->where('jenis_potongan','!=','Tidak Ada Potongan')
        ->latest()
        ->get();
    return response([
        'data' => $bonus,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function searchpotongan($key)
    {
            $result = DB::table('potongan')
                ->select('*')
                ->where('jenis_potongan','!=', 'Tidak Ada Potongan')
                ->where('potongan.email_admin', Auth::user()->email)
                ->where('jenis_potongan', 'like', '%' . $key . '%')
                ->where('potongan.email_admin', Auth::user()->email)
                ->latest()
                ->get();
            return $result;

    }
}
