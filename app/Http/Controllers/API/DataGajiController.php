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

        // $idtun = DB::table('datagaji')
        // ->where('id_admin', Auth::user()->id)
        // ->pluck('id_tunjangan');

        // $tunj = count($tunjangan);

        foreach($tunjangan as $i => $tes){
            $tun[$i] = explode(',', $tes->id_tunjangan);

            // $tun = explode(',', $idtun); 

            // $bonus[$i] = DB::table('bonus')->where('id', $tes->id_bonus)->first();
            // $potongan[$i] = DB::table('potongan')->where('id', $tes->id_potongan)->first();

            // unset($data);
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

            // $tun = explode(',', $idtun); 

            // $bonus[$i] = DB::table('bonus')->where('id', $tes->id_bonus)->first();
            // $potongan[$i] = DB::table('potongan')->where('id', $tes->id_potongan)->first();

            // unset($data);
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

            // $tun = explode(',', $idtun); 

            // $bonus[$i] = DB::table('bonus')->where('id', $tes->id_bonus)->first();
            // $potongan[$i] = DB::table('potongan')->where('id', $tes->id_potongan)->first();

            // unset($data);
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
        // $tun = explode(',', $tunjangan[0]->id_tunjangan);

        // // $tun = explode(',', $idtun);  

        // foreach($tun as $index => $row){ 
        //     $data[$index] = DB::table('tunjangan')->where('id', $row)->first();
        //     $nominalALL[$index] = $data[$index]->id;
        //     $jenis[$index] = $data[$index]->jenis_tunjangan;
        // }

        // dd($nominalALL);
       
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
        // $tunjangan
        $tunjanganArray = implode(",",$request->id_tunjangan);
        $bonusArray = implode(",",$request->id_bonus);
        $potonganArray = implode(",",$request->id_potongan);

        // $buatgaji =  DB::table('datagaji')->where('id', $request->id)->update([
        //     'tanggal' => Carbon::now(),
        //     'id_tunjangan' => $tunjanganArray,
        //     'id_bonus' => $bonusArray,
        //     'id_potongan' =>  $potonganArray
        // ]);
        // $buatgaji =  DB::table('datagaji')->where('id', $request->id)->update([
        //     'tanggal' => Carbon::now(),
        //     'id_tunjangan' => $tunjanganArray,
        //     'id_bonus' => $bonusArray,
        //     'id_potongan' =>  $potonganArray
        // ]);
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

        // $detail = DB::table('datagaji')->where('id', $request->id)->first();
            return response()->json([
                'data' => $buatgaji,
                // 'detail' => $detail,
                'success' => true,
                'message' => 'Buat Gaji Berhasil!',
            ]);

    }
    public function detailgaji($id)
    {
       $detgaji = DB::table('penggajian')
       ->where('id' ,$id)
       ->get();
       return response([
           'data' => $detgaji,
           'message' => 'get data berhasil',
           'status' => true,
       ]);

    }
    

  
}
