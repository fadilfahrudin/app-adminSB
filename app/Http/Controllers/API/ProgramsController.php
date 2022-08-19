<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Programs;

class ProgramsController extends Controller
{
    //
    public function all(Request $request){

        //menentukan variabel
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $title = $request->input('title');
        $types = $request->input('types');

        $from_new = $request->input('from_new');
        $to_end = $request->input('to_end');

        $donate_from = $request->input('donate_from');
        $donate_to = $request->input('donate_to');

        //mencari program berdasarkan id
        if($id){
            //ambil dari model program berdasarkan id
            $program = Programs::find($id);

            //jika program ada
            if($program){
                return ResponseFormatter::success(
                    $program,
                    'Data program berhasil diambil'
                );
            }else{//jika gagal maka jalankan error
                return ResponseFormatter::error(
                    null, 'Data program tidak ada',  404
                );
            }
        }

        //mencari berdsarkan query jika datanya true
        $program = Programs::query();

        //mencari berdasarkan judul (yang serupa)
        if($title){
            $program->where('title', 'like','%' . $title . '%');
        }
        //mencari berdasarkan jenis program
        if($types){
            $program->where('types', 'like', '%' . $types . '%');
        }
        //mencari berdasarkan postingan terbaru
        if($from_new){
            $program->where('from_new', '>=', $from_new);
        }
        //mencari berdasarkan postingan yang mau berakhir
        if($to_end){
            $program->where('to_end', '>=', $to_end);
        }

        //mencari berdasarkan donasi dari
        if($donate_from){
            $program->where('donate_from', '>=', $donate_from);
        }

        //mencari berdasarkan donasi ke
        if($donate_to){
            $program->where('donate_to', '>=', $donate_to);
        }

        return ResponseFormatter::success(
            $program->paginate($limit), 'Data berhasil di ambil'
        );
    }
}
