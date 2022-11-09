<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AkunPegawai;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JabatanController extends Controller
{
    public function alljabatan()
    {
        $jabatan = DB::table('jabatan')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->get();
        return response([
            'data' => $jabatan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }
    public function alljabatan2()
    {
        $jabatan = DB::table('jabatan')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->where('deleted_at',null)
            ->get();
        return response([
            'data' => $jabatan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }
    public function alljabatansuperadmin()
    {
        $jabatan = DB::table('jabatan')
            ->select('*')
            ->where('deleted_at',null)
            ->get();
        return response([
            'data' => $jabatan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }
    public function jabatanpaginate()
    {
        $jabatan = DB::table('jabatan')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->where('deleted_at',null)
            ->latest()
            ->paginate(8);
        return response([
            'data' => $jabatan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }
    public function searchjabatan($key)
    {
            $result = DB::table('jabatan')
                ->select('*')
                ->where('jabatan.id_admin', Auth::user()->id)
                ->where('deleted_at',null)
                ->where('jabatan', 'like', '%' . $key . '%')
                ->where('jabatan.id_admin', Auth::user()->id)
                ->latest()
                ->paginate(10);

            return $result;

    }
    public function jabatanpegawai()
    {
        $jabatan = DB::table('jabatan')
            ->select('*')
            ->where('id_admin', Auth::user()->id_admin)
            ->get();
        return response([
            'data' => $jabatan,
            'message' => 'get data berhasil',
            'status' => true
        ]);
    }

    // add book
    public function tambahjabatan(Request $request)
    {
        $jabatan = Jabatan::create([
            'id_admin' => Auth::user()->id,
            'jabatan' => $request->jabatan,
            'gaji' => $request->gaji,
        ]);
        $jabatan->save();
        $success = true;
        return response()->json([
            'message' =>'Jabatan successfully added',
            'success' => $success

            ]);
    }

    // edit book
    public function editjabatan($id)
    {
        $jabatan = Jabatan::find($id);
        return response()->json($jabatan);
    }

    // update book
    public function updatejabatan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jabatan' => 'required',
            'gaji' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('jabatan')->where('id', $request->id)->update([
                'jabatan' => $request->jabatan,
                'gaji' => $request->gaji,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Jabatan Berhasil!',
            ]);
        }
    }
    public function hapusjabatan(Request $request, $id)
    {
        $data = Jabatan::findOrFail($id);
        $id = $data->id;
        $convert = strval($id);
        $update = DB::table('akunpegawai')->select('*')->where('id_admin', Auth::user()->id)->pluck('id_jabatan')->toArray();
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
