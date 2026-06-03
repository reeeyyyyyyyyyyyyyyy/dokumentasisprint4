<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanDana extends Model
{
    protected $table = 'pengajuan_dana';

    protected $guarded = [];

    public function laporanInfrastruktur()
    {
        return $this->belongsTo(LaporanInfrastruktur::class, 'id_laporan');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
