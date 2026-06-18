<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'kode_servis',
    'pelanggan_id',
    'teknisi_id',
    'nama_perangkat',
    'jenis_kerusakan',
    'status',
    'estimasi_biaya',
    'biaya_final',
    'catatan_teknisi',
    'tgl_masuk',
    'tgl_estimasi_selesai',
    'tgl_selesai'
])]
class Servis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servis';

    protected $casts = [
        'tgl_masuk' => 'datetime',
        'tgl_estimasi_selesai' => 'date',
        'tgl_selesai' => 'datetime',
        'estimasi_biaya' => 'decimal:2',
        'biaya_final' => 'decimal:2',
    ];

    /**
     * Relasi ke Pelanggan.
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    /**
     * Relasi ke Teknisi.
     */
    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class);
    }

    /**
     * Relasi ke RiwayatStatus.
     */
    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatus::class, 'servis_id');
    }

    /**
     * Booted method untuk auto-generate kode_servis.
     */
    protected static function booted()
    {
        static::creating(function ($servis) {
            if (empty($servis->kode_servis)) {
                $date = now()->format('Ymd');
                // Hitung jumlah servis hari ini
                $todayCount = static::whereDate('tgl_masuk', now()->toDateString())->count();
                $sequence = str_pad($todayCount + 1, 4, '0', STR_PAD_LEFT);
                $code = "SRV-{$date}-{$sequence}";
                
                // Pastikan unik
                while (static::where('kode_servis', $code)->exists()) {
                    $todayCount++;
                    $sequence = str_pad($todayCount + 1, 4, '0', STR_PAD_LEFT);
                    $code = "SRV-{$date}-{$sequence}";
                }
                
                $servis->kode_servis = $code;
            }
        });
    }
}
