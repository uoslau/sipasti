<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PetugasImport;
use App\Models\PetugasKegiatan;
use Maatwebsite\Excel\Facades\Excel;

class PetugasKegiatanController extends Controller
{
    public function import(Request $request)
    {
        $kegiatanId = $request->input('kegiatan_id');
        Excel::import(new PetugasImport($kegiatanId), $request->file('excel_file'));

        return redirect()->back();
    }
    public function index()
    {
        $penugasan = PetugasKegiatan::with(['kegiatan'])
            ->orderBy('kegiatan_id', 'desc')
            ->orderBy('nama_mitra', 'asc')
            ->paginate(7);

        return view('penugasan.index', [
            'title'         => 'Penugasan',
            'penugasan'     => $penugasan
        ]);
    }

    // public function show(Penugasan $penugasan)
    // {
    //     return view('detail-penugasan', [
    //         'title'     => 'Tabel Penugasan',
    //         'penugasan' => $penugasan
    //     ]);
    // }
}
