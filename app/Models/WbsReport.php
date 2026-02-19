<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WbsReport extends Model
{
    protected $fillable = [
        'nama_pelapor',
        'kontak_pelapor',
        'hubungan',
        'jenis_pelanggaran',
        'deskripsi',
        'tanggal_kejadian',
        'waktu_kejadian',
        'lokasi',
        'terlapor',
        'saksi',
        'bukti',
        'foto_bukti',
        'video_bukti',
        'dampak',
        'harapan',
    ];

    public function files()
    {
        return $this->hasMany(WbsFile::class);
    }
}
