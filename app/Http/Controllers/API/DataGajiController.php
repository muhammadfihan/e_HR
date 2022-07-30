<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Penggajian;
use App\Models\Gaji;

class DataGajiController extends Controller
{
    public function sudahisi(Request $request){
        $sudah = Gaji::where('id_admin' ,Auth::user()->id)->get();
            return response([
                'data' => $sudah,
                'message' => 'get data berhasil',
                'status' => true,
            ]);
       
    }
    public function allgaji(Request $request){
        $tunjangan = DB::table('penggajian')
        ->select('*')
        ->where('id_admin', Auth::user()->id)
        ->latest()
        ->get()->toArray();

        foreach($tunjangan as $i => $tes){
            $tun[$i] = explode(',', $tes->id_tunjangan);
            foreach($tun[$i] as $index => $row){ 
                $data[$i][$index] = DB::table('tunjangan')->where('id', $row)->first();
                $nominalALL[$i][$index] = $data[$i][$index]->nominal;
                $jenis[$i][$index] = $data[$i][$index]->jenis_tunjangan;
                $val[$i] = $jenis[$i];
                $nom[$i] = $nominalALL[$i];
                $totaltun[$i] = array_sum($nominalALL[$i]);
            }
        }
        foreach($tunjangan as $j => $tes2){
            $bon[$j] = explode(',', $tes2->id_bonus);
            foreach($bon[$j] as $nus => $coba){ 
                $databon[$j][$nus] = DB::table('bonus')->where('id', $coba)->first();
                $nominalBon[$j][$nus] = $databon[$j][$nus]->nominal;
                $jenisBon[$j][$nus] = $databon[$j][$nus]->jenis_bonus;
                $valBon[$j] = $jenisBon[$j];
                $nomBon[$j] = $nominalBon[$j];
                $totalbon[$j] = array_sum($nominalBon[$j]);
                
            }
        }
        foreach($tunjangan as $x => $tes3){
            $pot[$x] = explode(',', $tes3->id_potongan);
            foreach($pot[$x] as $tongan => $coba2){ 
                $datapot[$x][$tongan] = DB::table('potongan')->where('id', $coba2)->first();
                $nominalPot[$x][$tongan] = $datapot[$x][$tongan]->nominal;
                $jenisPot[$x][$tongan] = $datapot[$x][$tongan]->jenis_potongan;
                $valPot[$x] = $jenisPot[$x];
                $nomPot[$x] = $nominalPot[$x];
                $totalpot[$x] = array_sum($nominalPot[$x]);
                
            }
        }
        foreach($tunjangan as $a => $jab){
            $jabat[$a] = explode(',', $jab->id_jabatan);

            foreach($jabat[$a] as $batan => $tan){ 
                $datajab[$a][$batan] = DB::table('jabatan')->where('id', $tan)->first();
                $jabgaji[$a][$batan] = $datajab[$a][$batan]->gaji;
                $jenisjab[$a][$batan] = $datajab[$a][$batan]->jabatan;
                $valjab[$a] = $jenisjab[$a];
                $nomjab[$a] = array_sum($jabgaji[$a]);
                
            }
        }
        foreach (array_keys($totaltun + $totalbon + $totalpot + $nomjab) as $key) {
            $akhir[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key] - $totalpot[$key]);
            
        }
       
    return response()->json([
        'data' => $tunjangan,
        'tunjangan' => $val,
        'nominal' => $nom,
        'jabatan' => $valjab,
        'gaji' => $nomjab,
        'total_tunjangan' => $totaltun,
        'bonus' => $valBon,
        'nominal_bonus' => $nomBon,
        'total_bonus' => $totalbon,
        'potongan' => $valPot,
        'nominal_potongan' => $nomPot,
        'total_potongan' => $totalpot,
        'hasil' => $akhir,
        'message' => 'get data berhasil',
        'status' => true
    ]);
    }
    public function buatgaji(Request $request)
    {   
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'id_bonus' => 'required',
            'id_jabatan' => 'required',
            'id_tunjangan' => 'required',
            'id_potongan' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak lengkap',
            ]);
        }else{
            $tunjanganArray = implode(",",$request->id_tunjangan);
            $bonusArray = implode(",",$request->id_bonus);
            $potonganArray = implode(",",$request->id_potongan);
            $buatgaji =  Penggajian::create([
                'id_admin' => Auth::user()->id,
                'email' => $request->email,
                'id_jabatan' => $request->id_jabatan,
                'id_golongan' => $request->id_golongan,
                'tanggal' => Carbon::now(),
                'id_tunjangan' => $tunjanganArray,
                'id_bonus' => $bonusArray,
                'id_potongan' =>  $potonganArray
            ]);
                return response()->json([
                    'data' => $buatgaji,
                    'success' => true,
                    'message' => 'Buat Gaji Berhasil!',
                ]);
        }
        

    }
    public function updategaji(Request $request)
    {    
        $validate = Validator::make($request->all(), [
        'id_bonus' => 'required',
        'id_tunjangan' => 'required',
        'id_potongan' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak lengkap',
            ]);
        }else{
            $tunjanganArray = implode(",",$request->id_tunjangan);
            $bonusArray = implode(",",$request->id_bonus);
            $potonganArray = implode(",",$request->id_potongan);
            $updategaji = DB::table('penggajian')->where('id', $request->id)->update([
            'id_tunjangan' => $tunjanganArray,
            'id_bonus' => $bonusArray,
            'id_potongan' => $potonganArray,
        ]);
            return response()->json([
                'data' => $updategaji,
                'success' => true,
                'message' => 'Update Gaji Berhasil!',
            ]);
        }
           

    }
    public function detailgaji($id)
    {
       $detgaji = DB::table('penggajian')
       ->where('id' ,$id)
       ->get()->toArray();
       foreach($detgaji as $i => $tes){
        $tun[$i] = explode(',', $tes->id_tunjangan);
        foreach($tun[$i] as $index => $row){ 
            $data[$i][$index] = DB::table('tunjangan')->where('id', $row)->first();
            $nominalALL[$i][$index] = $data[$i][$index]->nominal;
            $jenis[$i][$index] = $data[$i][$index]->jenis_tunjangan;
            $val[$i] = $jenis[$i];
            $nom[$i] = $nominalALL[$i];
            $totaltun[$i] = array_sum($nominalALL[$i]);
            $arrtun[$i] = array($totaltun[$i]);
        }
    }
    foreach($detgaji as $j => $tes2){
        $bon[$j] = explode(',', $tes2->id_bonus);
        foreach($bon[$j] as $nus => $coba){ 
            $databon[$j][$nus] = DB::table('bonus')->where('id', $coba)->first();
            $nominalBon[$j][$nus] = $databon[$j][$nus]->nominal;
            $jenisBon[$j][$nus] = $databon[$j][$nus]->jenis_bonus;
            $valBon[$j] = $jenisBon[$j];
            $nomBon[$j] = $nominalBon[$j];
            $totalbon[$j] = array_sum($nominalBon[$j]);
            $arrbon[$j] = array($totalbon[$j]);
            
        }
    }
    foreach($detgaji as $x => $tes3){
        $pot[$x] = explode(',', $tes3->id_potongan);
        foreach($pot[$x] as $tongan => $coba2){ 
            $datapot[$x][$tongan] = DB::table('potongan')->where('id', $coba2)->first();
            $nominalPot[$x][$tongan] = $datapot[$x][$tongan]->nominal;
            $jenisPot[$x][$tongan] = $datapot[$x][$tongan]->jenis_potongan;
            $valPot[$x] = $jenisPot[$x];
            $nomPot[$x] = $nominalPot[$x];
            $totalpot[$x] = array_sum($nominalPot[$x]);
            $arrpot[$x] = array($totalpot[$x]);
            
        }
    }
    foreach($detgaji as $a => $jab){
        $jabat[$a] = explode(',', $jab->id_jabatan);

        foreach($jabat[$a] as $batan => $tan){ 
            $datajab[$a][$batan] = DB::table('jabatan')->where('id', $tan)->first();
            $jabgaji[$a][$batan] = $datajab[$a][$batan]->gaji;
            $jenisjab[$a][$batan] = $datajab[$a][$batan]->jabatan;
            $valjab[$a] = $jenisjab[$a];
            $nomjab[$a] = array_sum($jabgaji[$a]);
            $arrjab[$a] = array($nomjab[$a]);
            
        }
    }
    foreach (array_keys($totaltun + $totalbon + $totalpot + $nomjab) as $key) {
        $akhir[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key] - $totalpot[$key]);
        
    }
    foreach (array_keys($totaltun + $totalbon + $nomjab) as $key) {
        $subtotal[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key]);
        
    }
   
    return response()->json([
        'data' => $detgaji,
        'tunjangan' => $val,
        'arrtun' => $arrtun,
        'arrbon' => $arrbon,
        'arrpot' => $arrpot,
        'arrjab' => $arrjab,
        'nominal' => $nom,
        'jabatan' => $valjab,
        'gaji' => $nomjab,
        'total_tunjangan' => $totaltun,
        'bonus' => $valBon,
        'nominal_bonus' => $nomBon,
        'total_bonus' => $totalbon,
        'potongan' => $valPot,
        'nominal_potongan' => $nomPot,
        'total_potongan' => $totalpot,
        'hasil' => $akhir,
        'subtotal' => $subtotal,
        'message' => 'get data berhasil',
        'status' => true
    ]);

    }
    public function gajipegawai(){
        $gajipeg = Penggajian::where('email' ,Auth::user()->email)->latest()->get();
            foreach($gajipeg as $i => $tes){
                $tun[$i] = explode(',', $tes->id_tunjangan);
                foreach($tun[$i] as $index => $row){ 
                    $data[$i][$index] = DB::table('tunjangan')->where('id', $row)->first();
                    $nominalALL[$i][$index] = $data[$i][$index]->nominal;
                    $jenis[$i][$index] = $data[$i][$index]->jenis_tunjangan;
                    $val[$i] = $jenis[$i];
                    $nom[$i] = $nominalALL[$i];
                    $totaltun[$i] = array_sum($nominalALL[$i]);
                }
            }
            foreach($gajipeg as $j => $tes2){
                $bon[$j] = explode(',', $tes2->id_bonus);
                foreach($bon[$j] as $nus => $coba){ 
                    $databon[$j][$nus] = DB::table('bonus')->where('id', $coba)->first();
                    $nominalBon[$j][$nus] = $databon[$j][$nus]->nominal;
                    $jenisBon[$j][$nus] = $databon[$j][$nus]->jenis_bonus;
                    $valBon[$j] = $jenisBon[$j];
                    $nomBon[$j] = $nominalBon[$j];
                    $totalbon[$j] = array_sum($nominalBon[$j]);
                    
                }
            }
            foreach($gajipeg as $x => $tes3){
                $pot[$x] = explode(',', $tes3->id_potongan);
                foreach($pot[$x] as $tongan => $coba2){ 
                    $datapot[$x][$tongan] = DB::table('potongan')->where('id', $coba2)->first();
                    $nominalPot[$x][$tongan] = $datapot[$x][$tongan]->nominal;
                    $jenisPot[$x][$tongan] = $datapot[$x][$tongan]->jenis_potongan;
                    $valPot[$x] = $jenisPot[$x];
                    $nomPot[$x] = $nominalPot[$x];
                    $totalpot[$x] = array_sum($nominalPot[$x]);
                    
                }
            }
            foreach($gajipeg as $a => $jab){
                $jabat[$a] = explode(',', $jab->id_jabatan);
    
                foreach($jabat[$a] as $batan => $tan){ 
                    $datajab[$a][$batan] = DB::table('jabatan')->where('id', $tan)->first();
                    $jabgaji[$a][$batan] = $datajab[$a][$batan]->gaji;
                    $jenisjab[$a][$batan] = $datajab[$a][$batan]->jabatan;
                    $valjab[$a] = $jenisjab[$a];
                    $nomjab[$a] = array_sum($jabgaji[$a]);
                    
                }
            }
            foreach (array_keys($totaltun + $totalbon + $totalpot + $nomjab) as $key) {
                $akhir[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key] - $totalpot[$key]);
                
            }
            // foreach (array_keys($totaltun + $totalbon + $nomjab) as $key) {
            //     $subtotal[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key]);
                
            // }
           
        return response()->json([
            'data' => $gajipeg,
            'tunjangan' => $val,
            'nominal' => $nom,
            'jabatan' => $valjab,
            'gaji' => $nomjab,
            'total_tunjangan' => $totaltun,
            'bonus' => $valBon,
            'nominal_bonus' => $nomBon,
            'total_bonus' => $totalbon,
            'potongan' => $valPot,
            'nominal_potongan' => $nomPot,
            'total_potongan' => $totalpot,
            'hasil' => $akhir,
            // 'subtotal' => $subtotal,
            'message' => 'get data berhasil',
            'status' => true
        ]);    
    }
    public function detgajipeg($id){
        $detgaji = DB::table('penggajian')
        ->where('id' ,$id)
        ->get()->toArray();
        foreach($detgaji as $i => $tes){
         $tun[$i] = explode(',', $tes->id_tunjangan);
         foreach($tun[$i] as $index => $row){ 
             $data[$i][$index] = DB::table('tunjangan')->where('id', $row)->first();
             $nominalALL[$i][$index] = $data[$i][$index]->nominal;
             $jenis[$i][$index] = $data[$i][$index]->jenis_tunjangan;
             $val[$i] = $jenis[$i];
             $nom[$i] = $nominalALL[$i];
             $totaltun[$i] = array_sum($nominalALL[$i]);
             $arrtun[$i] = array($totaltun[$i]);
         }
     }
     foreach($detgaji as $j => $tes2){
         $bon[$j] = explode(',', $tes2->id_bonus);
         foreach($bon[$j] as $nus => $coba){ 
             $databon[$j][$nus] = DB::table('bonus')->where('id', $coba)->first();
             $nominalBon[$j][$nus] = $databon[$j][$nus]->nominal;
             $jenisBon[$j][$nus] = $databon[$j][$nus]->jenis_bonus;
             $valBon[$j] = $jenisBon[$j];
             $nomBon[$j] = $nominalBon[$j];
             $totalbon[$j] = array_sum($nominalBon[$j]);
             $arrbon[$j] = array($totalbon[$j]);
             
         }
     }
     foreach($detgaji as $x => $tes3){
         $pot[$x] = explode(',', $tes3->id_potongan);
         foreach($pot[$x] as $tongan => $coba2){ 
             $datapot[$x][$tongan] = DB::table('potongan')->where('id', $coba2)->first();
             $nominalPot[$x][$tongan] = $datapot[$x][$tongan]->nominal;
             $jenisPot[$x][$tongan] = $datapot[$x][$tongan]->jenis_potongan;
             $valPot[$x] = $jenisPot[$x];
             $nomPot[$x] = $nominalPot[$x];
             $totalpot[$x] = array_sum($nominalPot[$x]);
             $arrpot[$x] = array($totalpot[$x]);
             
         }
     }
     foreach($detgaji as $a => $jab){
         $jabat[$a] = explode(',', $jab->id_jabatan);
 
         foreach($jabat[$a] as $batan => $tan){ 
             $datajab[$a][$batan] = DB::table('jabatan')->where('id', $tan)->first();
             $jabgaji[$a][$batan] = $datajab[$a][$batan]->gaji;
             $jenisjab[$a][$batan] = $datajab[$a][$batan]->jabatan;
             $valjab[$a] = $jenisjab[$a];
             $nomjab[$a] = array_sum($jabgaji[$a]);
             $arrjab[$a] = array($nomjab[$a]);
             
         }
     }
     foreach (array_keys($totaltun + $totalbon + $totalpot + $nomjab) as $key) {
         $akhir[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key] - $totalpot[$key]);
         
     }
     foreach (array_keys($totaltun + $totalbon + $nomjab) as $key) {
        $subtotal[$key] = array($totaltun[$key] + $nomjab[$key] +$totalbon[$key]);
        
    }
    
    
     return response()->json([
         'data' => $detgaji,
         'tunjangan' => $val,
         'arrtun' => $arrtun,
         'arrbon' => $arrbon,
         'arrpot' => $arrpot,
         'arrjab' => $arrjab,
         'nominal' => $nom,
         'jabatan' => $valjab,
         'gaji' => $nomjab,
         'total_tunjangan' => $totaltun,
         'bonus' => $valBon,
         'nominal_bonus' => $nomBon,
         'total_bonus' => $totalbon,
         'potongan' => $valPot,
         'nominal_potongan' => $nomPot,
         'total_potongan' => $totalpot,
         'hasil' => $akhir,
         'subtotal' => $subtotal,
         'message' => 'get data berhasil',
         'status' => true
     ]);
 
    }

    public function ambilgaji(Request $request){
           $confirm = DB::table('penggajian')->where('id', $request->id)->update([
                'status' => $request->status,
            ]);

            return response()->json([
                'data' => $confirm,
                'success' => true,
                'message' => 'Berhasil Ambil Gaji!',
            ]);
    }
    public function hapusgaji(Request $request, $id)
    {
        $data = Penggajian::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hapus data berhasil'
        ]);
    }
    

  
}
