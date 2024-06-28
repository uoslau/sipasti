<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fungsi extends Model
{
    use HasFactory;

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'fungsi_id');
    }
}
