<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Torann\GeoIP\Console\Update;

class JobController extends Controller
{
    public function buatjob(Request $request){
        $buat = Job::create([
            'id_admin' => Auth::user()->id,
            'email_pegawai' => $request->email_pegawai,
            'judul_job' => $request->judul_job,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline
        ]);

        return response()->json([
            'success' => true,
            'data' => $buat
        ]);

    }

    public function updatejob(Request $request){
        $update = Job::where('id', $request->id)
            ->update([
                'judul_job' => $request->judul_job,
                'deskripsi' => $request->deskripsi,
                'deadline' => $request->deadline
            ]);
        return response()->json([
            'success' => true,
            'data' => $update,
            'message' => 'Berhasil Update'
        ]);
    }

    public function hapusjob($id){
        $data = Job::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus Job Berhasil!',
        ]);
    }

    public function detailjob($id){
        $get = DB::table('job')
        ->where('id' ,$id)
        ->get();
        return response([
            'data' => $get,
            'message' => 'get data berhasil',
            'status' => true,
        ]);
    }

    public function approvejob(Request $request){
        DB::table('job')
            ->where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);
        if($request->status == 'Complete'){
            return response()->json([
                'success' => 100,
                'message' => 'No Revisi'
            ]);
        }if($request->status == 'Revisi'){
            $revisi = DB::table('job')
            ->where('id', $request->id)
            ->update([
                'revisi' => $request->revisi
            ]);
            return response()->json([
                'success' => 75,
                'data' => $revisi,
                'message' => 'Berhasil'
            ]);
        }    
    }

    public function submitjob(Request $request){

        if($request->hasFile('pengumpulan')){
            $file_path = "files/";
            $filename = str_replace('','',$request->file('pengumpulan')->getClientOriginalName());
            $request->file('pengumpulan')->move($file_path, $filename);
            DB::table('job')
            ->where('id', $request->id)
            ->update([
                'terkumpul' => Carbon::now('Asia/Jakarta'),
                'pengumpulan' => $filename
            ]);
            $cek = DB::table('job')->where('id', $request->id)->first();
            if($cek->terkumpul > $cek->deadline){
                $telat = DB::table('job')
                ->where('id', $request->id)
                ->update([
                    'keterangan' => 'Overdue',
                    'status' => 'Checking'
                ]);
                return response()->json([
                    'success' => true,
                    'data' => $telat
                ]);
            }else{
                $tepat = DB::table('job')
                ->where('id', $request->id)
                ->update([
                    'keterangan' => 'On Time',
                    'status' => 'Checking'
                ]);
                return response()->json([
                    'success' => true,
                    'data' => $tepat
                ]);
            }
        }
    }

    public function submitrevisi(Request $request){
        $file_path = "files/";
        $filename = str_replace('','',$request->file('pengumpulan')->getClientOriginalName());
        $request->file('pengumpulan')->move($file_path, $filename);

        if ($request->hasFile('pengumpulan')) {
            $revisi = DB::table('job')
            ->where('id', $request->id)
            ->update([
                'pengumpulan' => $request->filename,
                'terkumpul' => Carbon::now('Asia/Jakarta')
            ]);

            return response()->json([
                'success' => true,
                'data' => $revisi
            ]);
        }
    }

    public function alljob(){
        $getjob = DB::table('job')
            ->select('*')
            ->where('id_admin', Auth::user()->id)
            ->latest()
            ->paginate(8);
        return response()->json([
            'success' => true,
            'data' => $getjob,
        ]);
    }

    public function alljobpeg(){
        $getjob = DB::table('job')
            ->select('*')
            ->where('email_pegawai', Auth::user()->email)
            ->latest()
            ->paginate(8);
        return response()->json([
            'success' => true,
            'data' => $getjob,
        ]);
    }
    public function searchjob($key){
        $result = DB::table('job')
        ->select('*')
        ->where('job.id_admin', Auth::user()->id)
        ->where('email_pegawai', 'like', '%' . $key . '%')
        ->orWhere('judul_job', 'like', '%' . $key . '%')
        ->where('job.id_admin', Auth::user()->id)
        ->latest()
        ->paginate(8);

    return $result;
    }
    public function searchjobpeg($key){
        $result = DB::table('job')
        ->select('*')
        ->where('job.email_pegawai', Auth::user()->email)
        ->where('judul_job', 'like', '%' . $key . '%')
        ->where('job.email_pegawai', Auth::user()->email)
        ->latest()
        ->paginate(8);

    return $result;
    }
}
