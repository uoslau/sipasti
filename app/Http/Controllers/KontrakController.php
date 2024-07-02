<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kegiatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PetugasKegiatan;

class KontrakController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::with(['petugasKegiatan'])
            ->select('id', 'nama_kegiatan', 'slug', 'tanggal_mulai', 'tanggal_selesai', 'mata_anggaran_id', 'fungsi_id')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        $groupedKegiatan = $kegiatan->groupBy(function ($item) {
            $date = Carbon::parse($item->tanggal_mulai);
            $month = $date->format('F');
            $year = $date->format('Y');
            return "$month $year";
        });

        $groupedKegiatanWithSlug = $groupedKegiatan->mapWithKeys(function ($items, $key) {
            $slug = Str::slug($key);
            return [
                $key => [
                    'slug' => $slug,
                    'kegiatan' => $items
                ]
            ];
        });

        return view('kontrak.index', [
            'title' => 'Kontrak',
            'groupedKegiatan' => $groupedKegiatanWithSlug
        ]);
    }

    public function show($slug)
    {
        $kegiatan = PetugasKegiatan::all();

        return view('kontrak.show', [
            'title' => 'Kontrak - ' . str_replace('-', ' ', $slug),
            'kegiatan' => $kegiatan
        ]);
    }
}
