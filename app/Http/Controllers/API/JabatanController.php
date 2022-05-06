<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    public function alljabatan()
    {
        $jabatan = Jabatan::all()->toArray();
        return array_reverse($jabatan);
    }

    // add book
    public function tambahjabatan(Request $request)
    {
        $jabatan = new Jabatan([
            'jabatan' => $request->jabatan,
            'gaji' => $request->gaji,
            'tunjangan' => $request->tunjangan
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
    public function updatejabatan($id, Request $request)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->update($request->all());
        $success = true;
        return response()->json([
            'message'=>'Jabatan successfully updated',
            'success' => $success]);
    }

    // delete book
    public function hapusjabatan($id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->delete();

        $success = true;
        return response()->json([
            'message'=>'Jabatan successfully deleted',
            'success' => $success]);
    }
}
