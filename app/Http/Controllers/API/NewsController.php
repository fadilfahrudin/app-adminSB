<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    //
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $title = $request->input('title');
        $program_id = $request->input('program_id');

         //mencari berdasarkan id
        if($id){
            //buat variabel dengan relasi program
            $news = News::with(['program'])->find($id);

            //menegmbalikan data sukses
            if($news){
                return ResponseFormatter::success(
                    $news,
                    'Data berita berhasil diambil'
                );
            }else{//jika gagal jalankan ini
                return ResponseFormatter::error(
                    null, 'Data berita tidak ada',  404
                );
            }
        }

        
        
        $news = News::with(['program']);

        if($program_id){
            $news->where('program_id', $program_id);
        }

        if($title){
            $news->where('title', $title );
        }

        return ResponseFormatter::success(
            $news->paginate($limit), 'Data  berhasil di ambil'
        );
    }

}
