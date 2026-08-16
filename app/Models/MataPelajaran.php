<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'kode',
        'nama',
        'kelompok',
        'deskripsi',
        'status',
    ];

    public function pengajaran(): HasMany
    {
        return $this->hasMany(Pengajaran::class);
    }
}
