<?php

namespace App\Http\Controllers\API;

use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Midtrans\Notification;

class MidtransController extends Controller
{
    //
    public function callback(Request $request){
        //set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
        //buat instance(contoh) midtrans notifikasi
        $notification = new Notification();

        //Assign ke variabel untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        //cari transaksi berdasarkan id
        $transaction = Transaction::findOrFail($order_id);

        //handle notifikasi status midtrans
        if($status === 'capture'){
            if($type == 'credit_card' ){
                if($fraud == 'challenge'){
                    $transaction->status = 'PENDING';
                }else{
                    $transaction->status = 'SUCCESS ';
                }
            }
        }else if($status == 'settlement') {
            $transaction->status = 'SUCCESS ';
        }else if($status == 'pending') {
            $transaction->status = 'PENDING ';
        }else if($status == 'deny') {
            $transaction->status = 'CENCCELLED ';
        }else if($status == 'expire') {
            $transaction->status = 'CENCCELLED ';
        }else if($status == 'cencel') {
            $transaction->status = 'CENCCELLED ';
        }

        //simpan transaksi
        $transaction->save();
    }

    public function success(){
        return view('midtrans.success');
    }
    public function unfinish(){
        return view('midtrans.unfinish');
    }

    public function error(){
        return view('midtrans.error');
    }
}

