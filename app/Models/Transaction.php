<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_id', 'user_id', 'user_name', 'phone_user', 'user_email' ,'amount_final', 'status',  'payment_url', 'doa_donatur', 'bank_transfer', 'expired_date',
    ];


    public function program(){
        return $this->hasOne(Program::class, 'id', 'program_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCreatedAtAttribute($created_at){
        return Carbon::parse($created_at)
            ->getPreciseTimestamp(3);
    }

    public function getUpdatedAtAttribute($updated_at){
        return Carbon::parse($updated_at)
            ->getPreciseTimestamp(3);
    }


}
