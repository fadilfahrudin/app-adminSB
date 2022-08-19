<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //
     public function all(Request $request){

        //menentukan variabel
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $program_id = $request->input('program_id');
        $status = $request->input('status');


        //mencari berdasarkan id
        if($id){
            //buat variabel dengan relasi program dan user
            $transaction = Transaction::with(['program', 'user'])->find($id);

            //menegmbalikan data sukses
            if($transaction){
                return ResponseFormatter::success(
                    $transaction,
                    'Data transaksi berhasil diambil'
                );
            }else{//jika gagal jalankan ini
                return ResponseFormatter::error(
                    null, 'Data transaksi tidak ada',  404
                );
            }
        }

        //deklarasi variabel transaksi yang mana user sudah login
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
}
