<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kegiatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PetugasKegiatan;

class DashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');

        $kegiatan = Kegiatan::with(['petugasKegiatan'])
            ->select('id', 'nama_kegiatan', 'slug', 'tanggal_mulai', 'tanggal_selesai', 'mata_anggaran_id', 'fungsi_id')
            ->withSum('petugasKegiatan', 'honor')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        $groupedKegiatanHonor = $kegiatan->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_mulai)->year;
        });

        $totalHonorByYear = $groupedKegiatanHonor->mapWithKeys(function ($items, $year) {
            $totalHonor = $items->sum('petugas_kegiatan_sum_honor');
            return [$year => $totalHonor];
        });

        $currentYear = now()->year;
        $currentYearTotalHonor = $totalHonorByYear[$currentYear] ?? 0;
        $totalKegiatan = $groupedKegiatanHonor[$currentYear]->count() ?? 0;

        $latestKegiatan = Kegiatan::latest('id')->first();

        $groupedKegiatan = $kegiatan->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_mulai)->isoFormat('MMMM YYYY');
        });

        $kegiatanWithSlug = $groupedKegiatan->mapWithKeys(function ($items, $key) {
            $slug = Str::slug($key);
            return [$key => ['items' => $items, 'slug' => $slug]];
        });

        $totalHonorPerMonth = $kegiatan->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_mulai)->format('Y-m');
        })->map(function ($group) {
            return $group->sum('petugas_kegiatan_sum_honor');
        });

        $penugasan = PetugasKegiatan::with(['kegiatan'])
            ->orderBy('kegiatan_id', 'desc')
            ->orderBy('nama_mitra', 'asc')
            ->paginate(7);

        // dd($totalHonorPerMonth);
        // dd($kegiatanWithSlug);

        return view('/dashboard', [
            'title'             => 'Dashboard',
            'totalHonor'        => $currentYearTotalHonor,
            'totalKegiatan'     => $totalKegiatan,
            'latestKegiatan'    => $latestKegiatan,
            'kontrak'           => $kegiatanWithSlug,
            'totalHonorPerMonth' => $totalHonorPerMonth,
            'penugasan'         => $penugasan
        ]);
    }
}
