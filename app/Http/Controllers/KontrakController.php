<?php

namespace App\Http\Controllers;

use ZipArchive;
use Carbon\Carbon;
use App\Models\Kegiatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\NumberToWords;
use App\Models\LimitKabupaten;
use App\Models\PetugasKegiatan;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;

class KontrakController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');

        $kegiatan = Kegiatan::with(['petugasKegiatan'])
            ->select('id', 'nama_kegiatan', 'slug', 'tanggal_mulai', 'tanggal_selesai', 'mata_anggaran_id', 'fungsi_id')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        $groupedKegiatan = $kegiatan->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_mulai)->isoFormat('MMMM YYYY');
        });

        $kegiatanWithSlug = $groupedKegiatan->mapWithKeys(function ($items, $key) {
            $slug = Str::slug($key);
            return [$key => ['items' => $items, 'slug' => $slug]];
        });
        dd($kegiatanWithSlug);

        return view('kontrak.index', [
            'title'             => 'Kontrak',
            'groupedKegiatan'   => $kegiatanWithSlug
        ]);
    }

    public function show($slug)
    {
        Carbon::setLocale('id');

        $dateString = str_replace('-', ' ', $slug);

        $months = [
            'januari' => 'January',
            'februari' => 'February',
            'maret' => 'March',
            'april' => 'April',
            'mei' => 'May',
            'juni' => 'June',
            'juli' => 'July',
            'agustus' => 'August',
            'september' => 'September',
            'oktober' => 'October',
            'november' => 'November',
            'desember' => 'December',
        ];

        foreach ($months as $indonesian => $english) {
            if (strpos($dateString, $indonesian) !== false) {
                $dateString = str_replace($indonesian, $english, $dateString);
                break;
            }
        }

        $date = Carbon::createFromFormat('F Y', $dateString);

        $kegiatan = Kegiatan::with(['petugasKegiatan'])
            ->whereMonth('tanggal_mulai', $date->month)
            ->whereYear('tanggal_mulai', $date->year)
            ->get();

        $limitHonor = DB::table('limit_kabupaten')->pluck('honor_max', 'kode_kabupaten');

        $totalHonorPerPetugas = $kegiatan->flatMap(function ($item) {
            return $item->petugasKegiatan;
        })->groupBy('sktnp')->map(function ($items, $sktnp) use ($limitHonor) {
            $wilayahTugas = $items->first()->wilayah_tugas;
            $honorMax = $limitHonor->get($wilayahTugas, 0);
            return [
                'sktnp' => $sktnp,
                'nama_mitra' => $items->first()->nama_mitra,
                'total_honor' => $items->sum('honor'),
                'wilayah_tugas' => $wilayahTugas,
                'honor_max' => $honorMax
            ];
        })->sortBy('nama_mitra')->values();

        return view('kontrak.show', [
            'title' => 'Mitra Bulanan',
            'petugas' => $totalHonorPerPetugas,
        ]);
    }

    public function generateAllKontrak($slug)
    {
        Carbon::setLocale('id');

        $dateString = str_replace('-', ' ', $slug);

        $months = [
            'januari' => 'January',
            'februari' => 'February',
            'maret' => 'March',
            'april' => 'April',
            'mei' => 'May',
            'juni' => 'June',
            'juli' => 'July',
            'agustus' => 'August',
            'september' => 'September',
            'oktober' => 'October',
            'november' => 'November',
            'desember' => 'December',
        ];

        foreach ($months as $indonesian => $english) {
            if (strpos($dateString, $indonesian) !== false) {
                $dateString = str_replace($indonesian, $english, $dateString);
                break;
            }
        }

        $date = Carbon::createFromFormat('F Y', $dateString);

        $kegiatanList = PetugasKegiatan::whereMonth('tanggal_mulai', $date->month)
            ->whereYear('tanggal_mulai', $date->year)
            ->get();
        // dd($kegiatanList);
        if ($kegiatanList->isEmpty()) {
            return response()->json(['error' => 'Belum ada kegiatan pada bulan tersebut.'], 404);
        }

        $petugasKegiatan = [];
        foreach ($kegiatanList as $kegiatan) {
            $petugasId = $kegiatan->sktnp;
            if (!isset($petugasKegiatan[$petugasId])) {
                $petugasKegiatan[$petugasId] = [
                    'petugas' => $kegiatan->nama_mitra,
                    'kegiatan' => []
                ];
            }
            $petugasKegiatan[$petugasId]['kegiatan'][] = $kegiatan;
        }
        // dd($petugasKegiatan);

        $templatePath = storage_path('app/public/template/template_kontrak.docx');

        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template file not found.'], 404);
        }

        $zip = new ZipArchive();
        $zipFileName = storage_path('app/public/kontrak/Kontrak_' . str_replace('-', '_', ucwords($slug)) . '.zip');

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return response()->json(['error' => 'Could not create zip file.'], 500);
        }

        $wordFiles = [];

        foreach ($petugasKegiatan as $p) {
            $templateProcessor = new TemplateProcessor($templatePath);

            $currentDate = Carbon::now();
            $tanggal = $currentDate->format('d');
            $bulan = NumberToWords::monthName($currentDate->format('m'));
            $tahun = $currentDate->format('Y');
            $hari = NumberToWords::dayName($currentDate->format('l'));

            $kegiatanList = $p['kegiatan'];
            $total_honor = array_sum(array_column($kegiatanList, 'honor'));
            $total_honor_terbilang = NumberToWords::toWords($total_honor);
            // dd($kegiatanList);
            $kegiatanDate = Carbon::createFromFormat('Y-m-d', $kegiatanList[0]->tanggal_mulai);
            $tanggal_kegiatan = $kegiatanDate->format('d');
            $bulan_kegiatan = NumberToWords::monthName($kegiatanDate->format('m'));
            $tahun_kegiatan = $kegiatanDate->format('Y');

            $data = [
                'bulan_kegiatan_kapital'    => strtoupper($bulan_kegiatan),
                'tahun_kegiatan'            => $tahun_kegiatan,
                'nomor_kontrak'             => $kegiatanList[0]->nomor_kontrak,
                'hari'                      => $hari,
                'tanggal_terbilang'         => ucfirst(NumberToWords::toWords($tanggal)),
                'bulan'                     => $bulan,
                'tahun_terbilang'           => ucfirst(NumberToWords::toWords($tahun)),
                'nama_mitra'                => ucwords(strtolower($p['petugas'])),
                'pekerjaan'                 => $kegiatanList[0]->pekerjaan,
                'alamat'                    => $kegiatanList[0]->alamat,
                'bulan_kegiatan'            => $bulan_kegiatan,
                'total_honor'               => number_format($total_honor, 0, ',', '.'),
                'total_honor_terbilang'     => ucfirst($total_honor_terbilang),

                // 'sktnp' => $petugasId,
                // 'tahun' => $tahun,
            ];

            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, $value);
            }

            $templateProcessor->cloneRow('nama_kegiatan', count($kegiatanList));
            // dd($kegiatanList);
            foreach ($kegiatanList as $index => $k) {
                $rowIndex = $index + 1;
                $tanggal_mulai = is_string($k->tanggal_mulai) ? Carbon::parse($k->tanggal_mulai) : $k->tanggal_mulai;
                $tanggal_selesai = is_string($k->tanggal_selesai) ? Carbon::parse($k->tanggal_selesai) : $k->tanggal_selesai;

                $templateProcessor->setValue("no#$rowIndex", $rowIndex);
                $templateProcessor->setValue("nama_kegiatan#$rowIndex", $k->kegiatan->nama_kegiatan);
                $templateProcessor->setValue("tanggal_mulai#$rowIndex", $tanggal_mulai->format('d/m/Y'));
                $templateProcessor->setValue("tanggal_selesai#$rowIndex", $tanggal_selesai->format('d/m/Y'));
                $templateProcessor->setValue("beban#$rowIndex", $k->beban);
                $templateProcessor->setValue("satuan#$rowIndex", $k->satuan);
                $templateProcessor->setValue("honor#$rowIndex", number_format($k->honor, 0, ',', '.'));
                $templateProcessor->setValue("mata_anggaran#$rowIndex", $k->kegiatan->mataAnggaran->mata_anggaran);
            }
            $outputPath = storage_path('app/public/bast/KONTRAK_' . str_replace(' ', '_', $data['nama_mitra']) . '.docx');
            $templateProcessor->saveAs($outputPath);
            $zip->addFile($outputPath, 'KONTRAK_' . str_replace(' ', '_', $data['nama_mitra']) . '.docx');
            $wordFiles[] = $outputPath;
        }
        // dd($data);

        $zip->close();

        foreach ($wordFiles as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
}
