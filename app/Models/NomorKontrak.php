<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorKontrak extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'nomor_kontrak';

    protected $guarded = ['id'];
}
