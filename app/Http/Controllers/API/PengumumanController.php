<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Psy\Command\WhereamiCommand;

class PengumumanController extends Controller
{
    public function buatpengumuman(Request $request){
        $buatizin = Pengumuman::create([
            'id_admin' => Auth::user()->id,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tanggal_pengumuman' => $request->tanggal_pengumuman,
            'tanggal_dibuat' => Carbon::now('Asia/Jakarta')->format('Y-m-d')
        ]);

        return response()->json([
            'success' => true,
            'data' => $buatizin
        ]);
    }

    public function editpengumuman(Request $request){
        $validate = Validator::make($request->all(), [
            'judul' => 'required',
            'isi' => 'required',
            'tanggal_pengumuman' => 'required',
         ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal!',
            ]);
        } else {
            DB::table('pengumuman')->where('id', $request->id)->update([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'tanggal_pengumuman' => $request->tanggal_pengumuman
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update Pengumuman Berhasil!',
            ]);
        }
    }
    
    public function hapuspengumuman($id){
        $data = Pengumuman::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus Pengumuman Berhasil!',
        ]);
    }

    public function getpengumuman(){
        $pengumuman = DB::table('pengumuman')
            ->where('id_admin', Auth::user()->id)
            ->get()
            ->toArray();

        return response()->json([
                'success' => true,
                'data' => $pengumuman,
                'message' => 'Get Pengumuman Berhasil!',
            ]);    

    }
    public function getpengumumanpeg(){
        $pengumuman = DB::table('pengumuman')
            ->where('id_admin', Auth::user()->id_admin)
            ->orderByDesc('tanggal_pengumuman')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pengumuman,
            'message' => 'Get Pengumuman Berhasil!',
        ]);    
    }

    public function detailpengumuman($id){
        $get = DB::table('pengumuman')
        ->where('id' ,$id)
        ->get();
        return response([
            'data' => $get,
            'message' => 'get data berhasil',
            'status' => true,
        ]);
    }
}
