<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class StudentInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "student_info";

    protected $fillable = [
        'aday_no',
        'aday_resim',
        'basvuru_tarihi',
        'onay_tarihi',
        'kimlik_no',
        'ad_soyad',
        'baba_adi',
        'dogum_yeri',
        'dogum_tarihi',
        'uyruk',
        'cinsiyet',
        'tel_no',
        'email',
        'mazuniyet_tarihi'
    ];

}
