<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $mitra = Mitra::orderBy('nama_mitra', 'asc')->paginate(8);

        return view('mitra', [
            'title'     => 'Tabel Mitra',
            'mitra'     => $mitra
        ]);
    }
}
