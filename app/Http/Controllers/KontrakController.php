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
            $date   = Carbon::parse($item->tanggal_mulai);
            $month  = $date->format('F');
            $year   = $date->format('Y');
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
            'title'             => 'Kontrak',
            'groupedKegiatan'   => $groupedKegiatanWithSlug
        ]);
    }

    public function show($slug)
    {
        $formattedSlug = str_replace('-', ' ', $slug);
        $date   = Carbon::createFromFormat('F Y', $formattedSlug);
        $month  = $date->format('m');
        $year   = $date->format('Y');

        $kegiatanBulan = Kegiatan::with('petugasKegiatan')
            ->whereYear('tanggal_mulai', $year)
            ->whereMonth('tanggal_mulai', $month)
            ->get();

        $petugasBulan = PetugasKegiatan::whereHas('kegiatan', function ($query) use ($year, $month) {
            $query->whereYear('tanggal_mulai', $year)
                ->whereMonth('tanggal_mulai', $month);
        })->get();

        $petugasData = $petugasBulan->groupBy('sktnp')->map(function ($items, $sktnp) {
            $totalHonor = $items->sum('honor');
            $jumlahKegiatan = $items->count();
            return [
                'sktnp' => $sktnp,
                'nama_mitra' => $items->first()->nama_mitra,
                'total_honor' => $totalHonor,
                'jumlah_kegiatan' => $jumlahKegiatan,
            ];
        });

        $petugasUnik = PetugasKegiatan::whereHas('kegiatan', function ($query) use ($year, $month) {
            $query->whereYear('tanggal_mulai', $year)
                ->whereMonth('tanggal_mulai', $month);
        })->distinct('sktnp')->get('sktnp');

        return view('kontrak.show', [
            'title'         => 'Kontrak - ' . $date->format('F Y'),
            'kegiatanBulan' => $kegiatanBulan,
            'petugasBulan'  => $petugasData,
            'petugasUnik'   => $petugasUnik
        ]);
    }
}
