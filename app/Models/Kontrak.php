<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    use HasFactory;

    public function petugasKegiatan()
    {
        return $this->belongsTo(PetugasKegiatan::class);
    }
}