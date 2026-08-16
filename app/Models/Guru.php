<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'no_hp',
        'status',
    ];

    public function pengajaran(): HasMany
    {
        return $this->hasMany(Pengajaran::class);
    }
}
