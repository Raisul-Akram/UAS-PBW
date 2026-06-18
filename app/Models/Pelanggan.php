<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'no_hp', 'alamat'])]
class Pelanggan extends Model
{
    use HasFactory;

    /**
     * Relasi ke User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Servis.
     */
    public function servis()
    {
        return $this->hasMany(Servis::class);
    }
}
