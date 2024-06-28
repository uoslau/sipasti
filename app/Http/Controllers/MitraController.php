<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        return view('mitra', [
            'title' => 'Mitra BPS Kabupaten Nias',
            'mitra' => Mitra::orderBy('nama_mitra', 'asc')->paginate(10)
        ]);
    }
}
