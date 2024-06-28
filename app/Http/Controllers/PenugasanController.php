<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    public function index()
    {
        $penugasans = Penugasan::with(['kegiatan'])
            ->orderBy('kegiatan_id', 'desc')
            ->orderBy('nama_mitra', 'asc')
            ->paginate(7);

        return view('tabel-penugasan', [
            'title'         => 'Tabel Penugasan',
            'penugasans'    => $penugasans
        ]);
    }

    public function show(Penugasan $penugasan)
    {
        return view('detail-penugasan', [
            'title'     => 'Tabel Penugasan',
            'penugasan' => $penugasan
        ]);
    }
}
