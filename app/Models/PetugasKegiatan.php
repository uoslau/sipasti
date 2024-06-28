<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasKegiatan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }
}
