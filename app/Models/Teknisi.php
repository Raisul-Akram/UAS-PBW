<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama', 'no_hp', 'spesialisasi', 'status_aktif'])]
class Teknisi extends Model
{
    use HasFactory;

    /**
     * Relasi ke Servis.
     */
    public function servis()
    {
        return $this->hasMany(Servis::class);
    }
}
