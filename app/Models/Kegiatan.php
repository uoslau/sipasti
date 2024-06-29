<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mataAnggaran()
    {
        return $this->belongsTo(MataAnggaran::class, 'mata_anggaran_id');
    }

    public function fungsi()
    {
        return $this->belongsTo(Fungsi::class, 'fungsi_id');
    }

    public function petugasKegiatan()
    {
        return $this->hasMany(PetugasKegiatan::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // public function penugasan()
    // {
    //     return $this->hasMany(Penugasan::class);
    // }

    // public function mitra()
    // {
    //     return $this->belongsTo(Mitra::class);
    // }

}
