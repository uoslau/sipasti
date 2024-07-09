<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kegiatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
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

        $latestKegiatan = Kegiatan::latest('id')->first();

        $groupedKegiatan = $kegiatan->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_mulai)->isoFormat('MMMM YYYY');
        });

        $kegiatanWithSlug = $groupedKegiatan->mapWithKeys(function ($items, $key) {
            $slug = Str::slug($key);
            return [$key => ['items' => $items, 'slug' => $slug]];
        });

        return view('/dashboard', [
            'title'             => 'Dashboard',
            'totalHonor'        => $currentYearTotalHonor,
            'latestKegiatan'    => $latestKegiatan,
            'kontrak'           => $kegiatanWithSlug,
        ]);
    }
}
