<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lembur extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pegawai_id',
        'tgl_lembur',
        'mulai',
        'akhir',
        'pengajuan_awal',
        'pengajuan_akhir',
        'durasi_pengajuan',
        'harga',
    ];
}
