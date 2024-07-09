<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasKegiatan extends Model
{
    public $timestamps = false;

    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['honor'];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function fungsi()
    {
        return $this->belongsTo(Fungsi::class);
    }

    public function kontrak()
    {
        return $this->hasMany(Kontrak::class);
    }

    public function limitKabupaten()
    {
        return $this->belongsTo(LimitKabupaten::class);
    }
}
