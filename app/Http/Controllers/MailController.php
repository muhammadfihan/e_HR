<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\KirimEmail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(){
        
        $details = [
            'title' => 'email dari sahretech.com',
            'body' => 'ini adalah contoh pengiriman email dengan menggunakan gmail.'
        ];

        //nbelputra437@gmail.com adalah alamat tujuan email

        Mail::to('fihan2as@gmail.com')->send(new KirimEmail($details));
           
        echo "Email berhasil dikirim!";
    }
}
