<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateJatahCuti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Daily email to all users with a word and its meaning';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dataPeg = DB::table('akunpegawai')
            ->select('*')
            ->where('email', Auth::user()->email)
            ->get()
            ->toArray();
        
        if ($dataPeg[0]->jumlah_kerja >= 365) {
            # code...
            $dataCuti = DB::table('table_master_cuti_tahunan')
            ->select('*')
            ->where('email', Auth::user()->email)
            ->where('tahun', Carbon::now()->format('Y'))
            ->get()
            ->toArray();

            if (count($dataCuti) >= 1) {
                # code...
            } else {
                $datas = DB::table('table_master_cuti_tahunan')
                ->select('*')
                ->where('email', Auth::user()->email)
                ->get()
                ->toArray();


                DB::table('table_master_cuti_tahunan')->insert([
                    'id_admin' => $datas[0]->id_admin,
                    'email' => $datas[0]->email,
                    'no_pegawai' => $datas[0]->no_pegawai,
                    'nama_lengkap' => $datas[0]->nama_lengkap,
                    'jumlah_cuti' => 12,
                    'cuti_terpakai' => 0,
                    'sisa_cuti' => 12,
                    'tahun' => Carbon::now()->format('Y')
                ]);
            }
        } else {
            # code...
        }
        
    }
}
