<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    
    public function all(Request $request){

        //menentukan variabel
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $program_id = $request->input('program_id');
        $status = $request->input('status');

        
        if($id){
            
            $transaction = Transaction::with(['program', 'user'])->find($id);
            // var_dump($transaction); die;
            
            
            if($transaction){
                return ResponseFormatter::success(
                    $transaction,
                    'Data transaksi berhasil diambil'
                );
            }else{
                return ResponseFormatter::error(
                    null, 'Data transaksi tidak ada',  404
                );
            }
        }
        

        $transaction = Transaction::with(['program','user'])->where('user_id', Auth::user()->id);

        if($program_id){
            $transaction->where('program_id',$program_id );
        }

        if($status){
            $transaction->where('status',$status );
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit), 'Data transaksi berhasil di ambil'
        );
    }

    public function update(Request $request, $id){
        //ambil data berdasarkan id
        $transaction = Transaction::findOrFail($id);

        //update data yang di ambil
        $transaction->update($request->all());

        return ResponseFormatter::success($transaction, 'transaksi berhasil di perbaharui');
    }

    public function checkout(Request $request){

        //validasi dari foregin keys tabel
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'user_id' => 'required|exists:users,id',
            'amount_final' => 'required',
            'status' => 'required',
        ]);

        $transaction = Transaction::create([
            'program_id' => $request->program_id,
            'user_id' => $request->user_id,
            'amount_final' => $request->amount_final,
            'doa_donatur' => $request->doa_donatur,
            'status' => $request->status,
            'payment_url' => '',
        ]);

        //konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //panggil transaksi yang telah di buat
        $transaction = Transaction::with(['program', 'user'])->find($transaction->id);

        //membuat transaksi ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => (int) $transaction->amount_final,
            ],

            'customers_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
            'enabled_payment' => ['gopay', 'bank_transfer'],
            'vtweb' => [],
        ];

        //memanggil Midtrans

        try {
            //Ambil halaman payment midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            $transaction->payment_url = $paymentUrl;
            $transaction->save();
            
            //mengembalikan data ke API
            return ResponseFormatter::success($transaction, 'Transaksi berhasil');
        } catch(Exception $e){
            return ResponseFormatter::error($e->getMessage(), 'Transaksi gagal');
        }

    }
}
