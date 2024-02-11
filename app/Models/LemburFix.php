<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LemburFix extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'gol',
        'tgl_lembur',
        'mulai',
        'akhir',
        'pengajuan_awal',
        'pengajuan_akhir',
        'durasi_pengajuan',
        'harga',
    ];
}
