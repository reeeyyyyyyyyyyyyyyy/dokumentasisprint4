<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanInfrastruktur extends Model
{
    protected $table = 'laporan_infrastruktur';

    protected $guarded = [];

    public function daerah()
    {
        return $this->belongsTo(Daerah::class, 'id_daerah');
    }

    public function analisisAi()
    {
        return $this->hasOne(AnalisisAi::class, 'id_laporan');
    }

    public function pengajuanDana()
    {
        return $this->hasMany(PengajuanDana::class, 'id_laporan');
    }

    public function ulasanLaporan()
    {
        return $this->hasMany(UlasanLaporan::class, 'laporan_infrastruktur_id');
    }

    // =========================================================
    // SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
    // =========================================================
    public function timeline()
    {
        return $this->hasMany(LaporanTimeline::class, 'laporan_infrastruktur_id')->oldest();
    }
    // =========================================================
}
