<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'program_by', 'types', 'description', 'target_amount', 'collage_amount', 'end_program', 'banner_program' 
    ];

     public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getBannerProgram(){
        config('app.url') . Storage::url($this->attributes['banner_program']);
    }
}
