<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['servis_id', 'status_lama', 'status_baru', 'catatan', 'changed_by'])]
class RiwayatStatus extends Model
{
    use HasFactory;

    protected $table = 'riwayat_status';

    /**
     * Relasi ke Servis.
     */
    public function servis()
    {
        return $this->belongsTo(Servis::class, 'servis_id');
    }

    /**
     * Relasi ke User yang mengubah status.
     */
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
