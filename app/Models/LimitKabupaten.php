<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitKabupaten extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'limit_kabupaten';

    protected $guarded = ['id'];

    public function kontrak()
    {
        return $this->hasMany(Kontrak::class);
    }
}
